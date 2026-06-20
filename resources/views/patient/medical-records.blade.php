@extends('layouts.app')

@section('title', __('messages.medical_records_title'))

@section('content')
<div style="padding-top: 80px; min-height: 100vh; background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); padding: 3rem 1.5rem;">
    <div style="max-width: 1400px; margin: 0 auto;">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 2.5rem; font-weight: 900; color: #111827; margin: 0 0 0.5rem 0; display: flex; align-items: center; gap: 1rem;">
                <i class="fas fa-file-medical" style="color: #10b981;"></i>
                {{ __('messages.medical_records_title') }}
            </h1>
            <p style="font-size: 1.1rem; color: #6b7280; margin: 0;">سجل طبيك ومراجعة تاريخك الصحي</p>
        </div>
        
        {{-- Enhanced Header Stats --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3); text-align: center; cursor: pointer; transition: all 0.3s ease; border: 1px solid rgba(255,255,255,0.2);" onclick="printRecords()">
                <i class="fas fa-file-alt" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.9;"></i>
                <div style="font-size: 2.5rem; font-weight: 900; margin-bottom: 0.5rem;">{{ $records ? $records->count() : 0 }}</div>
                <div style="font-size: 1.1rem; font-weight: 600; opacity: 0.9;">السجلات الكلية</div>
            </div>
            
            <div style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3); text-align: center; transition: all 0.3s ease; border: 1px solid rgba(255,255,255,0.2);">
                <i class="fas fa-calendar-week" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.9;"></i>
                <div style="font-size: 2.5rem; font-weight: 900; margin-bottom: 0.5rem;">{{ $recentRecords ?? 0 }}</div>
                <div style="font-size: 1.1rem; font-weight: 600; opacity: 0.9;">السجلات الأخيرة</div>
            </div>
            
            <div style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.3); text-align: center; cursor: pointer; transition: all 0.3s ease; border: 1px solid rgba(255,255,255,0.2);" onclick="exportPDF()">
                <i class="fas fa-file-pdf" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.9;"></i>
                <div style="font-size: 1.5rem; font-weight: 900; margin-bottom: 0.5rem;">تصدير PDF</div>
                <div style="font-size: 1rem; font-weight: 600; opacity: 0.9;">تنزيل السجلات</div>
            </div>
        </div>

        {{-- Records Timeline --}}
        <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; overflow: hidden;">
            <div style="background: linear-gradient(135deg, #10b981, #059669); padding: 2rem; border-bottom: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: space-between;">
                <h2 style="font-size: 1.75rem; font-weight: bold; color: white; margin: 0; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-timeline"></i>
                    {{ __('messages.medical_records_history') }}
                </h2>
                <div style="display: flex; gap: 0.75rem;">
                    <button id="timeline-prev" style="width: 3.5rem; height: 3.5rem; background: rgba(255,255,255,0.2); border: none; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; cursor: pointer; transition: all 0.3s ease;">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <button id="timeline-next" style="width: 3.5rem; height: 3.5rem; background: rgba(255,255,255,0.2); border: none; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; cursor: pointer; transition: all 0.3s ease;">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
            </div>
            
            <div style="overflow-x: auto;">
                <div style="padding: 2rem; min-width: max-content; position: relative;">
                    {{-- Vertical timeline line --}}
                    <div style="position: absolute; left: 2.5rem; top: 0; bottom: 0; width: 0.25rem; background: linear-gradient(to bottom, #10b981, #3b82f6); border-radius: 9999px; box-shadow: 0 0 10px rgba(16, 185, 129, 0.3);"></div>
                    
                    @forelse($records ?? collect() as $index => $record)
                        <div style="margin-bottom: 4rem; display: flex; align-items: flex-start; min-width: 600px;">
                            {{-- Timeline dot --}}
                            <div style="position: relative; z-index: 10; flex-shrink: 0;">
                                <div style="width: 1.5rem; height: 1.5rem; background: linear-gradient(to right, #10b981, #3b82f6); border-radius: 9999px; box-shadow: 0 0 10px rgba(16, 185, 129, 0.3); display: flex; align-items: center; justify-content: center; margin-right: 1.5rem; margin-left: -0.75rem; border: 0.5rem solid white;">
                                    <i class="fas fa-chart-line" style="color: white; font-size: 0.75rem;"></i>
                                </div>
                            </div>
                            
                            {{-- Record Card --}}
                            <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 2rem; border: 1px solid #e5e7eb; flex: 1; max-width: 56rem; transition: all 0.3s ease; hover: box-shadow: 0 15px 35px rgba(0,0,0,0.1); hover: border-color: #10b981;">
                                <div style="display: flex; flex-wrap: align-items: flex-start; justify-content: space-between; gap: 1.5rem; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                                    <div>
                                        <h3 style="font-size: 1.75rem; font-weight: bold; color: #111827; margin: 0 0 0.75rem 0;">{{ $record->doctor->user->name ?? 'غير محدد' }}</h3>
                                        <div style="display: flex; align-items: center; color: #10b981; font-weight: bold; font-size: 1.1rem; margin-bottom: 0.5rem;">
                                            <i class="fas fa-clock" style="margin-left: 0.5rem;"></i>
                                            {{ \Carbon\Carbon::parse($record->created_at)->format('d M Y, H:i') }}
                                        </div>
                                        <span style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background: linear-gradient(to right, #3b82f6, #10b981); color: white; font-size: 1rem; font-weight: bold; border-radius: 1rem; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2);">
                                            {{ $record->appointment->reason ?? 'فحص روتيني' }}
                                        </span>
                                    </div>
                                    <a href="/patient/medical-records/{{ $record->id }}" style="display: inline-flex; align-items: center; padding: 1rem 2rem; background: linear-gradient(to right, #10b981, #3b82f6); color: white; font-weight: bold; border-radius: 1.5rem; text-decoration: none; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); transition: all 0.3s ease; gap: 0.75rem;">
                                        <i class="fas fa-eye"></i>
                                        عرض التفاصيل
                                    </a>
                                </div>
                                
                                {{-- Content Grid --}}
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                                    <div>
                                        <h4 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.75rem;">
                                            <i class="fas fa-stethoscope" style="color: #ef4444;"></i>
                                            التشخيص
                                        </h4>
                                        <div style="background: linear-gradient(to bottom right, #fef2f2, #fce7f3); padding: 1.5rem; border-radius: 1.25rem; border: 1px solid #fecaca; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.1);">
                                            <div style="font-size: 1rem; line-height: 1.75; color: #374151; white-space: pre-wrap;">
                                                {{ Str::limit($record->diagnosis, 400, '...') }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h4 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.75rem;">
                                            <i class="fas fa-pills" style="color: #f97316;"></i>
                                            خطة العلاج
                                        </h4>
                                        <div style="background: linear-gradient(to bottom right, #fff7ed, #fef9c3); padding: 1.5rem; border-radius: 1.25rem; border: 1px solid #fed7aa; box-shadow: 0 4px 10px rgba(249, 115, 22, 0.1);">
                                            <div style="font-size: 1rem; line-height: 1.75; color: #374151; white-space: pre-wrap;">
                                                {{ Str::limit($record->treatment, 400, '...') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($record->prescription)
                                    <div style="margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #e5e7eb;">
                                        <h4 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.75rem;">
                                            <i class="fas fa-prescription-bottle-alt" style="color: #3b82f6;"></i>
                                            الوصفة الطبية
                                        </h4>
                                        <div style="background: linear-gradient(to right, #eff6ff, #e0e7ff); padding: 2rem; border-radius: 1.25rem; border: 2px solid #bfdbfe; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.15);">
                                            <div style="font-size: 1.1rem; color: #374151; line-height: 1.75; font-family: monospace; white-space: pre-wrap; text-align: center;">
                                                {{ $record->prescription }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="min-width: max-content; text-align: center; padding: 5rem;">
                            <div style="width: 8rem; height: 8rem; background: linear-gradient(to bottom right, #e5e7eb, #d1d5db); border-radius: 9999px; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                                <i class="fas fa-file-medical" style="font-size: 3rem; color: #9ca3af;"></i>
                            </div>
                            <h3 style="font-size: 2rem; font-weight: bold; color: #111827; margin: 0 0 1rem 0;">لا توجد سجلات طبية بعد</h3>
                            <p style="font-size: 1.25rem; color: #6b7280; margin: 0 0 2rem; max-width: 32rem; margin-left: auto; margin-right: auto; line-height: 1.75;">
                                سجلاتك الطبية ستظهر هنا تلقائياً بعد إتمام أول زيارة للطبيب
                            </p>
                            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                                <a href="{{ route('appointments.book') }}" style="display: inline-flex; align-items: center; justify-content: center; padding: 1.25rem 2.5rem; background: linear-gradient(to right, #10b981, #3b82f6); color: white; font-weight: bold; font-size: 1.25rem; border-radius: 1.5rem; text-decoration: none; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3); transition: all 0.3s ease; gap: 1rem;">
                                    <i class="fas fa-calendar-plus"></i>
                                    {{ __('messages.book_first_appointment_now') }}
                                </a>
                                <p style="font-size: 1rem; color: #6b7280; text-align: center;">
                                    أو <a href="{{ route('doctors.index') }}" style="color: #10b981; font-weight: bold; text-decoration: none;">{{ __('messages.browse_doctors') }}</a>
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Enhanced Pagination --}}
        @if(isset($records) && $records->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            {{ $records->appends(request()->query())->links('vendor.pagination.tailwindcss-modern') }}
        </div>
        @endif
    </div>
</div>

<script>
    function printRecords() {
        window.print();
    }

    function exportPDF() {
        alert('قريباً سيتم إضافة تصدير PDF');
    }

    // Enhanced Timeline Navigation
    let currentSlide = 0;
    const timelineContainer = document.querySelector('.overflow-x-auto');
    const slideWidth = 650;

    document.getElementById('timeline-next')?.addEventListener('click', () => {
        if (timelineContainer.scrollLeft < timelineContainer.scrollWidth - timelineContainer.clientWidth - 50) {
            timelineContainer.scrollLeft += slideWidth;
        }
    });

    document.getElementById('timeline-prev')?.addEventListener('click', () => {
        if (timelineContainer.scrollLeft > 50) {
            timelineContainer.scrollLeft -= slideWidth;
        }
    });

    // Auto-scroll on hover
    timelineContainer?.addEventListener('mouseenter', () => clearInterval(window.timelineInterval));
    timelineContainer?.addEventListener('mouseleave', () => {
        window.timelineInterval = setInterval(() => {
            if (timelineContainer.scrollLeft < timelineContainer.scrollWidth - timelineContainer.clientWidth) {
                timelineContainer.scrollLeft += 2;
            }
        }, 50);
    });

    function viewDetail(id) {
        window.location.href = `/patient/medical-records/${id}`;
    }
</script>
@endsection

