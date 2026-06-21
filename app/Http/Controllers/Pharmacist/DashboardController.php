<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $today = now()->startOfDay();
        $monthStart = now()->startOfMonth();

        $stats = [
            'new_prescriptions' => Prescription::where('status', 'pending')->count(),
            'preparing_prescriptions' => Prescription::where('status', 'preparing')->count(),
            'ready_prescriptions' => Prescription::where('status', 'ready')->count(),
            'delivered_prescriptions' => Prescription::where('status', 'delivered')->count(),
            'total_medicines' => Medicine::where('is_active', true)->count(),
            'available_medicines' => Medicine::where('is_active', true)->where('stock', '>', 0)->count(),
            'low_stock_medicines' => Medicine::where('is_active', true)->whereColumn('stock', '<=', 'low_stock_threshold')->count(),
            'expiring_soon' => Medicine::where('expiration_date', '<=', now()->addDays(30))
                ->where('expiration_date', '>=', now())
                ->where('is_active', true)
                ->count(),
            'today_prescriptions' => Prescription::whereDate('created_at', '>=', $today)->count(),
            'today_invoices' => Invoice::whereDate('created_at', '>=', $today)->count(),
            'today_sales' => Invoice::where('status', 'paid')->whereDate('paid_at', '>=', $today)->sum('total_amount'),
            'month_sales' => Invoice::where('status', 'paid')->where('paid_at', '>=', $monthStart)->sum('total_amount'),
            'patients_served' => Prescription::where('status', 'delivered')->distinct('patient_id')->count(),
        ];

        // Recent prescriptions
        $recentPrescriptions = Prescription::with(['patient.user', 'doctor.user'])
            ->latest()
            ->take(5)
            ->get();

        // Low stock medicines
        $lowStockMedicines = Medicine::whereColumn('stock', '<=', 'low_stock_threshold')
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // Expiring soon medicines
        $expiringSoonMedicines = Medicine::where('expiration_date', '<=', now()->addDays(30))
            ->where('expiration_date', '>=', now())
            ->where('is_active', true)
            ->orderBy('expiration_date', 'asc')
            ->take(5)
            ->get();

        return view('pharmacist.dashboard', compact(
            'stats',
            'recentPrescriptions',
            'lowStockMedicines',
            'expiringSoonMedicines'
        ));
    }
}
