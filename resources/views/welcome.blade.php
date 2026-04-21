<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام المستشفى - حجز المواعيد الطبية المتطور</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .hero-gradient { background: linear-gradient(135deg, #3B82F6 0%, #1E40AF 50%, #1E3A8A 100%); }
        .glass { backdrop-filter: blur(20px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-emerald-50 overflow-x-hidden">
    <!-- Hero Section -->
    <section class="hero-gradient text-white py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-20">
                <div class="inline-flex items-center bg-white/20 backdrop-blur-xl px-8 py-4 rounded-3xl shadow-2xl mb-8">
                    <i class="fas fa-heartbeat text-3xl text-red-400 mr-4"></i>
                    <h1 class="text-5xl md:text-7xl font-bold bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                        نظام المستشفى
                    </h1>
                </div>
                <p class="text-xl md:text-2xl mb-12 max-w-3xl mx-auto opacity-90 leading-relaxed">
                    حجز مواعيد طبية متطور • استشارات فورية • سجلات طبية آمنة • إدارة شاملة للمستشفى
                </p>
                
                <!-- Search Form -->
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white/10 glass backdrop-blur-xl rounded-3xl p-1 shadow-2xl">
                        <form action="{{ route('appointments.search') }}" method="GET" class="flex flex-wrap gap-2 p-1 md:p-4">
                            <div class="flex-1 min-w-[200px]">
                                <label class="block text-sm font-medium mb-2 text-blue-100">البحث بالاسم أو التخصص</label>
                                <input type="text" name="search" placeholder="د. أحمد - جراحة قلب" 
                                       class="w-full px-6 py-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-white/50 focus:border-blue-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-lg placeholder-gray-500">
                            </div>
                            <div class="flex-1 min-w-[200px]">
                                <label class="block text-sm font-medium mb-2 text-blue-100">القسم</label>
                                <select name="department_id" class="w-full px-6 py-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-white/50 focus:border-blue-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-lg">
                                    <option>جميع الأقسام</option>
                                </select>
                            </div>
                            <div class="flex-1 min-w-[200px]">
                                <label class="block text-sm font-medium mb-2 text-blue-100">التخصص</label>
                                <select name="specialization_id" class="w-full px-6 py-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-white/50 focus:border-blue-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-lg">
                                    <option>جميع التخصصات</option>
                                </select>
                            </div>
                            <button type="submit" class="px-12 py-4 bg-white text-blue-600 font-bold text-lg rounded-2xl hover:bg-blue-50 hover:scale-105 transition-all shadow-2xl whitespace-nowrap">
                                <i class="fas fa-search mr-2"></i> ابحث عن طبيب
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid md:grid-cols-4 gap-8 mt-20">
                <div class="text-center p-8 bg-white/20 glass backdrop-blur-xl rounded-3xl shadow-2xl hover:scale-105 transition-all group">
                    <i class="fas fa-user-md text-5xl text-blue-200 mb-4 group-hover:text-blue-100 transition-all"></i>
                    <div class="text-4xl font-bold text-white mb-2">+150</div>
                    <div class="text-blue-100 font-semibold">طبيب متميز</div>
                </div>
                <div class="text-center p-8 bg-white/20 glass backdrop-blur-xl rounded-3xl shadow-2xl hover:scale-105 transition-all group">
                    <i class="fas fa-calendar-check text-5xl text-emerald-200 mb-4 group-hover:text-emerald-100 transition-all"></i>
                    <div class="text-4xl font-bold text-white mb-2">5000+</div>
                    <div class="text-blue-100 font-semibold">موعد شهرياً</div>
                </div>
                <div class="text-center p-8 bg-white/20 glass backdrop-blur-xl rounded-3xl shadow-2xl hover:scale-105 transition-all group">
                    <i class="fas fa-users text-5xl text-purple-200 mb-4 group-hover:text-purple-100 transition-all"></i>
                    <div class="text-4xl font-bold text-white mb-2">10000+</div>
                    <div class="text-blue-100 font-semibold">مريض سعيد</div>
                </div>
                <div class="text-center p-8 bg-white/20 glass backdrop-blur-xl rounded-3xl shadow-2xl hover:scale-105 transition-all group">
                    <i class="fas fa-clock text-5xl text-orange-200 mb-4 group-hover:text-orange-100 transition-all"></i>
                    <div class="text-4xl font-bold text-white mb-2">24/7</div>
                    <div class="text-blue-100 font-semibold">دعم متواصل</div>
                </div>
            </div>
        </div>
        
        <!-- Floating elements -->
        <div class="absolute top-1/2 left-10 w-72 h-72 bg-blue-300/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-emerald-300/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </section>

    <!-- Features -->
    <section class="py-32 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-24">
                <span class="inline-flex items-center bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                    <i class="fas fa-star mr-2"></i> مميزات النظام
                </span>
                <h2 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-6">
                    كل ما تحتاجه في مكان واحد
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    نظام متكامل لإدارة المستشفيات يوفر تجربة سلسة للمرضى والأطباء والإدارة
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="group hover:scale-105 transition-all duration-500">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-10 rounded-3xl shadow-2xl text-white mb-8 h-80 flex items-center justify-center group-hover:shadow-3xl transition-all">
                        <div>
                            <i class="fas fa-calendar-plus text-6xl mb-6 opacity-80"></i>
                            <h3 class="text-3xl font-bold mb-4">حجز ذكي</h3>
                            <p class="opacity-90 leading-relaxed">حجز مواعيد فوري مع عرض الفترات المتاحة والتأكيد التلقائي</p>
                        </div>
                    </div>
                </div>
                <div class="group hover:scale-105 transition-all duration-500">
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-10 rounded-3xl shadow-2xl text-white mb-8 h-80 flex items-center justify-center group-hover:shadow-3xl transition-all">
                        <div>
                            <i class="fas fa-file-alt text-6xl mb-6 opacity-80"></i>
                            <h3 class="text-3xl font-bold mb-4">سجلات طبية</h3>
                            <p class="opacity-90 leading-relaxed">سجلات طبية آمنة ومتاحة في أي وقت مع تاريخ المراجعات السابقة</p>
                        </div>
                    </div>
                </div>
                <div class="group hover:scale-105 transition-all duration-500">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-10 rounded-3xl shadow-2xl text-white mb-8 h-80 flex items-center justify-center group-hover:shadow-3xl transition-all">
                        <div>
                            <i class="fas fa-chart-line text-6xl mb-6 opacity-80"></i>
                            <h3 class="text-3xl font-bold mb-4">إدارة متقدمة</h3>
                            <p class="opacity-90 leading-relaxed">لوحة تحكم شاملة مع إحصائيات وتحليلات للإدارة الطبية</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 bg-gradient-to-r from-blue-600 to-emerald-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <div class="max-w-3xl mx-auto">
                <i class="fas fa-stethoscope text-7xl mb-8 opacity-80"></i>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">ابدأ رحلتك الصحية اليوم</h2>
                <p class="text-xl mb-12 opacity-90 leading-relaxed">انضم لآلاف المرضى الذين يثقون بنظامنا لإدارة صحتهم</p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="group relative px-12 py-6 bg-white text-blue-600 font-bold text-xl rounded-3xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-500 inline-flex items-center">
                            <span class="group-hover:translate-x-2 transition-all mr-3">لوحة التحكم</span>
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-12 py-6 bg-white/20 glass backdrop-blur-xl text-white font-bold text-xl rounded-3xl hover:bg-white/30 shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-500">
                            تسجيل الدخول
                        </a>
                        <a href="{{ route('register') }}" class="px-12 py-6 bg-white text-blue-600 font-bold text-xl rounded-3xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-500">
                            إنشاء حساب
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12 text-center md:text-right">
                <div>
                    <div class="flex items-center justify-center md:justify-start mb-6">
                        <i class="fas fa-heartbeat text-3xl text-red-400 mr-4"></i>
                        <h3 class="text-2xl font-bold">نظام المستشفى</h3>
                    </div>
                    <p class="text-gray-400">النظام الأول لإدارة المستشفيات في المنطقة العربية</p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6">الخدمات</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-all">حجز مواعيد</a></li>
                        <li><a href="#" class="hover:text-white transition-all">استشارات طبية</a></li>
                        <li><a href="#" class="hover:text-white transition-all">سجلات صحية</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6">الدعم</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-all">المساعدة</a></li>
                        <li><a href="#" class="hover:text-white transition-all">اتصل بنا</a></li>
                        <li><a href="#" class="hover:text-white transition-all">الأمان</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6">تابعنا</h4>
                    <div class="flex justify-center md:justify-start space-x-4 rtl:space-x-reverse">
                        <a href="#" class="w-12 h-12 bg-gray-800 hover:bg-blue-600 rounded-xl flex items-center justify-center text-xl transition-all hover:scale-110"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="w-12 h-12 bg-gray-800 hover:bg-blue-400 rounded-xl flex items-center justify-center text-xl transition-all hover:scale-110"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-12 h-12 bg-gray-800 hover:bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-xl transition-all hover:scale-110"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2024 نظام المستشفى. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling & animations
        document.querySelectorAll('a[href^=\"#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Parallax effect
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-gradient');
            if (parallax) {
                parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
    </script>

