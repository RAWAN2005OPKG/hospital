<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['patient', 'prescription', 'items.medicine'])
            ->latest()
            ->paginate(20);

        return view('pharmacist.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $prescriptions = Prescription::where('status', 'pending')
            ->with(['patient.user', 'medicines'])
            ->get();

        return view('pharmacist.invoices.create', compact('prescriptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|in:cash,card,insurance',
            'notes' => 'nullable|string',
        ]);

        $prescription = Prescription::with(['medicines', 'patient.user'])->findOrFail($validated['prescription_id']);

        DB::transaction(function () use ($request, $prescription, $validated) {
            $subtotal = 0;

            $invoice = Invoice::create([
                'patient_id' => $prescription->patient->user_id,
                'prescription_id' => $prescription->id,
                'pharmacist_id' => auth()->id(),
                'subtotal' => 0,
                'discount' => $validated['discount'] ?? 0,
                'tax' => $validated['tax'] ?? 0,
                'total_amount' => 0,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($prescription->medicines as $medicine) {
                $itemSubtotal = $medicine->price * 1;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'medicine_id' => $medicine->id,
                    'quantity' => 1,
                    'unit_price' => $medicine->price,
                    'discount' => 0,
                    'subtotal' => $itemSubtotal,
                ]);

                $subtotal += $itemSubtotal;
            }

            $totalAmount = $subtotal - ($validated['discount'] ?? 0) + ($validated['tax'] ?? 0);

            $invoice->update([
                'subtotal' => $subtotal,
                'total_amount' => $totalAmount,
            ]);

            $prescription->update(['status' => 'ready']);
        });

        return redirect()->route('pharmacist.invoices.index')
            ->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'prescription.medicines', 'pharmacist', 'items.medicine']);

        return view('pharmacist.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'لا يمكن تعديل فاتورة مدفوعة');
        }

        $invoice->load(['items.medicine']);

        return view('pharmacist.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'لا يمكن تعديل فاتورة مدفوعة');
        }

        $validated = $request->validate([
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|in:cash,card,insurance',
            'notes' => 'nullable|string',
        ]);

        $subtotal = $invoice->items->sum('subtotal');
        $totalAmount = $subtotal - ($validated['discount'] ?? 0) + ($validated['tax'] ?? 0);

        $invoice->update([
            'discount' => $validated['discount'] ?? 0,
            'tax' => $validated['tax'] ?? 0,
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'] ?? $invoice->payment_method,
            'notes' => $validated['notes'] ?? $invoice->notes,
        ]);

        return redirect()->route('pharmacist.invoices.show', $invoice)
            ->with('success', 'تم تحديث الفاتورة بنجاح');
    }

    public function markAsPaid(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'هذه الفاتورة مدفوعة بالفعل');
        }

        DB::transaction(function () use ($invoice) {
            $invoice->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            if ($invoice->prescription) {
                $invoice->prescription->update(['status' => 'delivered']);
            }
        });

        return back()->with('success', 'تم دفع الفاتورة بنجاح');
    }

    public function cancel(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'لا يمكن إلغاء فاتورة مدفوعة');
        }

        $invoice->update(['status' => 'cancelled']);

        return back()->with('success', 'تم إلغاء الفاتورة بنجاح');
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'لا يمكن حذف فاتورة مدفوعة');
        }

        $invoice->delete();

        return redirect()->route('pharmacist.invoices.index')
            ->with('success', 'تم حذف الفاتورة بنجاح');
    }
}
