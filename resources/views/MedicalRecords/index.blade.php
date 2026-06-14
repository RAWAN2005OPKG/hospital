@extends('layouts.app')
@section('title', 'السجلات الطبية')

@section('content')
<div class="section-head" style="margin-top: 100px;">
    <span class="sec-tag">سجلاتي</span>
    <h2>تاريخك الطبي</h2>
    <p>تابع كافة تقاريرك الطبية ونتائج الفحوصات في مكان واحد</p>
</div>

<div class="container">
    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="padding: 1.5rem; background: var(--gray-50); border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0;">قائمة السجلات</h4>
            <div style="display: flex; gap: 0.5rem;">
                <input type="text" class="form-control" placeholder="بحث في السجلات..." style="width: 250px;">
                <button class="btn btn-white btn-sm"><i class="fa-solid fa-filter"></i> تصفية</button>
            </div>
        </div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #fff; text-align: right;">
                    <th style="padding: 1.2rem; border-bottom: 2px solid var(--gray-100);">التاريخ</th>
                    <th style="padding: 1.2rem; border-bottom: 2px solid var(--gray-100);">التشخيص</th>
                    <th style="padding: 1.2rem; border-bottom: 2px solid var(--gray-100);">الطبيب</th>
                    <th style="padding: 1.2rem; border-bottom: 2px solid var(--gray-100);">القسم</th>
                    <th style="padding: 1.2rem; border-bottom: 2px solid var(--gray-100);">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records ?? [] as $record)
                <tr style="border-bottom: 1px solid var(--gray-100);">
                    <td style="padding: 1.2rem;">{{ $record->created_at->format('Y/m/d') }}</td>
                    <td style="padding: 1.2rem; font-weight: 600;">{{ $record->diagnosis }}</td>
                    <td style="padding: 1.2rem;">{{ $record->doctor->user->name }}</td>
                    <td style="padding: 1.2rem;"><span class="sec-tag" style="padding: 0.3rem 0.8rem; font-size: 0.75rem;">{{ $record->doctor->department->name }}</span></td>
                    <td style="padding: 1.2rem;">
                        <button class="btn btn-outline btn-sm"><i class="fa-solid fa-eye"></i> عرض</button>
                        <button class="btn btn-white btn-sm"><i class="fa-solid fa-download"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 4rem; text-align: center; color: var(--gray-400);">
                        <i class="fa-solid fa-folder-open" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        لا توجد سجلات طبية متاحة حالياً
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
