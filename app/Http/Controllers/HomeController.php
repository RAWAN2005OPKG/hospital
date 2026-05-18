<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with("user", "specialization", "department")->take(4)->get();
        $departments = Department::take(4)->get();
        return view("home", compact("doctors", "departments"));
    }

    public function about()
    {
        return view("about");
    }

    public function contact()
    {
        return view("contact");
    }

    public function servicesEmergency() { return view('services.emergency'); }
    public function servicesLab() { return view('services.lab'); }
    public function servicesRadiology() { return view('services.radiology'); }
    public function servicesPharmacy() { return view('services.pharmacy'); }
}