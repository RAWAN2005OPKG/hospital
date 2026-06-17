<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount("doctors")->paginate(12);

        return view("departments.index", compact("departments"));
    }

    public function show(Department $department)
    {
        $doctors = $department->doctors()
            ->with(["user", "specialization", "department"])
            ->orderByDesc("id")
            ->paginate(12);

        return view("departments.show", compact("department", "doctors"));
    }
}

