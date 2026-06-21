<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        return view('pharmacist.reports.index');
    }

    public function dailySales(Request $request)
    {
        $date = $request->date ?? now()->toDateString();

        $sales = Invoice::where('status', 'paid')
            ->whereDate('paid_at', $date)
            ->with(['patient', 'items.medicine'])
            ->get();

        $total = $sales->sum('total_amount');
        $count = $sales->count();

        return view('pharmacist.reports.daily_sales', compact('sales', 'total', 'count', 'date'));
    }

    public function monthlySales(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $sales = Invoice::where('status', 'paid')
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->with(['patient', 'items.medicine'])
            ->get();

        $total = $sales->sum('total_amount');
        $count = $sales->count();

        // Group by day
        $dailyData = $sales->groupBy(function ($item) {
            return $item->paid_at->format('Y-m-d');
        });

        return view('pharmacist.reports.monthly_sales', compact('sales', 'total', 'count', 'month', 'year', 'dailyData'));
    }

    public function topSellingMedicines(Request $request)
    {
        $startDate = $request->start_date ?? now()->subDays(30)->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();

        $medicines = Medicine::select('medicines.*', DB::raw('COUNT(prescription_medicines.medicine_id) as sales_count'))
            ->join('prescription_medicines', 'medicines.id', '=', 'prescription_medicines.medicine_id')
            ->join('prescriptions', 'prescription_medicines.prescription_id', '=', 'prescriptions.id')
            ->whereBetween('prescriptions.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('prescriptions.status', 'delivered')
            ->groupBy('medicines.id')
            ->orderBy('sales_count', 'desc')
            ->paginate(20);

        return view('pharmacist.reports.top_selling', compact('medicines', 'startDate', 'endDate'));
    }

    public function lowStockMedicines()
    {
        $medicines = Medicine::whereColumn('stock', '<=', 'low_stock_threshold')
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->get();

        return view('pharmacist.reports.low_stock', compact('medicines'));
    }

    public function expiringMedicines()
    {
        $medicines = Medicine::where('expiration_date', '<=', now()->addDays(90))
            ->where('expiration_date', '>=', now())
            ->where('is_active', true)
            ->orderBy('expiration_date', 'asc')
            ->get();

        return view('pharmacist.reports.expiring', compact('medicines'));
    }

    public function exportDailySales(Request $request)
    {
        $date = $request->date ?? now()->toDateString();

        $sales = Invoice::where('status', 'paid')
            ->whereDate('paid_at', $date)
            ->with(['patient', 'items.medicine'])
            ->get();

        // For PDF export, you would use a package like dompdf or snappy
        // For Excel export, you would use laravel-excel
        // This is a placeholder for the export functionality

        return back()->with('info', 'سيتم إضافة وظيفة التصدير قريباً');
    }

    public function exportMonthlySales(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        // Placeholder for export functionality

        return back()->with('info', 'سيتم إضافة وظيفة التصدير قريباً');
    }
}
