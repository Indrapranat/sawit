<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SawitPro - Manajemen Perkebunan Sawit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sawit: { 950:'#0f2d1a', 900:'#1a4d2e', 800:'#31572c', 700:'#4f772d', 600:'#90a955', 500:'#ecf39e' }
                    },
                    animation: { 'float':'float 6s ease-in-out infinite', 'float-delay':'float 6s ease-in-out 2s infinite' },
                    keyframes: { float: { '0%,100%':{ transform:'translateY(0px)' }, '50%':{ transform:'translateY(-20px)' } } }
                }
            }
        }
    </script>
    <style>
        [x-cloak]{display:none!important}
        .bg-grid{background-image:radial-gradient(circle,rgba(255,255,255,.1) 1px,transparent 1px);background-size:30px 30px}
        .grad-text{background:linear-gradient(135deg,#ecf39e,#90a955);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased" x-data="{mob:false,scrolled:false}" @scroll.window="scrolled=(window.scrollY>50)">
    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300" :class="scrolled?'bg-sawit-900/95 backdrop-blur-md shadow-lg py-2':'bg-transparent py-4'">
        <div class="container mx-auto px-6 flex items-center justify-between">
            <a href="#" class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-sawit-600 rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <span class="text-xl font-bold text-white">Sawit<span class="text-sawit-500">Pro</span></span>
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="#beranda" class="text-white/80 hover:text-white text-sm font-medium transition">Beranda</a>
                <a href="#tentang" class="text-white/80 hover:text-white text-sm font-medium transition">Tentang</a>
                <a href="#fitur" class="text-white/80 hover:text-white text-sm font-medium transition">Fitur</a>
                <a href="#statistik" class="text-white/80 hover:text-white text-sm font-medium transition">Statistik</a>
                <a href="login.php" class="bg-sawit-600 hover:bg-sawit-700 text-white font-semibold py-2.5 px-6 rounded-full transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm">Masuk</a>
            </div>
            <button @click="mob=!mob" class="md:hidden text-white p-2">
                <svg x-show="!mob" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mob" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div x-show="mob" x-cloak x-transition class="md:hidden bg-sawit-900/95 backdrop-blur-md border-t border-white/10">
            <div class="container mx-auto px-6 py-4 space-y-3">
                <a href="#beranda" @click="mob=false" class="block text-white/80 hover:text-white py-2 text-sm">Beranda</a>
                <a href="#tentang" @click="mob=false" class="block text-white/80 hover:text-white py-2 text-sm">Tentang</a>
                <a href="#fitur" @click="mob=false" class="block text-white/80 hover:text-white py-2 text-sm">Fitur</a>
                <a href="login.php" class="block bg-sawit-600 text-white text-center py-2.5 rounded-full font-semibold text-sm mt-2">Masuk</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section id="beranda" class="relative bg-gradient-to-br from-sawit-950 via-sawit-900 to-sawit-800 text-white min-h-screen flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-grid opacity-30"></div>
        <div class="absolute top-20 right-10 w-72 h-72 bg-sawit-600/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-sawit-700/15 rounded-full blur-3xl animate-float-delay"></div>
        <div class="container mx-auto px-6 relative z-10 py-32">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center bg-sawit-800/60 backdrop-blur-sm rounded-full px-4 py-2 mb-6 border border-sawit-600/30">
                        <span class="w-2 h-2 bg-sawit-500 rounded-full mr-2 animate-pulse"></span>
                        <span class="text-sawit-500 text-sm font-medium">Sistem Manajemen Perkebunan #1</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">Kelola Perkebunan<br><span class="grad-text">Sawit Anda</span><br>Lebih Efisien</h1>
                    <p class="text-lg text-gray-300 mb-8 max-w-lg leading-relaxed">Platform terintegrasi untuk pencatatan blok lahan, pemantauan produksi harian, manajemen karyawan, dan laporan berbasis data.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="login.php" class="bg-sawit-600 hover:bg-sawit-700 text-white font-semibold py-3.5 px-8 rounded-full transition-all shadow-lg hover:shadow-2xl hover:-translate-y-1 text-center inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>Mulai Sekarang</a>
                        <a href="#fitur" class="border-2 border-white/30 hover:border-white/60 text-white font-semibold py-3.5 px-8 rounded-full transition-all text-center hover:bg-white/10">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <div class="animate-float">
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-2xl">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex space-x-2"><div class="w-3 h-3 bg-red-400 rounded-full"></div><div class="w-3 h-3 bg-yellow-400 rounded-full"></div><div class="w-3 h-3 bg-green-400 rounded-full"></div></div>
                                <span class="text-xs text-white/50">Dashboard</span>
                            </div>
                            <div class="space-y-3">
                                <div class="bg-white/10 rounded-lg p-3 flex justify-between"><span class="text-sm text-white/70">Panen Hari Ini</span><span class="text-lg font-bold text-sawit-500">2.450 Kg</span></div>
                                <div class="bg-white/10 rounded-lg p-3 flex justify-between"><span class="text-sm text-white/70">Total Bulan Ini</span><span class="text-lg font-bold text-sawit-500">48.200 Kg</span></div>
                                <div class="bg-white/10 rounded-lg p-3 flex justify-between"><span class="text-sm text-white/70">Karyawan Aktif</span><span class="text-lg font-bold text-sawit-500">24</span></div>
                                <div class="flex items-end space-x-1 pt-2 h-20">
                                    <div class="flex-1 bg-sawit-600/60 rounded-t" style="height:40%"></div>
                                    <div class="flex-1 bg-sawit-600/60 rounded-t" style="height:65%"></div>
                                    <div class="flex-1 bg-sawit-600/60 rounded-t" style="height:50%"></div>
                                    <div class="flex-1 bg-sawit-600/60 rounded-t" style="height:80%"></div>
                                    <div class="flex-1 bg-sawit-500 rounded-t" style="height:90%"></div>
                                    <div class="flex-1 bg-sawit-600/40 rounded-t" style="height:45%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 120" fill="none"><path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H0Z" fill="#F9FAFB"/></svg></div>
    </section>

    <!-- About -->
    <section id="tentang" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6" x-data="{v:false}" x-intersect:enter="v=true">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div x-show="v" x-transition.duration.700ms>
                    <span class="inline-block bg-sawit-600/10 text-sawit-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4">Tentang Kami</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Platform Manajemen yang <span class="text-sawit-700">Terpercaya</span></h2>
                    <p class="text-gray-600 leading-relaxed mb-6">SawitPro dirancang untuk memudahkan pengelolaan kebun kelapa sawit di Indonesia. Pencatatan blok, monitoring panen, manajemen karyawan, hingga laporan komprehensif.</p>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3"><div class="w-6 h-6 bg-sawit-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"><svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div><p class="text-gray-600">Pencatatan produksi akurat dan real-time</p></div>
                        <div class="flex items-start space-x-3"><div class="w-6 h-6 bg-sawit-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"><svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div><p class="text-gray-600">Dashboard visual untuk analisis performa</p></div>
                        <div class="flex items-start space-x-3"><div class="w-6 h-6 bg-sawit-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"><svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div><p class="text-gray-600">Export laporan ke Excel</p></div>
                    </div>
                </div>
                <div x-show="v" x-transition.duration.700ms>
                    <div class="bg-gradient-to-br from-sawit-700 to-sawit-900 rounded-2xl p-8 text-white relative overflow-hidden">
                        <div class="absolute inset-0 bg-grid opacity-20"></div>
                        <div class="relative z-10 text-center mb-6">
                            <svg class="w-16 h-16 mx-auto text-sawit-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <h3 class="text-xl font-bold mt-4">Digunakan di Seluruh Indonesia</h3>
                        </div>
                        <div class="relative z-10 grid grid-cols-2 gap-4">
                            <div class="bg-white/10 rounded-lg p-4 text-center"><p class="text-2xl font-bold text-sawit-500">100+</p><p class="text-xs text-white/70 mt-1">Kebun</p></div>
                            <div class="bg-white/10 rounded-lg p-4 text-center"><p class="text-2xl font-bold text-sawit-500">500+</p><p class="text-xs text-white/70 mt-1">Pengguna</p></div>
                            <div class="bg-white/10 rounded-lg p-4 text-center"><p class="text-2xl font-bold text-sawit-500">10K+</p><p class="text-xs text-white/70 mt-1">Transaksi</p></div>
                            <div class="bg-white/10 rounded-lg p-4 text-center"><p class="text-2xl font-bold text-sawit-500">99.9%</p><p class="text-xs text-white/70 mt-1">Uptime</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="fitur" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" x-data="{v:false}" x-intersect:enter="v=true" x-show="v" x-transition.duration.500ms>
                <span class="inline-block bg-sawit-600/10 text-sawit-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4">Fitur Unggulan</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Semua yang Anda Butuhkan</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Fitur lengkap untuk mengelola perkebunan kelapa sawit dengan mudah dan efisien.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8" x-data="{v:false}" x-intersect:enter="v=true">
                <div x-show="v" x-transition.delay.100ms class="group bg-white p-8 rounded-2xl border border-gray-100 hover:border-sawit-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-sawit-600 to-sawit-800 rounded-xl flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform"><svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                    <h3 class="font-bold text-gray-900 text-lg mb-3">Manajemen Blok</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Kelola data kebun dan blok lahan secara terpusat dengan detail lengkap.</p>
                </div>
                <div x-show="v" x-transition.delay.200ms class="group bg-white p-8 rounded-2xl border border-gray-100 hover:border-sawit-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform"><svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg></div>
                    <h3 class="font-bold text-gray-900 text-lg mb-3">Pencatatan Panen</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Input hasil panen harian per blok dan karyawan dengan akurat.</p>
                </div>
                <div x-show="v" x-transition.delay.300ms class="group bg-white p-8 rounded-2xl border border-gray-100 hover:border-sawit-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform"><svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
                    <h3 class="font-bold text-gray-900 text-lg mb-3">Dashboard Produksi</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Pantau performa dengan dashboard visual dan grafik interaktif.</p>
                </div>
                <div x-show="v" x-transition.delay.400ms class="group bg-white p-8 rounded-2xl border border-gray-100 hover:border-sawit-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform"><svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                    <h3 class="font-bold text-gray-900 text-lg mb-3">Laporan & Ekspor</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Buat laporan komprehensif dan ekspor ke CSV/Excel.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section id="statistik" class="py-20 bg-gradient-to-br from-sawit-900 via-sawit-800 to-sawit-700 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-grid opacity-20"></div>
        <div class="container mx-auto px-6 relative z-10" x-data="{v:false}" x-intersect:enter="v=true">
            <div class="text-center mb-14" x-show="v" x-transition.duration.500ms>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Dipercaya Banyak Perkebunan</h2>
                <p class="text-white/70 max-w-xl mx-auto">Bergabunglah dengan ratusan perkebunan yang menggunakan SawitPro</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center" x-show="v" x-transition.delay.100ms x-data="{c:0}" x-intersect:enter.once="let i=setInterval(()=>{if(c<150)c+=3;else{c=150;clearInterval(i)}},20)">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/10"><svg class="w-8 h-8 text-sawit-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></div>
                    <p class="text-4xl font-bold text-sawit-500" x-text="c+'+'">0+</p><p class="text-white/70 text-sm mt-2">Kebun Terdaftar</p>
                </div>
                <div class="text-center" x-show="v" x-transition.delay.200ms x-data="{c:0}" x-intersect:enter.once="let i=setInterval(()=>{if(c<500)c+=10;else{c=500;clearInterval(i)}},20)">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/10"><svg class="w-8 h-8 text-sawit-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                    <p class="text-4xl font-bold text-sawit-500" x-text="c+'+'">0+</p><p class="text-white/70 text-sm mt-2">Pengguna Aktif</p>
                </div>
                <div class="text-center" x-show="v" x-transition.delay.300ms x-data="{c:0}" x-intersect:enter.once="let i=setInterval(()=>{if(c<50)c++;else{c=50;clearInterval(i)}},30)">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/10"><svg class="w-8 h-8 text-sawit-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                    <p class="text-4xl font-bold text-sawit-500" x-text="c+'K+'">0K+</p><p class="text-white/70 text-sm mt-2">Data Panen</p>
                </div>
                <div class="text-center" x-show="v" x-transition.delay.400ms x-data="{c:0}" x-intersect:enter.once="let i=setInterval(()=>{if(c<99)c+=2;else{c=99;clearInterval(i)}},25)">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/10"><svg class="w-8 h-8 text-sawit-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
                    <p class="text-4xl font-bold text-sawit-500" x-text="c+'.9%'">0%</p><p class="text-white/70 text-sm mt-2">Uptime</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="bg-gradient-to-r from-sawit-800 to-sawit-900 rounded-3xl p-12 md:p-16 text-center text-white relative overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-grid opacity-20"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap Mengelola Kebun Lebih Baik?</h2>
                    <p class="text-white/70 max-w-xl mx-auto mb-8">Mulai gunakan SawitPro dan rasakan kemudahan mengelola perkebunan Anda.</p>
                    <a href="login.php" class="inline-flex items-center bg-sawit-500 hover:bg-sawit-600 text-sawit-900 font-bold py-4 px-10 rounded-full transition-all shadow-lg hover:shadow-2xl hover:-translate-y-1 text-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>Mulai Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="kontak" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <span class="inline-block bg-sawit-600/10 text-sawit-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4">Hubungi Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Butuh Bantuan?</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="text-center p-6 rounded-2xl bg-gray-50 hover:bg-sawit-50 transition-colors group">
                    <div class="w-14 h-14 bg-sawit-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-sawit-200 transition"><svg class="w-7 h-7 text-sawit-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                    <h3 class="font-bold text-gray-900 mb-2">Alamat</h3><p class="text-gray-600 text-sm">Jl. Kebun Sawit No.123<br>Jakarta 12345</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-gray-50 hover:bg-sawit-50 transition-colors group">
                    <div class="w-14 h-14 bg-sawit-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-sawit-200 transition"><svg class="w-7 h-7 text-sawit-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                    <h3 class="font-bold text-gray-900 mb-2">Email</h3><p class="text-gray-600 text-sm">info@sawitpro.id</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-gray-50 hover:bg-sawit-50 transition-colors group">
                    <div class="w-14 h-14 bg-sawit-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-sawit-200 transition"><svg class="w-7 h-7 text-sawit-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                    <h3 class="font-bold text-gray-900 mb-2">Telepon</h3><p class="text-gray-600 text-sm">+62 21 555 1234</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-sawit-950 text-white pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4"><div class="w-10 h-10 bg-sawit-600 rounded-lg flex items-center justify-center"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg></div><span class="text-xl font-bold">Sawit<span class="text-sawit-500">Pro</span></span></div>
                    <p class="text-white/60 text-sm max-w-md leading-relaxed">Solusi manajemen perkebunan kelapa sawit terintegrasi.</p>
                </div>
                <div><h4 class="font-semibold mb-4 text-white/90">Menu</h4><ul class="space-y-2"><li><a href="#beranda" class="text-white/60 hover:text-sawit-500 text-sm transition">Beranda</a></li><li><a href="#tentang" class="text-white/60 hover:text-sawit-500 text-sm transition">Tentang</a></li><li><a href="#fitur" class="text-white/60 hover:text-sawit-500 text-sm transition">Fitur</a></li></ul></div>
                <div><h4 class="font-semibold mb-4 text-white/90">Aplikasi</h4><ul class="space-y-2"><li><a href="login.php" class="text-white/60 hover:text-sawit-500 text-sm transition">Login</a></li><li><a href="#kontak" class="text-white/60 hover:text-sawit-500 text-sm transition">Bantuan</a></li></ul></div>
            </div>
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-white/50 text-sm">&copy; <?= date('Y') ?> SawitPro. All rights reserved.</p>
                <div class="flex space-x-4"><a href="#" class="text-white/50 hover:text-sawit-500 transition text-sm">Kebijakan Privasi</a><a href="#" class="text-white/50 hover:text-sawit-500 transition text-sm">Syarat &amp; Ketentuan</a></div>
            </div>
        </div>
    </footer>
</body>
</html>
