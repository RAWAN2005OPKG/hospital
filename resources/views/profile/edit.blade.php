@extends('layouts.app')
@section('title', 'تعديل الملف الشخصي')

@section('content')
<div style="padding-top: 100px; min-height: 100vh; background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); padding-bottom: 3rem;">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 1.5rem;">
        
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 55px; height: 55px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; box-shadow: 0 10px 15px rgba(59, 130, 246, 0.2);">
                    <i class="fas fa-user-edit"></i>
                </div>
                <h1 style="font-size: 2.25rem; font-weight: 900; color: #111827; margin: 0;">تعديل الملف الشخصي</h1>
            </div>
            <a href="{{ route('profile.show') }}" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; font-weight: bold; border-radius: 1rem; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease;">
                <i class="fas fa-arrow-right"></i>
                <span>رجوع</span>
            </a>
        </div>

        <div style="background: white; border-radius: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1); border: 1px solid #f1f5f9; overflow: hidden;">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Profile Header/Avatar Section -->
                <div style="padding: 3rem; text-align: center; background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                    <div style="width: 140px; height: 140px; margin: 0 auto 1.5rem; position: relative;">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" id="avatar-preview" style="width: 100%; height: 100%; border-radius: 2.5rem; object-fit: cover; border: 5px solid white; box-shadow: 0 15px 25px rgba(0,0,0,0.1);">
                        @else
                            <div id="avatar-placeholder" style="width: 100%; height: 100%; border-radius: 2.5rem; background: linear-gradient(135deg, #3b82f6, #60a5fa); display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem; border: 5px solid white; box-shadow: 0 15px 25px rgba(59, 130, 246, 0.2);">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        <label for="avatar" style="position: absolute; bottom: -10px; right: -10px; width: 45px; height: 45px; background: #10b981; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; cursor: pointer; border: 4px solid white; box-shadow: 0 10px 15px rgba(16, 185, 129, 0.3); transition: transform 0.2s ease;">
                            <i class="fas fa-camera"></i>
                            <input type="file" id="avatar" name="avatar" style="display: none;" accept="image/*">
                        </label>
                    </div>
                    <h2 style="font-size: 1.75rem; font-weight: 800; color: #111827; margin-bottom: 0.5rem;">{{ $user->name }}</h2>
                    <span style="display: inline-block; padding: 0.5rem 1.25rem; background: #dbeafe; color: #1e40af; font-weight: bold; border-radius: 2rem; font-size: 0.9rem;">
                        <i class="fas {{ $user->isPatient() ? 'fa-user-injured' : 'fa-user-md' }}" style="margin-left: 0.5rem;"></i>
                        {{ $user->isPatient() ? 'ملف المريض' : 'ملف الطبيب' }}
                    </span>
                </div>

                <div style="padding: 3rem;">
                    <!-- Basic Information Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 2.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <label style="font-weight: 700; color: #374151; font-size: 0.95rem;">الاسم الكامل</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" style="width: 100%; padding: 1rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1.25rem; font-size: 1rem; transition: all 0.3s ease; outline: none;" onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 4px rgba(59, 130, 246, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                            @error('name') <span style="color: #ef4444; font-size: 0.85rem; font-weight: 600;">{{ $message }}</span> @enderror
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <label style="font-weight: 700; color: #374151; font-size: 0.95rem;">رقم الهاتف</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 1rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1.25rem; font-size: 1rem; transition: all 0.3s ease; outline: none;" onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 4px rgba(16, 185, 129, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                            @error('phone') <span style="color: #ef4444; font-size: 0.85rem; font-weight: 600;">{{ $message }}</span> @enderror
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <label style="font-weight: 700; color: #374151; font-size: 0.95rem;">البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" style="width: 100%; padding: 1rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1.25rem; font-size: 1rem; transition: all 0.3s ease; outline: none;" onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 4px rgba(139, 92, 246, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                            @error('email') <span style="color: #ef4444; font-size: 0.85rem; font-weight: 600;">{{ $message }}</span> @enderror
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <label style="font-weight: 700; color: #374151; font-size: 0.95rem;">العنوان</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}" style="width: 100%; padding: 1rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1.25rem; font-size: 1rem; transition: all 0.3s ease; outline: none;" onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                        </div>
                    </div>

                    <!-- Role Specific Section -->
                    @if($user->isPatient())
                        <div style="background: #f0f9ff; padding: 2.5rem; border-radius: 2rem; border: 1px solid #e0f2fe; margin-bottom: 2.5rem;">
                            <h3 style="font-size: 1.25rem; font-weight: 800; color: #0369a1; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <i class="fas fa-notes-medical"></i> المعلومات الطبية
                            </h3>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <label style="font-weight: 700; color: #374151; font-size: 0.9rem;">فصيلة الدم</label>
                                    <select name="blood_type" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1rem; background: white; outline: none;">
                                        <option value="">اختر</option>
                                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                            <option value="{{ $type }}" {{ old('blood_type', $user->patient->blood_type ?? '') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <label style="font-weight: 700; color: #374151; font-size: 0.9rem;">تاريخ الميلاد</label>
                                    <input type="date" name="birth_date" value="{{ old('birth_date', (isset($user->patient) && $user->patient->birth_date) ? \Carbon\Carbon::parse($user->patient->birth_date)->format('Y-m-d') : '') }}" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1rem; outline: none;">
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <label style="font-weight: 700; color: #374151; font-size: 0.9rem;">الجنس</label>
                                    <select name="gender" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1rem; background: white; outline: none;">
                                        <option value="">اختر</option>
                                        <option value="male" {{ old('gender', $user->patient->gender ?? '') == 'male' ? 'selected' : '' }}>ذكر</option>
                                        <option value="female" {{ old('gender', $user->patient->gender ?? '') == 'female' ? 'selected' : '' }}>أنثى</option>
                                    </select>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <label style="font-weight: 700; color: #374151; font-size: 0.9rem;">جهة اتصال الطوارئ</label>
                                    <input type="text" name="emergency_contact" value="{{ old('emergency_contact', $user->patient->emergency_contact ?? '') }}" placeholder="الاسم والرقم" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1rem; outline: none;">
                                </div>
                            </div>
                        </div>
                    @elseif($user->isDoctor())
                        <div style="background: #f0fdf4; padding: 2.5rem; border-radius: 2rem; border: 1px solid #dcfce7; margin-bottom: 2.5rem;">
                            <h3 style="font-size: 1.25rem; font-weight: 800; color: #166534; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <i class="fas fa-briefcase-medical"></i> المعلومات المهنية
                            </h3>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <label style="font-weight: 700; color: #374151; font-size: 0.9rem;">القسم</label>
                                    <select name="department_id" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1rem; background: white; outline: none;">
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ old('department_id', $user->doctor->department_id ?? '') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <label style="font-weight: 700; color: #374151; font-size: 0.9rem;">التخصص</label>
                                    <select name="specialization_id" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1rem; background: white; outline: none;">
                                        @foreach($specializations as $spec)
                                            <option value="{{ $spec->id }}" {{ old('specialization_id', $user->doctor->specialization_id ?? '') == $spec->id ? 'selected' : '' }}>{{ $spec->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <label style="font-weight: 700; color: #374151; font-size: 0.9rem;">رقم الترخيص</label>
                                    <input type="text" name="license_number" value="{{ old('license_number', $user->doctor->license_number ?? '') }}" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1rem; outline: none;">
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <label style="font-weight: 700; color: #374151; font-size: 0.9rem;">سنوات الخبرة</label>
                                    <input type="number" name="experience_years" value="{{ old('experience_years', $user->doctor->experience_years ?? 0) }}" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1rem; outline: none;">
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <label style="font-weight: 700; color: #374151; font-size: 0.9rem;">رسوم الاستشارة (ريال)</label>
                                    <input type="number" step="0.01" name="consultation_fee" value="{{ old('consultation_fee', $user->doctor->consultation_fee ?? 0) }}" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1rem; outline: none;">
                                </div>
                            </div>
                            <div style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem;">
                                <label style="font-weight: 700; color: #374151; font-size: 0.9rem;">السيرة الذاتية</label>
                                <textarea name="bio" rows="3" style="width: 100%; padding: 1rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1.25rem; outline: none; resize: vertical;">{{ old('bio', $user->doctor->bio ?? '') }}</textarea>
                            </div>
                        </div>
                    @endif

                    <!-- Password Section -->
                    <div style="background: #f8fafc; padding: 2.5rem; border-radius: 2rem; border: 1px solid #e2e8f0; margin-bottom: 3rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 800; color: #475569; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                            <i class="fas fa-lock"></i> تغيير كلمة المرور (اختياري)
                        </h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                            <input type="password" name="current_password" placeholder="كلمة المرور الحالية" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1rem; outline: none;">
                            <input type="password" name="password" placeholder="كلمة مرور جديدة" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1rem; outline: none;">
                            <input type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 1rem; outline: none;">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                        <button type="submit" style="flex: 2; min-width: 200px; padding: 1.25rem; background: linear-gradient(135deg, #10b981, #059669); color: white; font-size: 1.25rem; font-weight: 800; border: none; border-radius: 1.5rem; cursor: pointer; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2); transition: all 0.3s ease;">
                            <i class="fas fa-save" style="margin-left: 0.5rem;"></i> حفظ التغييرات
                        </button>
                        <a href="{{ route('profile.show') }}" style="flex: 1; min-width: 150px; padding: 1.25rem; background: white; color: #374151; font-size: 1.25rem; font-weight: 800; border: 2px solid #e2e8f0; border-radius: 1.5rem; text-decoration: none; text-align: center; transition: all 0.3s ease;">
                            إلغاء
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Avatar Preview
    document.getElementById('avatar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('avatar-preview');
                const placeholder = document.getElementById('avatar-placeholder');
                
                if (img) {
                    img.src = e.target.result;
                } else if (placeholder) {
                    const newImg = document.createElement('img');
                    newImg.id = 'avatar-preview';
                    newImg.src = e.target.result;
                    newImg.style.width = '100%';
                    newImg.style.height = '100%';
                    newImg.style.borderRadius = '2.5rem';
                    newImg.style.objectFit = 'cover';
                    newImg.style.border = '5px solid white';
                    newImg.style.boxShadow = '0 15px 25px rgba(0,0,0,0.1)';
                    placeholder.parentNode.replaceChild(newImg, placeholder);
                }
            }
            reader.readAsDataURL(file);
        }
    });

    // Simple Form Validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const pass = document.querySelector('input[name="password"]').value;
        const confirm = document.querySelector('input[name="password_confirmation"]').value;
        if (pass && pass !== confirm) {
            e.preventDefault();
            alert('كلمات المرور الجديدة غير متطابقة!');
        }
    });
</script>
@endsection
