@extends('layouts.app')
@section('title', __('messages.contact_us'))

@push('styles')
<style>
    :root {
        --primary: #0077B6;
        --primary-light: #e0f4ff;
        --secondary: #00B4D8;
        --gray-100: #f3f4f6;
        --gray-500: #6b7280;
        --white: #ffffff;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --border: #e5e7eb;
        --success: #10b981;
        --error: #ef4444;
    }

    .contact-hero {
        padding: 100px 0 50px;
        text-align: center;
        background: linear-gradient(180deg, rgba(224, 244, 255, 0.4) 0%, rgba(255, 255, 255, 0) 100%);
        margin-top: 80px;
    }

    .sec-tag {
        display: inline-block;
        padding: 6px 16px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .contact-hero h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    .contact-hero p {
        max-width: 600px;
        margin: 0 auto;
        color: var(--gray-500);
        font-size: 1.1rem;
    }

    .contact-section {
        padding: 40px 0 100px;
    }

    .contact-container {
        display: grid;
        grid-template-columns: 1fr 1.6fr;
        gap: 3rem;
        align-items: start;
    }

    @media (max-width: 768px) {
        .contact-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
    }

    .contact-info-card {
        background: var(--white);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }

    .contact-info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-light);
    }

    .contact-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .contact-info-text h4 {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    .contact-info-text p {
        font-size: 0.9rem;
        color: var(--gray-500);
        line-height: 1.5;
    }

    .contact-form-card {
        background: var(--white);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--gray-100);
    }

    .form-header i {
        color: var(--primary);
        font-size: 1.3rem;
    }

    .form-header h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .form-label .required {
        color: var(--error);
    }

    .form-control {
        padding: 11px 14px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 0.9rem;
        font-family: inherit;
        transition: all 0.3s ease;
        background: var(--white);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.1);
    }

    .form-control.is-invalid {
        border-color: var(--error);
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 130px;
    }

    .invalid-feedback {
        font-size: 0.8rem;
        color: var(--error);
        margin-top: 0.4rem;
        display: block;
    }

    .form-row-full {
        grid-column: 1 / -1;
    }

    .submit-btn {
        width: 100%;
        padding: 12px 20px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 119, 182, 0.3);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .alert {
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #047857;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .alert i {
        font-size: 1.2rem;
        flex-shrink: 0;
        margin-top: 0.1rem;
    }

    .alert ul {
        margin: 0.5rem 0 0 0;
        padding-left: 1.25rem;
    }

    .alert ul li {
        font-size: 0.9rem;
    }

    [dir="rtl"] .form-row {
        direction: rtl;
    }
</style>
@endpush

@section('content')
<div class="contact-hero">
    <div class="container">
        <span class="sec-tag">{{ __('messages.contact_us') }}</span>
        <h2>{{ __('messages.contact_us') }}</h2>
        <p>{{ __('messages.contact_info') }}</p>
    </div>
</div>

<div class="container contact-section">
    <div class="contact-container">
        <!-- Contact Information -->
        <div>
            @php
                $contactInfo = [
                    ['icon' => 'fa-location-dot', 'title' => __('messages.location'), 'value' => __('messages.location')],
                    ['icon' => 'fa-phone', 'title' => __('messages.phone'), 'value' => __('messages.phone')],
                    ['icon' => 'fa-envelope', 'title' => __('messages.email'), 'value' => __('messages.email')],
                ];
            @endphp

            @foreach($contactInfo as $info)
            <div class="contact-info-card">
                <div class="contact-icon">
                    <i class="fa-solid {{ $info['icon'] }}"></i>
                </div>
                <div class="contact-info-text">
                    <h4>{{ $info['title'] }}</h4>
                    <p>{{ $info['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Contact Form -->
        <div class="contact-form-card">
            <div class="form-header">
                <i class="fa-solid fa-paper-plane"></i>
                <h3>{{ __('messages.contact_us') }}</h3>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fa-solid fa-exclamation-circle"></i>
                    <div>
                        <strong>{{ app()->getLocale() === 'ar' ? 'خطأ في النموذج' : 'Form Error' }}</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-check-circle"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            {{ app()->getLocale() === 'ar' ? 'الاسم' : 'Name' }} <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name') }}" 
                            required
                            placeholder="{{ app()->getLocale() === 'ar' ? 'أدخل اسمك الكامل' : 'Enter your full name' }}"
                        >
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            {{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email' }} <span class="required">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email') }}" 
                            required
                            placeholder="your@email.com"
                        >
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group form-row-full">
                    <label class="form-label">
                        {{ app()->getLocale() === 'ar' ? 'الموضوع' : 'Subject' }} <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="subject" 
                        class="form-control @error('subject') is-invalid @enderror" 
                        value="{{ old('subject') }}" 
                        required
                        placeholder="{{ app()->getLocale() === 'ar' ? 'ما موضوع استفسارك؟' : 'What is your inquiry about?' }}"
                    >
                    @error('subject')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group form-row-full">
                    <label class="form-label">
                        {{ app()->getLocale() === 'ar' ? 'الرسالة' : 'Message' }} <span class="required">*</span>
                    </label>
                    <textarea 
                        name="message" 
                        class="form-control @error('message') is-invalid @enderror" 
                        required
                        placeholder="{{ app()->getLocale() === 'ar' ? 'اكتب رسالتك هنا...' : 'Write your message here...' }}"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-paper-plane"></i>
                    {{ app()->getLocale() === 'ar' ? 'إرسال الرسالة' : 'Send Message' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
