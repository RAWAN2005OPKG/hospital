@extends('layouts.app')
@section('title', 'تفاصيل المريض')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-user"></i> {{ $patient->user->name ?? 'المريض' }}</h1>
        <a href="{{ route('pharmacist.patients.index') }}" class="btn btn-secondary">عودة</a>
    </div>

    <!-- Patient Info -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>معلومات المريض</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>الاسم:</strong> {{ $patient->user->name ?? '-' }}</p>
                    <p><strong>البريد الإلكتروني:</strong> {{ $patient->user->email ?? '-' }}</p>
                    <p><strong>رقم الهاتف:</strong> {{ $patient->user->phone ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>تاريخ الميلاد:</strong> {{ $patient->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '-' }}</p>
                    <p><strong>الجنس:</strong> {{ $patient->gender ?? '-' }}</p>
                    <p><strong>تاريخ التسجيل:</strong> {{ $patient->user->created_at ? $patient->user->created_at->format('Y-m-d') : '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>إجمالي الوصفات</h5>
                    <h3>{{ $stats['total_prescriptions'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>تم التسليم</h5>
                    <h3>{{ $stats['delivered_prescriptions'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h5>قيد الانتظار</h5>
                    <h3>{{ $stats['pending_prescriptions'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h5>إجمالي الإنفاق</h5>
                    <h3>{{ number_format($stats['total_spent'], 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="patientTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#prescriptions">الوصفات</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#invoices">الفواتير</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#medicines">الأدوية المصروفة</a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Prescriptions Tab -->
        <div class="tab-pane fade show active" id="prescriptions">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>رقم الوصفة</th>
                                    <th>الطبيب</th>
                                    <th>التاريخ</th>
                                    <th>الحالة</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prescriptions as $prescription)
                                <tr>
                                    <td>#{{ $prescription->id }}</td>
                                    <td>{{ $prescription->doctor->user->name ?? '-' }}</td>
                                    <td>{{ $prescription->created_at ? $prescription->created_at->format('Y-m-d') : '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $prescription->status == 'delivered' ? 'success' : ($prescription->status == 'pending' ? 'warning' : 'info') }}">
                                            {{ $prescription->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pharmacist.prescriptions.show', $prescription) }}" class="btn btn-sm btn-info">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices Tab -->
        <div class="tab-pane fade" id="invoices">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>رقم الفاتورة</th>
                                    <th>التاريخ</th>
                                    <th>المبلغ</th>
                                    <th>الحالة</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                <tr>
                                    <td>#{{ $invoice->id }}</td>
                                    <td>{{ $invoice->created_at ? $invoice->created_at->format('Y-m-d') : '-' }}</td>
                                    <td>{{ number_format($invoice->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : 'warning' }}">
                                            {{ $invoice->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pharmacist.invoices.show', $invoice) }}" class="btn btn-sm btn-info">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medicines Tab -->
        <div class="tab-pane fade" id="medicines">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>الدواء</th>
                                    <th>الوصفة</th>
                                    <th>تاريخ الصرف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($medicines as $item)
                                <tr>
                                    <td>{{ $item['medicine']->name }}</td>
                                    <td>#{{ $item['prescription']->id }}</td>
                                    <td>{{ $item['dispensed_at'] ? $item['dispensed_at']->format('Y-m-d H:i') : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
