<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Medicine;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['patient', 'prescription', 'items.medicine'])
            ->where('status', 'paid');

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('paid_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $sales = $query->latest('paid_at')->paginate(20);

        // Calculate statistics
        $today = now()->startOfDay();
        $monthStart = now()->startOfMonth();

        $stats = [
            'today_sales' => Invoice::where('status', 'paid')
                ->where('paid_at', '>=', $today)
                ->sum('total_amount'),
            'month_sales' => Invoice::where('status', 'paid')
                ->where('paid_at', '>=', $monthStart)
                ->sum('total_amount'),
            'today_profit' => $this->calculateProfit($today, now()),
            'month_profit' => $this->calculateProfit($monthStart, now()),
            'today_count' => Invoice::where('status', 'paid')
                ->where('paid_at', '>=', $today)
                ->count(),
            'month_count' => Invoice::where('status', 'paid')
                ->where('paid_at', '>=', $monthStart)
                ->count(),
        ];

        // Top selling medicines
        $topMedicines = Medicine::withCount(['prescriptions as sales_count'])
            ->orderBy('sales_count', 'desc')
            ->take(10)
            ->get();

        return view('pharmacist.sales.index', compact('sales', 'stats', 'topMedicines'));
    }

    private function calculateProfit($startDate, $endDate)
    {
        // Simple profit calculation (can be enhanced with cost price)
        $totalRevenue = Invoice::where('status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->sum('total_amount');

        // Assuming 20% profit margin (can be enhanced with actual cost)
        return $totalRevenue * 0.20;
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'prescription.medicines', 'pharmacist', 'items.medicine']);

        return view('pharmacist.sales.show', compact('invoice'));
    }
}
