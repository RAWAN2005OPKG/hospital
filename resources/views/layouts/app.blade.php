<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'صحتي - نظام إدارة صحتك')</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&family=Tajawal:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            font-family: 'Cairo', 'Tajawal', sans-serif;
        }
        
        :root {
            --primary: #5b8fc7;
            --secondary: #1abc9c;
            --dark-blue: #1e3a5f;
            --light-bg: #e8f4f8;
        }
        
        body {
            background: linear-gradient(135deg, #e8f4f8 0%, #f0f9ff 100% );
            color: #1e293b;
        }
        
        .btn-primary {
            @apply px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-full hover:shadow-lg transition font-semibold;
        }
        
        .btn-secondary {
            @apply px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-full hover:shadow-lg transition font-semibold;
        }
        
        .btn-outline {
            @apply px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-full hover:bg-blue-50 transition font-semibold;
        }
        
        .card {
            @apply bg-white rounded-3xl shadow-lg p-6 border border-blue-100 hover:shadow-2xl transition;
        }
        
        .input-field {
            @apply w-full px-4 py-3 border-2 border-blue-200 rounded-2xl focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition;
        }
        
        .section-title {
            @apply text-4xl font-bold text-blue-900 mb-2;
        }
        
        .green-dot {
            @apply w-10 h-10 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center text-white shadow-lg;
        }
        
        .nav-link {
            @apply text-gray-700 hover:text-blue-600 transition font-semibold;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-2 space-x-reverse">
                    <i class="fas fa-heart text-2xl text-red-500"></i>
                    <span class="text-2xl font-bold text-blue-900">صحتي</span>
                </div>

                <!-- Menu -->
                @auth
                    <div class="hidden md:flex items-center space-x-8 space-x-reverse">
                        @if(auth()->user()->role === 'doctor')
                            <a href="{{ route('doctor.dashboard') }}" class="nav-link">لوحة التحكم</a>
                            <a href="{{ route('doctor.appointments') }}" class="nav-link">مواعيدي</a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">الإدارة</a>
                        @else
                            <a href="{{ route('home') }}" class="nav-link">الرئيسية</a>
                            <a href="{{ route('doctors.index') }}" class="nav-link">الأطباء</a>
                            <a href="{{ route('patient.appointments') }}" class="nav-link">مواعيدي</a>
                        @endif
                    </div>
                @else
                    <div class="hidden md:flex items-center space-x-8 space-x-reverse">
                        <a href="{{ route('home') }}" class="nav-link">الرئيسية</a>
                        <a href="{{ route('doctors.index') }}" class="nav-link">الأطباء</a>
                        <a href="{{ route('about') }}" class="nav-link">من نحن</a>
                    </div>
                @endauth

                <!-- User Menu -->
                <div class="flex items-center space-x-4 space-x-reverse">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center space-x-2 space-x-reverse">
                                <img src="https://via.placeholder.com/40x40?text=User" alt="صورة المستخدم" class="w-10 h-10 rounded-full">
                                <span class="text-sm font-bold text-gray-800">{{ auth( )->user()->name }}</span>
                            </button>
                            <div class="absolute left-0 mt-2 w-48 bg-white rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-t-2xl">
                                    <i class="fas fa-user ml-2"></i>البروفايل
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded-b-2xl">
                                        <i class="fas fa-sign-out-alt ml-2"></i>تسجيل الخروج
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 transition font-semibold">تسجيل الدخول</a>
                        <a href="{{ route('register') }}" class="btn-primary">إنشاء حساب</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-2xl flex items-center">
                <i class="fas fa-exclamation-circle ml-3 text-xl"></i>
                <div>
                    <h4 class="font-bold mb-1">حدثت أخطاء:</h4>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-2xl flex items-center">
                <i class="fas fa-check-circle ml-3 text-xl"></i>
                {{ session('success') }}
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-blue-900 to-blue-800 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 space-x-reverse mb-4">
                        <i class="fas fa-heart text-2xl text-red-400"></i>
                        <h3 class="text-xl font-bold">صحتي</h3>
                    </div>
                    <p class="text-blue-100">نظام إدارة صحتك الموثوق</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">الروابط</h4>
                    <ul class="space-y-2 text-blue-100">
                        <li><a href="{{ route('home') }}" class="hover:text-white">الرئيسية</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white">من نحن</a></li>
                        <li><a href="{{ route('doctors.index') }}" class="hover:text-white">الأطباء</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">التواصل</h4>
                    <ul class="space-y-2 text-blue-100">
                        <li><i class="fas fa-phone ml-2"></i>+966 50 000 0000</li>
                        <li><i class="fas fa-envelope ml-2"></i>info@sahati.com</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">تابعنا</h4>
                    <div class="flex space-x-4 space-x-reverse">
                        <a href="#" class="hover:text-blue-300"><i class="fab fa-facebook text-2xl"></i></a>
                        <a href="#" class="hover:text-blue-300"><i class="fab fa-twitter text-2xl"></i></a>
                        <a href="#" class="hover:text-blue-300"><i class="fab fa-instagram text-2xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-blue-700 pt-8 text-center text-blue-100">
                <p>&copy; 2024 صحتي. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts' )
</body>
</html>