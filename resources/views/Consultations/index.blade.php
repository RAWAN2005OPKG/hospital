@extends('layouts.app')

@section('title', 'الاستشارات الطبية')

@section('content')
<div style="padding-top: 120px; min-height: 100vh; background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 38%, #ecfeff 100%); padding: 3rem 1.5rem;">
    <div style="max-width: 1400px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 3rem;">
            <span style="display: inline-block; padding: 0.5rem 1.5rem; background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; border-radius: 2rem; font-size: 0.9rem; font-weight: bold; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);">
                الاستشارات الطبية
            </span>
            <h1 style="font-size: 3rem; font-weight: 900; color: #111827; margin: 0 0 1rem 0;">استشارات طبية عن بعد</h1>
            <p style="font-size: 1.25rem; color: #6b7280; margin: 0; max-width: 600px; margin-left: auto; margin-right: auto;">تواصل مع نخبة من الأطباء من منزلك وبكل خصوصية</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
            <!-- Chat Section -->
            <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 2rem; border: 1px solid #e5e7eb;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #06b6d4, #0891b2); border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.75rem; box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <div>
                        <h2 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin: 0;">مساعدك الطبي الذكي</h2>
                        <p style="font-size: 0.9rem; color: #6b7280; margin: 0.25rem 0 0 0;">متاح 24/7 للإجابة على استفساراتك</p>
                    </div>
                </div>
                <div style="background: #f9fafb; border-radius: 1.25rem; padding: 2rem; min-height: 300px; margin-bottom: 1.5rem; border: 1px solid #e5e7eb; display: flex; justify-content: center; align-items: center; color: #9ca3af;">
                    <div style="text-align: center;">
                        <i class="fa-solid fa-comments" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                        <p style="margin: 0; font-weight: 600;">ابدأ المحادثة الآن لوصف حالتك...</p>
                    </div>
                </div>
                <form action="#" style="display: flex; gap: 1rem;">
                    <input type="text" style="flex: 1; padding: 1rem 1.5rem; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 1.25rem; outline: none; color: #111827; font-size: 1rem; transition: all 0.3s ease;" placeholder="اكتب سؤالك هنا...">
                    <button type="submit" style="padding: 1rem 2rem; background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; font-weight: bold; border-radius: 1.25rem; border: none; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);">
                        <i class="fa-solid fa-paper-plane"></i>
                        إرسال
                    </button>
                </form>
            </div>

            <!-- Sidebar Doctors -->
            <div style="background: white; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 2rem; border: 1px solid #e5e7eb;">
                <h2 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-user-doctor" style="color: #06b6d4;"></i>
                    أطباء متاحون الآن
                </h2>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @php $realDoctors = \App\Models\Doctor::with('user', 'specialization')->limit(5)->get(); @endphp
                    @foreach($realDoctors as $doc)
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f9fafb; border-radius: 1rem; border: 1px solid #e5e7eb; transition: all 0.3s ease; hover: background: #ecfeff; hover: border-color: #06b6d4;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #06b6d4, #0891b2); border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.25rem; flex-shrink: 0;">
                            {{ mb_substr($doc->user->name, 0, 1) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: bold; color: #111827; margin-bottom: 0.25rem;">{{ $doc->user->name }}</div>
                            <div style="font-size: 0.85rem; color: #06b6d4; font-weight: 600;">{{ $doc->specialization->name ?? 'طبيب عام' }}</div>
                        </div>
                        <a href="{{ route('doctors.show', $doc) }}" style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; border-radius: 0.75rem; font-size: 0.85rem; font-weight: bold; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(6, 182, 212, 0.2);">
                            <i class="fas fa-phone"></i> اتصال
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
