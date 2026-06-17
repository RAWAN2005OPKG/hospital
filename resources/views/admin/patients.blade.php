@extends('layouts.dashboard')

@section('title', 'إدارة المرضى')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">إدارة المرضى</h1>
        <p class="page-subtitle">عرض وإدارة جميع المرضى المسجلين في النظام</p>
    </div>
</div>

<!-- Filters & Search -->
<div class="card" style="background: rgba(0, 102, 204, 0.02); border: 1px solid rgba(0, 102, 204, 0.1); margin-bottom: 2rem;">
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 1rem; padding: 1.5rem;">
        <div class="form-group" style="margin: 0;">
            <label class="form-label">بحث بالاسم أو الهاتف</label>
            <input type="text" placeholder="ابحث..." class="form-control">
        </div>
        <div class="form-group" style="margin: 0;">
            <label class="form-label">الحالة</label>
            <select class="form-control">
                <option>الحالة</option>
                <option>نشط</option>
                <option>غير نشط</option>
                <option>تحت المراقبة</option>
            </select>
        </div>
        <div class="form-group" style="margin: 0;">
            <label class="form-label">التاريخ</label>
            <input type="date" class="form-control">
        </div>
        <button class="btn btn-primary" style="padding: 0.75rem 1.5rem; align-self: flex-end;">
            <i class="fa-solid fa-filter"></i> البحث
        </button>
    </div>
</div>

<!-- Patients Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">قائمة المرضى</h3>
        <span class="badge badge-blue">{{ $patients->total() ?? 0 }} مريض</span>
    </div>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الهاتف</th>
                    <th>البريد الإلكتروني</th>
                    <th>آخر موعد</th>
                    <th>السجلات الطبية</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients ?? collect() as $patient)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 900; font-size: 0.9rem;">
                                    {{ mb_substr($patient->name ?? '', 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight: bold; color: var(--gray-900);">{{ $patient->name ?? 'غير معروف' }}</div>
                                    <div style="font-size: 0.8rem; color: var(--gray-500);">{{ $patient->age ?? 'غير محدد' }} سنة</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-family: monospace; font-weight: 600;">{{ $patient->phone ?? '-' }}</td>
                        <td style="font-size: 0.9rem; color: var(--gray-600);">{{ $patient->email ?? '-' }}</td>
                        <td style="font-size: 0.9rem; color: var(--gray-600);">
                            {{ $patient->last_appointment ? \Carbon\Carbon::parse($patient->last_appointment)->format('d M Y') : '-' }}
                        </td>
                        <td style="font-weight: bold; color: var(--success);">{{ $patient->records_count ?? 0 }}</td>
                        <td>
                            <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 0.35rem 0.85rem; border-radius: 30px; font-size: 0.75rem; font-weight: 800;">
                                <i class="fa-solid fa-circle" style="font-size: 0.5rem; margin-left: 0.25rem;"></i> نشط
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="#" class="btn" style="padding: 0.5rem; background: rgba(0, 102, 204, 0.1); color: var(--primary); border-radius: 8px;"><i class="fa-solid fa-eye"></i></a>
                                <a href="#" class="btn" style="padding: 0.5rem; background: rgba(139, 92, 246, 0.1); color: var(--purple); border-radius: 8px;"><i class="fa-solid fa-file-medical"></i></a>
                                <a href="#" class="btn" style="padding: 0.5rem; background: rgba(249, 115, 22, 0.1); color: #f97316; border-radius: 8px;"><i class="fa-solid fa-edit"></i></a>
                                <button class="btn" style="padding: 0.5rem; background: rgba(239, 68, 68, 0.1); color: var(--danger); border-radius: 8px; border: none; cursor: pointer;"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 4rem; color: var(--gray-400);">
                            <i class="fa-solid fa-users-slash" style="font-size: 2.5rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                            <p style="font-size: 1.1rem; font-weight: 600;">لا يوجد مرضى</p>
                            <p style="font-size: 0.9rem; color: var(--gray-500);">سيتم إضافة المرضى عند حجزهم لمواعيد</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($patients ?? false)
        <div style="margin-top: 1.5rem;">
            {{ $patients->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Patient Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
    <div class="card" style="background: linear-gradient(135deg, var(--success), #059669); color: #fff;">
        <i class="fa-solid fa-calendar-heart" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
        <div style="font-size: 1.8rem; font-weight: 900;">{{ $patientsWithAppointments ?? 0 }}</div>
        <p style="opacity: 0.9; font-size: 0.9rem;">لديهم مواعيد</p>
    </div>
    <div class="card" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff;">
        <i class="fa-solid fa-file-medical-alt" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
        <div style="font-size: 1.8rem; font-weight: 900;">{{ $patientsWithRecords ?? 0 }}</div>
        <p style="opacity: 0.9; font-size: 0.9rem;">لديهم سجلات</p>
    </div>
    <div class="card" style="background: linear-gradient(135deg, var(--purple), #a855f7); color: #fff;">
        <i class="fa-solid fa-eye" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
        <div style="font-size: 1.8rem; font-weight: 900;">{{ $activePatients ?? 0 }}</div>
        <p style="opacity: 0.9; font-size: 0.9rem;">نشط الشهر</p>
    </div>
    <div class="card" style="background: linear-gradient(135deg, #f97316, #ef4444); color: #fff;">
        <i class="fa-solid fa-users-cog" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
        <div style="font-size: 1.8rem; font-weight: 900;">{{ $needsAttention ?? 0 }}</div>
        <p style="opacity: 0.9; font-size: 0.9rem;">يحتاجون متابعة</p>
    </div>
</div>
@endsection
