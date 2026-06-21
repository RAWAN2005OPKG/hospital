@extends('layouts.app')
@section('title', 'سجل المرضى')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa-solid fa-users"></i> سجل المرضى</h1>
    </div>

    <!-- Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pharmacist.patients.index') }}">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="البحث بالاسم أو البريد الإلكتروني" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">بحث</button>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <a href="{{ route('pharmacist.patients.index') }}" class="btn btn-secondary">إعادة تعيين</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Patients Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>تاريخ التسجيل</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $index => $patient)
                        <tr>
                            <td>{{ ($patients->currentpage() - 1) * $patients->perpage() + $index + 1 }}</td>
                            <td>{{ $patient->user->name ?? '-' }}</td>
                            <td>{{ $patient->user->email ?? '-' }}</td>
                            <td>{{ $patient->user->phone ?? '-' }}</td>
                            <td>{{ $patient->user->created_at ? $patient->user->created_at->format('Y-m-d') : '-' }}</td>
                            <td>
                                <a href="{{ route('pharmacist.patients.show', $patient) }}" class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $patients->links() }}
        </div>
    </div>
</div>
@endsection
