<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::firstOrCreate([]);
        return view("admin.settings", compact("settings"));
    }

    public function update(Request $request)
    {
        $settings = Setting::firstOrCreate([]);

        $request->validate([
            "site_name" => "required|string|max:255",
            "logo" => "nullable|image|max:2048",
            "email" => "required|email|max:255",
            "phone" => "required|string|max:20",
            "address" => "nullable|string|max:255",
            "maintenance_mode" => "boolean",
        ]);

        $settings->update($request->only(["site_name", "email", "phone", "address", "maintenance_mode"]));

        if ($request->hasFile("logo")) {
            if ($settings->logo) {
                Storage::disk("public")->delete($settings->logo);
            }
            $settings->logo = $request->file("logo")->store("settings", "public");
            $settings->save();
        }

        return back()->with("success", "تم تحديث الإعدادات بنجاح.");
    }
}