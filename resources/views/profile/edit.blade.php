<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
            <i class="fas fa-user-cog mr-3 text-blue-500"></i>
            تعديل الملف الشخصي
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-8">
        {{-- Profile Avatar --}}
        <div class="bg-white dark:bg-gray-900 rounded-4xl shadow-2xl border border-gray-200 dark:border-gray-700 p-12 text-center">
            <div class="mx-auto w-32 h-32 relative mb-8">
                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=256&background=4f46e5&color=fff' }}" 
                     alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover shadow-2xl border-8 border-white dark:border-gray-900">
                <label for="avatar" class="absolute -bottom-4 -right-4 w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl flex items-center justify-center text-white shadow-2xl cursor-pointer hover:shadow-3xl hover:scale-110 transition-all border-4 border-white">
                    <i class="fas fa-camera text-xl"></i>
                    <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                </label>
            </div>
            <div class="space-y-2">
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                <p class="text-emerald-600 dark:text-emerald-400 font-semibold text-xl">{{ $user->role ?? 'مريض' }}</p>
            </div>
        </div>

        {{-- Main Form --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-900 rounded-4xl shadow-2xl border border-gray-200 dark:border-gray-700 p-10 space-y-8">
            @csrf
            @method('PATCH')

            {{-- Personal Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">الاسم الكامل</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           class="w-full px-6 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-xl @error('name') border-red-500 @enderror"
                           placeholder="الاسم الكامل">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">رقم الهاتف</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" 
                           class="w-full px-6 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-xl @error('phone') border-red-500 @enderror"
                           placeholder="+966 50 123 4567">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="w-full px-6 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all shadow-xl @error('email') border-red-500 @enderror"
                           placeholder="your@email.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">العمر</label>
                    <input type="number" name="age" value="{{ old('age', $user->age) }}" min="1" max="120"
                           class="w-full px-6 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 transition-all shadow-xl @error('age') border-red-500 @enderror"
                           placeholder="العمر">
                    @error('age')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">العنوان</label>
                <textarea name="address" rows="4" placeholder="العنوان الكامل..." 
                          class="w-full px-6 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-xl @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Gender & Other Options --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">الجنس</label>
                    <select name="gender" class="w-full px-6 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-pink-500/20 focus:border-pink-500 transition-all shadow-xl">
                        <option value="">اختر</option>
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3">تاريخ الميلاد</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" 
                           class="w-full px-6 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-yellow-500/20 focus:border-yellow-500 transition-all shadow-xl">
                </div>
                <div class="flex items-end">
                    <label class="flex items-center">
                        <input type="checkbox" name="newsletter" {{ old('newsletter', $user->newsletter ?? true) ? 'checked' : '' }} class="w-5 h-5 text-emerald-600 rounded border-gray-300 dark:border-gray-700 focus:ring-emerald-500">
                        <span class="ml-3 text-sm font-bold text-gray-900 dark:text-white cursor-pointer">تلقي النشرات الإخبارية</span>
                    </label>
                </div>
            </div>

            {{-- Password Section --}}
            <div class="bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-800 dark:to-blue-900/20 p-8 rounded-3xl border border-gray-200 dark:border-gray-700">
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-lock mr-3 text-blue-500"></i>
                    تغيير كلمة المرور
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <input type="password" name="current_password" placeholder="كلمة المرور الحالية" 
                           class="px-6 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 transition-all shadow-xl">
                    <input type="password" name="password" placeholder="كلمة مرور جديدة" 
                           class="px-6 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-xl">
                    <input type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور" 
                           class="px-6 py-4 border-2 border-gray-200 dark:border-gray-700 rounded-3xl bg-white dark:bg-gray-800 focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-xl">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-6 pt-8 border-t-4 border-gray-200 dark:border-gray-700">
                <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-600 to-blue-600 text-white font-bold py-5 px-12 rounded-3xl shadow-2xl hover:shadow-3xl hover:-translate-y-1 transition-all text-xl">
                    <i class="fas fa-save mr-3"></i>
                    حفظ التغييرات
                </button>
                <a href="{{ route('profile') }}" class="flex-1 flex items-center justify-center space-x-3 rtl:space-x-reverse px-12 py-5 bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-bold rounded-3xl shadow-2xl hover:shadow-3xl border-2 border-gray-200 dark:border-gray-700 transition-all">
                    <i class="fas fa-times"></i>
                    <span>إلغاء</span>
                </a>
            </div>
        </form>
    </div>

    <script>
        // Avatar upload preview
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.rounded-full.object-cover').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Form validation enhancement
        document.querySelector('form').addEventListener('submit', function() {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="password_confirmation"]').value;
            if (password && password !== confirmPassword) {
                alert('كلمات المرور غير متطابقة!');
                return false;
            }
        });

        // Smooth animations
        document.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('focus', () => input.parentElement.style.transform = 'scale(1.02)');
            input.addEventListener('blur', () => input.parentElement.style.transform = 'scale(1)');
        });
    </script>
</x-app-layout>
