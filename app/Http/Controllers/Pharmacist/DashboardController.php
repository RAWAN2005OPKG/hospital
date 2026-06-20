<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'new_prescriptions' => Prescription::where('status', 'pending')->count(),
            'delivered_prescriptions' => Prescription::where('status', 'delivered')->count(),
            'available_medicines' => Medicine::where('is_active', true)->where('stock', '>', 0)->count(),
            'low_stock_medicines' => Medicine::where('is_active', true)->whereColumn('stock', '<=', 'low_stock_threshold')->count(),
        ];

        return view('pharmacist.dashboard', compact('stats'));
    }
}
