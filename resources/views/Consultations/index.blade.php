@extends('layouts.app')
@section('title', 'الاستشارات الطبية')

@section('content')
<div class="section-head" style="margin-top: 100px;">
    <span class="sec-tag">الاستشارات</span>
    <h2>استشارات طبية عن بعد</h2>
    <p>تواصل مع نخبة من الأطباء من منزلك وبكل خصوصية</p>
</div>

<div class="container">
    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
        <div>
            <div class="card" style="margin-bottom: 1.5rem;">
                <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1.5rem;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0;">مساعدك الطبي الذكي</h4>
                        <p style="margin: 0; font-size: 0.85rem; color: var(--gray-500);">اطرح أسئلتك وسيجيبك الذكاء الاصطناعي فوراً</p>
                    </div>
                </div>
                <div style="background: var(--gray-50); border-radius: 12px; padding: 1.5rem; min-height: 200px; margin-bottom: 1rem; border: 1px solid var(--gray-200);">
                    <p style="color: var(--gray-500); text-align: center; margin-top: 70px;">ابدأ المحادثة الآن...</p>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="text" class="form-control" placeholder="اكتب سؤالك هنا...">
                    <button class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </div>
        </div>

        <div class="card">
            <h4 style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--gray-200); padding-bottom: 0.5rem;">أطباء متاحون الآن</h4>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach([
                    ['name' => 'د. أحمد محمود', 'spec' => 'طب عام', 'img' => 'https://i.pravatar.cc/150?u=1'],
                    ['name' => 'د. سارة علي', 'spec' => 'أطفال', 'img' => 'https://i.pravatar.cc/150?u=2'],
                    ['name' => 'د. خالد حسن', 'spec' => 'باطنة', 'img' => 'https://i.pravatar.cc/150?u=3']
                ] as $doc)
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <img src="{{ $doc['img'] }}" style="width: 50px; height: 50px; border-radius: 12px; object-fit: cover;">
                    <div style="flex: 1;">
                        <div style="font-weight: 700; font-size: 0.9rem;">{{ $doc['name'] }}</div>
                        <div style="font-size: 0.8rem; color: var(--primary);">{{ $doc['spec'] }}</div>
                    </div>
                    <button class="btn btn-outline btn-sm" style="padding: 0.3rem 0.6rem;">اتصال</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
