@extends('layouts.app')

@section('title', 'جدول المواعيد — MediFlow Gaza')

@section('content')
<div style="padding-top: 80px; min-height: 100vh; background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); padding: 3rem 1.5rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
            <div>
                <h1 style="font-size: 2.2rem; font-weight: 900; color: #111827; margin: 0; display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-calendar-alt" style="color: #3b82f6;"></i>
                    جدولة المواعيد
                </h1>
                <p style="font-size: 1.1rem; color: #6b7280; margin: 0.5rem 0 0 0;">إدارة فترات التوافر والجدول الزمني الخاص بك</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button style="padding: 0.8rem 1.5rem; background: white; color: #111827; border: 2px solid #e5e7eb; font-weight: bold; border-radius: 1rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease;">
                    <i class="fas fa-print"></i>
                    <span>طباعة الجدول</span>
                </button>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
            
            <!-- Main Content: Weekly Calendar -->
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                
                <!-- Week Selector & Days -->
                <div style="background: white; border-radius: 2rem; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; overflow: hidden;">
                    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center; background: #fcfdfe;">
                        <h3 style="font-size: 1.25rem; font-weight: 800; color: #111827; margin: 0;">الجدول الأسبوعي</h3>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <button style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #e5e7eb; background: white; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #6b7280;"><i class="fas fa-chevron-right"></i></button>
                            <span style="font-weight: 700; color: #374151;">14 - 20 يونيو 2026</span>
                            <button style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #e5e7eb; background: white; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #6b7280;"><i class="fas fa-chevron-left"></i></button>
                        </div>
                    </div>
                    
                    <div style="padding: 2rem; display: grid; grid-template-columns: repeat(7, 1fr); gap: 1rem;">
                        @php
                            $days = [
                                ['name' => 'الأحد', 'date' => '14'],
                                ['name' => 'الإثنين', 'date' => '15'],
                                ['name' => 'الثلاثاء', 'date' => '16'],
                                ['name' => 'الأربعاء', 'date' => '17'],
                                ['name' => 'الخميس', 'date' => '18'],
                                ['name' => 'الجمعة', 'date' => '19'],
                                ['name' => 'السبت', 'date' => '20'],
                            ];
                        @endphp
                        @foreach($days as $day)
                            <div style="text-align: center; padding: 1.25rem 0.5rem; border-radius: 1.5rem; border: 2px solid {{ $loop->first ? '#3b82f6' : '#f3f4f6' }}; background: {{ $loop->first ? '#eff6ff' : 'white' }}; cursor: pointer; transition: all 0.3s ease;">
                                <p style="font-size: 0.9rem; font-weight: 700; color: {{ $loop->first ? '#3b82f6' : '#6b7280' }}; margin: 0 0 0.5rem 0;">{{ $day['name'] }}</p>
                                <p style="font-size: 1.5rem; font-weight: 900; color: {{ $loop->first ? '#1d4ed8' : '#111827' }}; margin: 0;">{{ $day['date'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Time Slots Grid -->
                <div style="background: white; border-radius: 2rem; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; padding: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 800; color: #111827; margin: 0; display: flex; align-items: center; gap: 0.75rem;">
                            <i class="fas fa-clock" style="color: #10b981;"></i>
                            الفترات المتاحة ليوم الأحد
                        </h3>
                        <button style="padding: 0.6rem 1.2rem; background: #ecfdf5; color: #059669; border: 1px solid #10b981; font-weight: bold; border-radius: 0.75rem; cursor: pointer; font-size: 0.9rem;">
                            <i class="fas fa-plus-circle mr-1"></i> إضافة فترة
                        </button>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 1.25rem;">
                        @for($i = 9; $i < 17; $i++)
                            <div style="padding: 1.25rem; background: #f9fafb; border: 2px solid #f3f4f6; border-radius: 1.25rem; text-align: center; position: relative; transition: all 0.3s ease; cursor: pointer;">
                                <div style="font-size: 1.25rem; font-weight: 800; color: #111827; margin-bottom: 0.25rem;">{{ sprintf('%02d:00', $i) }}</div>
                                <div style="font-size: 0.8rem; font-weight: 700; color: #10b981; display: flex; align-items: center; justify-content: center; gap: 0.25rem;">
                                    <i class="fas fa-check-circle" style="font-size: 0.7rem;"></i> متاح
                                </div>
                                <button style="position: absolute; top: -10px; left: -10px; width: 25px; height: 25px; background: #fee2e2; color: #ef4444; border: none; border-radius: 50%; font-size: 0.7rem; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endfor
                        <div style="padding: 1.25rem; background: #fffbeb; border: 2px solid #fef3c7; border-radius: 1.25rem; text-align: center; opacity: 0.7;">
                            <div style="font-size: 1.25rem; font-weight: 800; color: #111827; margin-bottom: 0.25rem;">17:00</div>
                            <div style="font-size: 0.8rem; font-weight: 700; color: #f59e0b; display: flex; align-items: center; justify-content: center; gap: 0.25rem;">
                                <i class="fas fa-user-clock" style="font-size: 0.7rem;"></i> محجوز
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Controls & Settings -->
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                
                <!-- Quick Settings -->
                <div style="background: white; border-radius: 2rem; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; padding: 2rem;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #111827; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-cog" style="color: #6b7280;"></i>
                        إعدادات سريعة
                    </h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div>
                            <label style="display: block; font-weight: 700; color: #374151; margin-bottom: 0.75rem; font-size: 0.9rem;">مدة الجلسة (دقائق)</label>
                            <select style="width: 100%; padding: 0.8rem; border: 2px solid #f3f4f6; border-radius: 1rem; background: #f9fafb; font-weight: 600; color: #111827; cursor: pointer;">
                                <option>15 دقيقة</option>
                                <option selected>30 دقيقة</option>
                                <option>45 دقيقة</option>
                                <option>60 دقيقة</option>
                            </select>
                        </div>
                        
                        <div style="padding: 1rem; background: #fff7ed; border-radius: 1rem; border: 1px solid #ffedd5;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-weight: 700; color: #9a3412; font-size: 0.9rem;">وضع العطلة</span>
                                <div style="width: 40px; height: 20px; background: #fdba74; border-radius: 10px; position: relative; cursor: pointer;">
                                    <div style="width: 16px; height: 16px; background: white; border-radius: 50%; position: absolute; top: 2px; right: 2px;"></div>
                                </div>
                            </div>
                            <p style="font-size: 0.75rem; color: #c2410c; margin: 0.5rem 0 0 0;">إيقاف استقبال المواعيد مؤقتاً</p>
                        </div>
                        
                        <button style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 1rem; font-weight: 800; font-size: 1rem; cursor: pointer; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2); transition: all 0.3s ease;">
                            حفظ التغييرات
                        </button>
                    </div>
                </div>

                <!-- Legend -->
                <div style="background: white; border-radius: 2rem; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; padding: 1.5rem;">
                    <h4 style="font-size: 0.9rem; font-weight: 800; color: #111827; margin-bottom: 1rem;">دليل الألوان</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 12px; height: 12px; border-radius: 3px; background: #10b981;"></div>
                            <span style="font-size: 0.85rem; font-weight: 600; color: #4b5563;">فترة متاحة</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 12px; height: 12px; border-radius: 3px; background: #f59e0b;"></div>
                            <span style="font-size: 0.85rem; font-weight: 600; color: #4b5563;">فترة محجوزة</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 12px; height: 12px; border-radius: 3px; background: #f3f4f6; border: 1px solid #e5e7eb;"></div>
                            <span style="font-size: 0.85rem; font-weight: 600; color: #4b5563;">غير متاح</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
