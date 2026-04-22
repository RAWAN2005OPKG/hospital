@extends('layouts.app')

@section('title', 'احجز موعد - د. ' . $doctor->user->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card mb-8">
        <div class="flex items-center mb-8 pb-8 border-b border-blue-100">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-teal-100 rounded-full flex items-center justify-center ml-4">
                <i class="fas fa-user-md text-4xl text-blue-600"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">د. {{ $doctor->user->name }}</h1>
                <p class="text-teal-600 font-semibold">{{ $doctor->specialization->name }}</p>
            </div>
        </div>
        
        <form action="{{ route('appointments.store') }}" method="POST" id="bookingForm">
            @csrf
            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
            
            <!-- Date Selection -->
            <div class="mb-6">
                <label class="block text-lg font-bold text-gray-800 mb-3">
                    <i class="fas fa-calendar-alt ml-2 text-blue-600"></i>اختر التاريخ
                </label>
                <input type="date" name="appointment_date" class="input-field" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>
            
            <!-- Time Selection -->
            <div class="mb-6">
                <label class="block text-lg font-bold text-gray-800 mb-3">
                    <i class="fas fa-clock ml-2 text-blue-600"></i>اختر الوقت
                </label>
                <div id="timeSlots" class="grid grid-cols-3 md:grid-cols-4 gap-3">
                    <p class="text-gray-600">اختر تاريخاً أولاً</p>
                </div>
            </div>
            
            <!-- Reason -->
            <div class="mb-6">
                <label class="block text-lg font-bold text-gray-800 mb-3">
                    <i class="fas fa-notes-medical ml-2 text-blue-600"></i>سبب الزيارة (اختياري)
                </label>
                <textarea name="reason" class="input-field" rows="4" placeholder="اشرح السبب الذي تأتي من أجله..."></textarea>
            </div>
            
            <!-- Summary -->
            <div class="bg-blue-50 rounded-lg p-6 mb-6">
                <h3 class="font-bold text-gray-800 mb-3">ملخص الحجز</h3>
                <div class="space-y-2 text-gray-700">
                    <div class="flex justify-between">
                        <span>الطبيب:</span>
                        <span class="font-semibold">د. {{ $doctor->user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>التاريخ:</span>
                        <span class="font-semibold" id="summaryDate">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span>الوقت:</span>
                        <span class="font-semibold" id="summaryTime">-</span>
                    </div>
                    <div class="border-t border-blue-200 pt-2 mt-2 flex justify-between">
                        <span>الرسم:</span>
                        <span class="font-bold text-blue-600">{{ $doctor->consultation_fee }} ر.س</span>
                    </div>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="btn-primary flex-1">
                    <i class="fas fa-check-circle ml-2"></i>تأكيد الحجز
                </button>
                <a href="{{ route('appointments.search') }}" class="btn-outline flex-1 text-center">
                    <i class="fas fa-times-circle ml-2"></i>إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.querySelector('input[name="appointment_date"]').addEventListener('change', function() {
    const date = this.value;
    const doctorId = {{ $doctor->id }};
    
    fetch(`{{ route('appointments.available-slots', '') }}/${doctorId}/slots?date=${date}`)
        .then(response => response.json())
        .then(data => {
            const timeSlotsDiv = document.getElementById('timeSlots');
            timeSlotsDiv.innerHTML = '';
            
            if (data.slots.length === 0) {
                timeSlotsDiv.innerHTML = '<p class="text-gray-600">لا توجد فترات متاحة في هذا التاريخ</p>';
                return;
            }
            
            data.slots.forEach(slot => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'p-3 border-2 border-blue-200 rounded-lg hover:bg-blue-100 hover:border-blue-600 transition font-semibold text-gray-800';
                button.textContent = slot;
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector('input[name="appointment_time"]').value = slot;
                    document.querySelectorAll('#timeSlots button').forEach(b => b.classList.remove('bg-blue-600', 'text-white', 'border-blue-600'));
                    this.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                    document.getElementById('summaryTime').textContent = slot;
                });
                timeSlotsDiv.appendChild(button);
            });
        });
    
    document.getElementById('summaryDate').textContent = new Date(date).toLocaleDateString('ar-SA');
});

document.getElementById('bookingForm').addEventListener('submit', function(e) {
    if (!document.querySelector('input[name="appointment_time"]').value) {
        e.preventDefault();
        alert('يرجى اختيار وقت');
    }
});
</script>
<input type="hidden" name="appointment_time" value="">
@endpush
@endsection