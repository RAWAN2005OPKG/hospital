@extends('layouts.app')

@section('title', 'إضافة قسم جديد - صحتي')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-8 py-8">
                <h1 class="text-3xl font-black text-white mb-2">إضافة قسم جديد</h1>
                <p class="text-blue-100">أضف قسم طبي جديد إلى المستشفى</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('admin.departments.store') }}" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-hospital ml-2 text-blue-600"></i>اسم القسم
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-blue-500 focus:outline-none transition @error('name') border-red-500 @enderror"
                        placeholder="مثال: قسم القلب">
                    @error('name')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle ml-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-file-alt ml-2 text-blue-600"></i>الوصف
                    </label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-blue-500 focus:outline-none transition @error('description') border-red-500 @enderror"
                        placeholder="أضف وصف عن القسم">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle ml-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Manager Name -->
                <div>
                    <label for="manager_name" class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-user-tie ml-2 text-blue-600"></i>اسم مسؤول القسم
                    </label>
                    <input type="text" id="manager_name" name="manager_name" value="{{ old('manager_name') }}" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-blue-500 focus:outline-none transition @error('manager_name') border-red-500 @enderror"
                        placeholder="أدخل اسم المسؤول">
                    @error('manager_name')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle ml-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-phone ml-2 text-blue-600"></i>رقم الجوال
                    </label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                        class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-blue-500 focus:outline-none transition @error('phone') border-red-500 @enderror"
                        placeholder="+966 50 000 0000">
                    @error('phone')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle ml-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-bold text-slate-700 mb-2">
                        <i class="fas fa-image ml-2 text-blue-600"></i>صورة القسم
                    </label>
                    <div class="relative">
                        <input type="file" id="image" name="image" accept="image/*"
                            class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-blue-500 focus:outline-none transition @error('image') border-red-500 @enderror"
                            onchange="previewImage(event)">
                        @error('image')
                            <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle ml-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="previewImg" src="" alt="معاينة الصورة" class="w-full h-64 object-cover rounded-lg">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-6">
                    <button type="submit" class="flex-1 py-3 px-4 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold hover:shadow-lg transition">
                        <i class="fas fa-save ml-2"></i>حفظ القسم
                    </button>
                    <a href="{{ route('admin.departments.index') }}" class="flex-1 py-3 px-4 rounded-lg border-2 border-slate-200 text-slate-700 font-bold hover:bg-slate-50 transition text-center">
                        <i class="fas fa-times ml-2"></i>إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>

@endsection