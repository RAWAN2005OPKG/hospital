<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Hospital System') }} - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Cairo', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.4); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(99, 102, 241, 0.6); }
    </style>
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen antialiased overflow-hidden">
    <div x-data="{ darkMode: true, sidebarOpen: window.innerWidth >= 1024 }" class="flex h-screen">
        
        <!-- Animated Background -->
        <div class="fixed inset-0 z-0">
            <div class="absolute top-1/4 -left-1/4 w-96 h-96 bg-purple-500/30 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 -right-1/4 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
            <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-pink-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s"></div>
        </div>

        <!-- Sidebar -->
        <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" 
               x-transition:enter-start="-translate-x-full" 
               x-transition:enter-end="translate-x-0"
               class="fixed lg:relative inset-y-0 lg:inset-auto -left-full lg:left-auto z-50 w-72 h-screen lg:h-auto bg-black/40 backdrop-blur-2xl border-l border-white/10 shadow-2xl lg:shadow-none flex flex-col">
            
            <!-- Logo Section -->
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/30">
                        <i class="fas fa-heartbeat text-xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">مستشفى الحياة</h1>
                        <p class="text-xs text-white/50">Hospital System</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 overflow-y-auto space-y-2">
                @auth
                    <div x-data="{ userRole: '{{ auth()->user()->role }}' }">
                        
                        <!-- Patient Links -->
                        <template x-if="userRole === 'patient'">
                            <div class="space-y-1">
                                <x-nav-link href="{{ route('patient.dashboard') }}" :active="request()->routeIs('patient.*')" icon="fa-home">
                                    الرئيسية
                                </x-nav-link>
                                <x-nav-link href="{{ route('patient.appointments') }}" :active="request()->routeIs('patient.appointments')" icon="fa-calendar-check">
                                    مواعيدي
                                </x-nav-link>
                                <x-nav-link href="{{ route('patient.medical-records') }}" :active="request()->routeIs('patient.medical-records*')" icon="fa-file-medical">
                                    السجلات الطبية
                                </x-nav-link>
                            </div>
                        </template>

                        <!-- Doctor Links -->
                        <template x-if="userRole === 'doctor'">
                            <div class="space-y-1">
                                <x-nav-link href="{{ route('doctor.dashboard') }}" :active="request()->routeIs('doctor.dashboard')" icon="fa-home">
                                    الرئيسية
                                </x-nav-link>
                                <x-nav-link href="{{ route('doctor.appointments') }}" :active="request()->routeIs('doctor.appointments')" icon="fa-calendar">
                                    المواعيد
                                </x-nav-link>
                                <x-nav-link href="{{ route('doctor.patients') }}" :active="request()->routeIs('doctor.patients')" icon="fa-users">
                                    المرضى
                                </x-nav-link>
                            </div>
                        </template>

                        <!-- Admin Links -->
                        <template x-if="userRole === 'admin'">
                            <div class="space-y-1">
                                <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" icon="fa-home">
                                    الرئيسية
                                </x-nav-link>
                                <x-nav-link href="{{ route('admin.departments') }}" :active="request()->routeIs('admin.departments')" icon="fa-building">
                                    الأقسام
                                </x-nav-link>
                                <x-nav-link href="{{ route('admin.doctors') }}" :active="request()->routeIs('admin.doctors')" icon="fa-user-md">
                                    الأطباء
                                </x-nav-link>
                                <x-nav-link href="{{ route('admin.appointments') }}" :active="request()->routeIs('admin.appointments')" icon="fa-calendar-alt">
                                    المواعيد
                                </x-nav-link>
                                <x-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')" icon="fa-users">
                                    المستخدمين
                                </x-nav-link>
                            </div>
                        </template>
                    </div>

                    <!-- Common Links -->
                    <div class="pt-6 mt-6 border-t border-white/10 space-y-1">
                        <x-nav-link href="{{ route('appointments.search') }}" icon="fa-search">
                            حجز موعد
                        </x-nav-link>
                        <x-nav-link href="{{ route('profile.edit') }}" :active="request()->routeIs('profile.*')" icon="fa-user">
                            الملف الشخصي
                        </x-nav-link>
                    </div>
                @endauth
            </nav>

            <!-- Footer -->
            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl transition-all group">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="font-medium">تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"></div>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden relative z-10">
            
            <!-- Header -->
            <header class="bg-black/20 backdrop-blur-xl border-b border-white/10 sticky top-0 z-40">
                <div class="px-4 lg:px-8 py-4">
                    <div class="flex items-center justify-between">
                        <!-- Mobile Menu Button -->
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-3 bg-white/10 hover:bg-white/20 rounded-xl transition-all">
                            <i class="fas fa-bars text-white"></i>
                        </button>

                        <!-- Page Title -->
                        <div class="flex items-center gap-4">
                            <h2 class="text-xl lg:text-2xl font-bold text-white">@yield('header')</h2>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="flex items-center gap-4">
                            <!-- Notifications -->
                            <button class="relative p-3 bg-white/10 hover:bg-white/20 rounded-xl transition-all text-white">
                                <i class="fas fa-bell"></i>
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                            </button>
                            
                            <!-- Profile -->
                            <div class="flex items-center gap-3 p-2 bg-white/10 hover:bg-white/20 rounded-xl transition-all cursor-pointer">
                                <img class="w-10 h-10 rounded-xl ring-2 ring-purple-500 shadow-lg" 
                                     src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=8B5CF6&color=fff&size=128' }}" 
                                     alt="">
                                <div class="hidden sm:block">
                                    <p class="font-bold text-white text-sm">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-white/60">{{ auth()->user()->role === 'admin' ? 'مدير النظام' : (auth()->user()->role === 'doctor' ? 'طبيب' : 'مريض') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="flex-1 p-4 lg:p-8 overflow-y-auto">
                
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-6 bg-emerald-500/20 backdrop-blur-xl border border-emerald-500/30 rounded-2xl p-4 flex items-center gap-4 animate-fade-in">
                        <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <p class="text-emerald-100 font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-500/20 backdrop-blur-xl border border-red-500/30 rounded-2xl p-4 flex items-center gap-4 animate-fade-in">
                        <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-exclamation text-white"></i>
                        </div>
                        <p class="text-red-100 font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('nav', () => ({
                active: window.location.pathname
            }))
        })
    </script>
</body>
</html>