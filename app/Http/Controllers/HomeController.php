<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // جلب جميع الأقسام مع عدد الأطباء
        $departments = Department::withCount('doctors')->get();
        
        // جلب أفضل 6 أطباء
        $doctors = Doctor::with('user', 'specialization', 'department')
            ->take(6)
            ->get();
        
        return view('home', compact('departments', 'doctors'));
    }
    
    public function about()
    {
        return view('about');
    }
}