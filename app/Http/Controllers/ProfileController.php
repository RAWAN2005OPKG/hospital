<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        
        return view('profile.show', compact('user'));
    }
    
    public function edit()
    {
        $user = auth()->user();
        
        return view('profile.edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
        ]);
        
        auth()->user()->update($validated);
        
        return redirect()->route('profile.show')
            ->with('success', 'تم تحديث البيانات بنجاح');
    }
    
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()->back()
            ->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}