@extends('layouts.app')

@section('title', 'تفاصيل الموعد')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Appointment Info -->
    <div class="card mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <p class="text-sm text-gray-600 mb-1">المريض</p>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $appointment->patient->name }}</h2>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">البريد الإلكتروني</p>
                        <p class="font-semibold text-gray-800">{{ $appointment->patient->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">الهاتف</p>
                        <p class="font-semibold text-gray-800">{{ $appointment->patient->phone ?? 'لم يتم تحديده' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">العنوان</p>
                        <p class="font-semibold text-gray-800">{{ $appointment->patient->address ?? 'لم يتم تحديده' }}</p>
                    </div>
                </div>
            </div>
            
            <div>
                <p class="text-sm text-gray-600 mb-1">معلومات الموعد</p>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">التاريخ</p>
                        <p class="font-semibold text-gray-800">{{ $appointment->appointment_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">الوقت</p>
                        <p class="font-semibold text-gray-800">{{ $appointment->appointment_time }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">السبب</p>
                        <p class="font-semibold text-gray-800">{{ $appointment->reason ?? 'لم يتم تحديد السبب' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">الحالة</p>
                        <span class="px-3 py-1 rounded-full text-sm font-bold
                            @if($appointment->isPending()) bg-yellow-100 text-yellow-800
                            @elseif($appointment->isConfirmed()) bg-blue-100 text-blue-800
                            @elseif($appointment->isCompleted()) bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif
                        ">
                            @if($appointment->isPending()) قيد الانتظار
                            @elseif($appointment->isConfirmed()) مؤكد
                            @elseif($appointment->isCompleted()) مكتمل
                            @else ملغى
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Medical Record Form -->
    @if(!$appointment->medicalRecord && !$appointment->isCancelled())
    <div class="card mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">إضافة تقرير طبي</h2>
        
        <form action="{{ route('doctor.add-medical-record', $appointment->id) }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-lg font-bold text-gray-800 mb-3">التشخيص</label>
                <textarea name="diagnosis" class="input-field" rows="4" required placeholder="أدخل التشخيص..."></textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-lg font-bold text-gray-800 mb-3">العلاج</label>
                <textarea name="treatment" class="input-field" rows="4" required placeholder="أدخل العلاج الموصى به..."></textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-lg font-bold text-gray-800 mb-3">الأدوية (اختياري)</label>
                <textarea name="prescription" class="input-field" rows="3" placeholder="أدخل الأدوية الموصى بها..."></textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-lg font-bold text-gray-800 mb-3">ملاحظات إضافية (اختياري)</label>
                <textarea name="notes" class="input-field" rows="3" placeholder="أدخل أي ملاحظات إضافية..."></textarea>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="btn-primary flex-1">
                    <i class="fas fa-save ml-2"></i>حفظ التقرير
                </button>
                <a href="{{ route('doctor.appointments') }}" class="btn-outline flex-1 text-center">
                    <i class="fas fa-times-circle ml-2"></i>إلغاء
                </a>
            </div>
        </form>
    </div>
    @elseif($appointment->medicalRecord)
    <div class="card mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">التقرير الطبي</h2>
        
        <div class="space-y-6">
            <div>
                <p class="text-sm text-gray-600 mb-2">التشخيص</p>
                <p class="text-gray-800 bg-blue-50 p-4 rounded-lg">{{ $appointment->medicalRecord->diagnosis }}</p>
            </div>
            
            <div>
                <p class="text-sm text-gray-600 mb-2">العلاج</p>
                <p class="text-gray-800 bg-blue-50 p-4 rounded-lg">{{ $appointment->medicalRecord->treatment }}</p>
            </div>
            
            @if($appointment->medicalRecord->prescription)
            <div>
                <p class="text-sm text-gray-600 mb-2">الأدوية</p>
                <p class="text-gray-800 bg-blue-50 p-4 rounded-lg">{{ $appointment->medicalRecord->prescription }}</p>
            </div>
            @endif
            
            @if($appointment->medicalRecord->notes)
            <div>
                <p class="text-sm text-gray-600 mb-2">ملاحظات</p>
                <p class="text-gray-800 bg-blue-50 p-4 rounded-lg">{{ $appointment->medicalRecord->notes }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif
    
    <!-- Action Buttons -->
    @if($appointment->isPending())
    <div class="flex gap-4">
        <form action="{{ route('doctor.confirm-appointment', $appointment->id) }}" method="POST" class="flex-1">
            @csrf
            <button type="submit" class="btn-secondary w-full">
                <i class="fas fa-check-circle ml-2"></i>تأكيد الموعد
            </button>
        </form>
        
        <form action="{{ route('doctor.cancel-appointment', $appointment->id) }}" method="POST" class="flex-1" id="cancelForm">
            @csrf
            <button type="button" class="btn-outline w-full" onclick="document.getElementById('cancelModal').style.display='block'">
                <i class="fas fa-times-circle ml-2"></i>إلغاء الموعد
            </button>
        </form>
    </div>
    @endif
</div>

<!-- Cancel Modal -->
<div id="cancelModal" style="display:none" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="card max-w-md">
        <h3 class="text-xl font-bold text-gray-800 mb-4">إلغاء الموعد</h3>
        <p class="text-gray-600 mb-6">هل تريد فعلاً إلغاء هذا الموعد؟</p>
        
        <form action="{{ route('doctor.cancel-appointment', $appointment->id) }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-800 mb-2">السبب</label>
                <textarea name="reason" class="input-field" rows="3" required placeholder="اشرح سبب الإلغاء..."></textarea>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="btn-primary flex-1">تأكيد الإلغاء</button>
                <button type="button" class="btn-outline flex-1" onclick="document.getElementById('cancelModal').style.display='none'">إلغاء</button>
            </div>
        </form>
    </div>
</div>
@endsection