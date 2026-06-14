@extends('layouts.app')
@section('title', 'المساعد الذكي - تحليل الأعراض')

@section('content')
<div style="padding-top: 80px; min-height: 100vh; background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%);">
    <div style="max-width: 900px; margin: 0 auto; padding: 3rem 1.5rem;">
        
        <!-- Header Section -->
        <div style="background: white; border-radius: 2rem; box-shadow: 0 20px 25px rgba(0,0,0,0.1); padding: 3rem; margin-bottom: 2rem; border: 1px solid #e5e7eb;">
            <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #6366f1, #a855f7); border-radius: 1.5rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <h1 style="font-size: 2.5rem; font-weight: 900; color: #111827; margin: 0;">المساعد الذكي</h1>
                    <p style="font-size: 1.1rem; color: #6366f1; font-weight: bold; margin: 0.5rem 0 0 0;">تحليل الأعراض والتوجيه الطبي</p>
                </div>
            </div>
            
            <div style="background: #eef2ff; padding: 1.5rem; border-radius: 1rem; border-left: 4px solid #6366f1;">
                <h4 style="font-weight: bold; color: #312e81; margin: 0 0 0.5rem 0; font-size: 1.1rem;">ما فائدة هذه الصفحة؟</h4>
                <p style="color: #1f2937; margin: 0; line-height: 1.8; font-size: 1rem;">
                    هذه الصفحة تساعدك على معرفة <strong>القسم الطبي المناسب</strong> لحالتك الصحية بناءً على الأعراض التي تشعر بها. يقوم نظام الذكاء الاصطناعي بتحليل وصفك وتوجيهك للقسم الصحيح لضمان حصولك على الرعاية المناسبة في أسرع وقت.
                </p>
            </div>
        </div>

        <!-- Main Form Card -->
        <div style="background: white; border-radius: 2rem; box-shadow: 0 20px 25px rgba(0,0,0,0.1); padding: 2.5rem; margin-bottom: 2rem; border: 1px solid #e5e7eb;">
            <form method="POST" action="{{ route('patient.ai.symptoms.submit') }}" style="display: flex; flex-direction: column; gap: 2rem;">
                @csrf
                
                <!-- Symptoms Input -->
                <div>
                    <label style="display: block; font-size: 1.1rem; font-weight: bold; color: #111827; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-stethoscope" style="color: #a855f7;"></i>
                        اوصف أعراضك بالتفصيل
                    </label>
                    <textarea name="symptoms" rows="7" required placeholder="مثال: ألم في الصدر، صعوبة في التنفس، دوخة..." 
                              style="width: 100%; padding: 1.5rem; border: 2px solid #e5e7eb; border-radius: 1.5rem; background: white; color: #111827; font-size: 1rem; font-family: inherit; resize: none; transition: all 0.3s ease; @error('symptoms') border-color: #ef4444; @enderror"
                              onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 4px rgba(99,102,241,0.1)'"
                              onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">{{ old('symptoms') }}</textarea>
                    
                    @error('symptoms')
                    <div style="margin-top: 1rem; padding: 1rem; background: #fef2f2; border: 1px solid #fecaca; border-radius: 1rem; display: flex; gap: 0.75rem; align-items: flex-start;">
                        <i class="fas fa-exclamation-circle" style="color: #dc2626; margin-top: 0.25rem; flex-shrink: 0;"></i>
                        <p style="color: #dc2626; font-weight: 600; margin: 0;">{{ $message }}</p>
                    </div>
                    @enderror

                    <!-- Character Count -->
                    <div style="margin-top: 0.75rem; font-size: 0.9rem; color: #6b7280; display: flex; justify-content: space-between;">
                        <span>اكتب أعراضك بالتفصيل لتحليل أدق</span>
                        <span id="charCount" style="color: #6366f1; font-weight: bold;">0 حرف</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <button type="submit" style="flex: 1; min-width: 200px; padding: 1.25rem; background: linear-gradient(135deg, #a855f7, #9333ea); color: white; font-weight: bold; border: none; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(168, 85, 247, 0.3); cursor: pointer; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 0.75rem; transition: all 0.3s ease;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 35px rgba(168, 85, 247, 0.4)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(168, 85, 247, 0.3)'">
                        <i class="fas fa-brain"></i>
                        <span>تحليل الأعراض</span>
                    </button>
                    <button type="reset" style="flex: 1; min-width: 150px; padding: 1.25rem; background: white; color: #111827; border: 2px solid #e5e7eb; border-radius: 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.05); cursor: pointer; font-weight: bold; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 0.75rem; transition: all 0.3s ease;"
                            onmouseover="this.style.boxShadow='0 10px 15px rgba(0,0,0,0.1)'"
                            onmouseout="this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)'">
                        <i class="fas fa-redo"></i>
                        <span>إعادة تعيين</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Section -->
        @isset($result)
        <div style="background: white; border-radius: 2rem; box-shadow: 0 20px 25px rgba(0,0,0,0.1); padding: 2.5rem; margin-bottom: 2rem; border: 1px solid #e5e7eb;">
            <h2 style="font-size: 1.8rem; font-weight: bold; color: #111827; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-check-circle" style="color: #10b981;"></i>
                نتائج التحليل
            </h2>

            <!-- Suggested Department Card -->
            <div style="background: linear-gradient(135deg, #dbeafe, #e0e7ff); border-radius: 1.5rem; padding: 2rem; border: 2px solid #93c5fd; margin-bottom: 1.5rem;">
                <div style="display: flex; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: #3b82f6; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0; font-size: 1.5rem;">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <div style="flex: 1;">
                        <p style="font-size: 0.9rem; color: #4b5563; margin: 0 0 0.5rem 0; font-weight: 600;">القسم المقترح</p>
                        <h3 style="font-size: 1.8rem; font-weight: bold; color: #111827; margin: 0;">{{ $result['suggested_department_name'] }}</h3>
                    </div>
                </div>
            </div>

            <!-- Urgency Level -->
            <div style="background: linear-gradient(135deg, #fed7aa, #fecaca); border-radius: 1.5rem; padding: 2rem; border: 2px solid #fdba74; margin-bottom: 1.5rem;">
                <div style="display: flex; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: #f97316; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0; font-size: 1.5rem;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div style="flex: 1;">
                        <p style="font-size: 0.9rem; color: #4b5563; margin: 0 0 0.5rem 0; font-weight: 600;">مستوى الأولوية</p>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span style="display: inline-block; padding: 0.5rem 1rem; background: #f97316; color: white; font-weight: bold; border-radius: 1rem; font-size: 0.9rem;">
                                {{ $result['urgency_label'] }}
                            </span>
                            <p style="color: #374151; font-weight: 600; margin: 0;">يُنصح بمراجعة الطبيب قريباً</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Note -->
            <div style="background: linear-gradient(135deg, #d1fae5, #ccfbf1); border-radius: 1.5rem; padding: 2rem; border: 2px solid #6ee7b7;">
                <div style="display: flex; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: #10b981; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0; font-size: 1.5rem;">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div style="flex: 1;">
                        <p style="font-size: 0.9rem; color: #4b5563; margin: 0 0 0.5rem 0; font-weight: 600;">ملاحظات إضافية</p>
                        <p style="color: #111827; margin: 0; line-height: 1.8;">{{ $result['note'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="margin-top: 2rem; display: flex; flex-direction: column; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('appointments.create') }}" style="flex: 1; padding: 1.25rem; background: linear-gradient(135deg, #10b981, #059669); color: white; font-weight: bold; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3); text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.75rem; font-size: 1.1rem; transition: all 0.3s ease;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 35px rgba(16, 185, 129, 0.4)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(16, 185, 129, 0.3)'">
                    <i class="fas fa-calendar-plus"></i>
                    <span>حجز موعد مع الطبيب</span>
                </a>
                <button onclick="window.print()" style="flex: 1; padding: 1.25rem; background: white; color: #111827; border: 2px solid #e5e7eb; border-radius: 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.05); font-weight: bold; font-size: 1.1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.75rem; transition: all 0.3s ease;"
                        onmouseover="this.style.boxShadow='0 10px 15px rgba(0,0,0,0.1)'"
                        onmouseout="this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)'">
                    <i class="fas fa-print"></i>
                    <span>طباعة النتائج</span>
                </button>
            </div>
        </div>
        @endisset

        <!-- Info Card -->
        <div style="background: linear-gradient(135deg, #dbeafe, #e0e7ff); border-radius: 2rem; box-shadow: 0 20px 25px rgba(0,0,0,0.1); padding: 2.5rem; border: 1px solid #93c5fd;">
            <h3 style="font-size: 1.3rem; font-weight: bold; color: #111827; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-info-circle" style="color: #3b82f6;"></i>
                كيف تستخدم هذه الخدمة؟
            </h3>
            <ul style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 1rem;">
                <li style="display: flex; align-items: center; gap: 1rem; color: #374151; font-size: 1rem;">
                    <span style="width: 30px; height: 30px; background: #3b82f6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">1</span>
                    <span>اكتب الأعراض التي تشعر بها بدقة في المربع أعلاه.</span>
                </li>
                <li style="display: flex; align-items: center; gap: 1rem; color: #374151; font-size: 1rem;">
                    <span style="width: 30px; height: 30px; background: #3b82f6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">2</span>
                    <span>اضغط على زر "تحليل الأعراض" ليبدأ النظام بالعمل.</span>
                </li>
                <li style="display: flex; align-items: center; gap: 1rem; color: #374151; font-size: 1rem;">
                    <span style="width: 30px; height: 30px; background: #3b82f6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">3</span>
                    <span>سيظهر لك القسم الطبي المقترح ومدى استعجال الحالة.</span>
                </li>
            </ul>
        </div>

    </div>
</div>

<script>
    // Character counter
    const textarea = document.querySelector('textarea[name="symptoms"]');
    const charCount = document.getElementById('charCount');
    
    if (textarea) {
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length + ' حرف';
        });
        
        // Initial count
        charCount.textContent = textarea.value.length + ' حرف';
    }

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const symptoms = textarea.value.trim();
        if (symptoms.length < 10) {
            e.preventDefault();
            alert('يرجى وصف الأعراض بشكل أكثر تفصيلاً (على الأقل 10 أحرف)');
        }
    });
</script>
@endsection
