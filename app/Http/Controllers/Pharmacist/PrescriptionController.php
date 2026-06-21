<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(['patient.user', 'doctor.user', 'medicines'])
            ->latest()
            ->paginate(15);

        return view('pharmacist.prescriptions.index', compact('prescriptions'));
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['patient.user', 'doctor.user', 'medicines']);
        return view('pharmacist.prescriptions.show', compact('prescription'));
    }

    public function accept(Prescription $prescription)
    {
        if ($prescription->status !== 'pending') {
            return back()->with('error', 'لا يمكن قبول هذه الوصفة.');
        }

        $prescription->update(['status' => 'preparing']);

        return back()->with('success', 'تم قبول الوصفة وبدء التحضير.');
    }

    public function reject(Prescription $prescription, Request $request)
    {
        if ($prescription->status !== 'pending') {
            return back()->with('error', 'لا يمكن رفض هذه الوصفة.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $prescription->update([
            'status' => 'cancelled',
            'notes' => $prescription->notes . "\n\nسبب الرفض: " . $validated['rejection_reason'],
        ]);

        return back()->with('success', 'تم رفض الوصفة.');
    }

    public function markAsReady(Prescription $prescription)
    {
        if ($prescription->status !== 'preparing') {
            return back()->with('error', 'لا يمكن تحضير هذه الوصفة.');
        }

        $prescription->update(['status' => 'ready']);

        return back()->with('success', 'تم تحضير الأدوية وجاهزية الوصفة.');
    }

    public function markAsDelivered(Prescription $prescription)
    {
        if ($prescription->status !== 'ready') {
            return back()->with('error', 'لا يمكن تسليم هذه الوصفة.');
        }

        try {
            DB::transaction(function () use ($prescription) {
                // Deduct stock for each medicine
                foreach ($prescription->medicines as $medicine) {
                    if ($medicine->stock > 0) {
                        $medicine->decrement('stock', 1);
                    }
                }

                $prescription->update(['status' => 'delivered']);
            });

            return back()->with('success', 'تم تسليم الأدوية وتحديث المخزون بنجاح.');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء التحديث.');
        }
    }

    public function createInvoice(Prescription $prescription)
    {
        if ($prescription->status !== 'ready') {
            return back()->with('error', 'لا يمكن إنشاء فاتورة لهذه الوصفة.');
        }

        if ($prescription->invoice) {
            return redirect()->route('pharmacist.invoices.show', $prescription->invoice)
                ->with('info', 'الفاتورة موجودة بالفعل.');
        }

        try {
            DB::transaction(function () use ($prescription) {
                $subtotal = 0;

                $invoice = Invoice::create([
                    'patient_id' => $prescription->patient->user_id,
                    'prescription_id' => $prescription->id,
                    'pharmacist_id' => auth()->id(),
                    'subtotal' => 0,
                    'discount' => 0,
                    'tax' => 0,
                    'total_amount' => 0,
                    'status' => 'pending',
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

                $invoice->update([
                    'subtotal' => $subtotal,
                    'total_amount' => $subtotal,
                ]);
            });

            return redirect()->route('pharmacist.invoices.show', $prescription->invoice)
                ->with('success', 'تم إنشاء الفاتورة بنجاح.');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء إنشاء الفاتورة.');
        }
    }
}
