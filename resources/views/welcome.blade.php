<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DigiLib SMKN 40 Jakarta">
    
    <title>Perpustakaan SMKN 40 Jakarta</title>

    <!-- Google Fonts: Instrument Serif (Aksen) & Inter (Global) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Typography Base */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* slate-50 */
            color: #1e293b; /* slate-800 */
        }
        
        .font-serif {
            font-family: 'Instrument Serif', serif;
        }

        /* Subtle Grid Background (Matches Login Page) */
        .bg-grid {
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.04) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        /* Glass Navbar */
        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }

        /* Animations */
        .char {
            display: inline-block;
            opacity: 0;
            transform: translateY(12px);
            transition: opacity 600ms cubic-bezier(0.4, 0, 0.2, 1), transform 600ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        .char.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Scroll Animations (Fade & Slide) */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1), transform 800ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .slide-in-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1), transform 800ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        .slide-in-left.visible {
            opacity: 1;
            transform: translateX(0);
        }
        
        .slide-in-right {
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1), transform 800ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        .slide-in-right.visible {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
</head>
<body class="antialiased selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden">

    <!-- NAVBAR -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 md:px-12 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center p-1.5">
                    <img src="{{ asset('favicon.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <span class="text-lg font-bold tracking-tight text-slate-800">Perpustakaan SMKN 40 Jakarta</span>
            </div>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="#tentang" class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition">Tentang</a>
                <a href="#layanan" class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition">Layanan</a>
            </div>
            
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 transition shadow-md hover:shadow-lg hover:-translate-y-0.5 inline-block duration-200">Buka Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 transition shadow-md hover:shadow-lg hover:-translate-y-0.5 inline-block duration-200">Masuk Portal</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SECTION (Light & Clean) -->
    <main class="relative w-full min-h-[90vh] flex flex-col justify-center bg-slate-50 pt-20 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-grid z-0 opacity-70"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-slate-50/80 to-slate-50 z-0"></div>
        
        <!-- Glowing Ambient -->
        <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] bg-indigo-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 w-full flex flex-col lg:flex-row items-center gap-16 mt-12">
            
            <!-- Kiri: Teks Utama -->
            <div class="flex-1 text-center lg:text-left">
                <div class="inline-block px-4 py-1.5 bg-white border border-slate-200 rounded-full text-slate-500 text-xs font-bold tracking-widest uppercase mb-6 shadow-sm fade-in">
                    SMKN 40 Jakarta
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 text-slate-900 leading-[1.1] tracking-tight" id="hero-heading">
                    <!-- Teks ini di-inject via JS agar beranimasi (Staggered) -->
                </h1>
                
                <p class="text-lg md:text-xl text-slate-600 mb-10 max-w-xl mx-auto lg:mx-0 fade-in delay-800 leading-relaxed">
                    Platform perpustakaan sekolah modern. Cari buku referensi, novel, dan jelajahi wawasan baru semudah sentuhan jari.
                </p>
                
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 fade-in delay-1000">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 hover:-translate-y-0.5 duration-200">Akses Dasbor</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 hover:-translate-y-0.5 duration-200">Mulai Eksplorasi</a>
                    @endauth
                    <a href="#layanan" class="bg-white text-slate-700 border border-slate-200 px-8 py-3.5 rounded-xl font-semibold hover:bg-slate-50 transition shadow-sm hover:-translate-y-0.5 duration-200">Pelajari Layanan</a>
                </div>
            </div>
            
            <!-- Kanan: Grafis/Visual (Tanpa Video Abstrak) -->
            <div class="flex-1 w-full max-w-lg lg:max-w-none relative fade-in delay-1200">
                <!-- Main Aesthetic Card -->
                <div class="relative aspect-[4/3] w-full rounded-3xl bg-white shadow-2xl border border-slate-100 overflow-hidden transform -rotate-2 hover:rotate-0 transition-transform duration-700 z-10 flex flex-col group">
                    <!-- Atas: Pola & Logo -->
                    <div class="flex-1 bg-slate-900 p-8 relative overflow-hidden flex flex-col justify-between">
                        <!-- Dot pattern overlay inside card -->
                        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 16px 16px;"></div>
                        
                        <div class="relative z-10 flex justify-between items-start">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center p-1.5 shadow-lg">
                                <img src="{{ asset('favicon.png') }}" alt="Logo" class="w-full h-full object-contain">
                            </div>
                            <span class="px-3 py-1 bg-white/10 text-white/90 text-xs font-semibold rounded-full border border-white/20 backdrop-blur-sm">Akses Mandiri</span>
                        </div>
                        
                        <div class="relative z-10 mt-8">
                            <p class="font-serif italic text-blue-300 text-3xl mb-1 group-hover:scale-105 transition-transform origin-left duration-500">Membangun</p>
                            <h3 class="text-4xl text-white font-extrabold tracking-tight">Generasi Literat.</h3>
                        </div>
                    </div>
                    
                    <!-- Bawah: Mini Stats -->
                    <div class="h-24 bg-white px-8 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Status Sistem</p>
                            <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Tersedia Real-time
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-slate-900 font-bold text-xl">100%</p>
                            <p class="text-xs text-slate-500 font-medium">Digital</p>
                        </div>
                    </div>
                </div>
                
                <!-- Background Decorative Blob -->
                <div class="absolute top-12 -right-6 bottom-4 -left-6 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl -z-10 transform rotate-3 opacity-90 blur-sm"></div>
            </div>
        </div>
    </main>

    <!-- CONTENT SECTION 1: TENTANG (Selang-Seling: Kiri Teks, Kanan Stats) -->
    <section id="tentang" class="py-32 bg-white px-6 md:px-12 overflow-hidden">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-20">
            <!-- Teks Kiri -->
            <div class="flex-1 slide-in-left">
                <p class="text-blue-600 font-bold tracking-widest text-sm uppercase mb-4">Tentang Perpustakaan</p>
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-[1.1] tracking-tight">
                    Jantung pengetahuan di <span class="font-serif italic text-blue-600 font-normal">lingkungan sekolah.</span>
                </h2>
                <p class="text-slate-600 text-lg leading-relaxed mb-6">
                    Perpustakaan Mini SMKN 40 bukan sekadar ruangan berisi rak buku. Ini adalah ruang penemuan dimana rasa ingin tahu diubah menjadi inovasi, dan setiap halaman membuka perspektif baru.
                </p>
                <p class="text-slate-600 text-lg leading-relaxed">
                    Sistem digital kami memadukan pengelolaan buku tradisional dengan teknologi modern. Pencarian buku fiksi maupun modul pelajaran kini menjadi lebih efisien dan terorganisir.
                </p>
            </div>
            
            <!-- Grid Statistik Kanan -->
            <div class="flex-1 slide-in-right relative w-full">
                <div class="grid grid-cols-2 gap-4 md:gap-6">
                    <div class="space-y-4 md:space-y-6 pt-12">
                        <div class="bg-slate-50 border border-slate-100 aspect-square rounded-3xl p-8 flex flex-col justify-end transition-shadow hover:shadow-lg hover:bg-white">
                            <span class="text-4xl md:text-5xl font-black text-slate-900 mb-2">{{ $jumlahBuku > 999 ? number_format($jumlahBuku / 1000, 1) . 'k' : $jumlahBuku }}</span>
                            <span class="text-sm md:text-base text-slate-500 font-semibold">Koleksi Buku</span>
                        </div>
                        <div class="bg-blue-600 aspect-[4/3] rounded-3xl p-8 flex flex-col justify-end text-white shadow-xl shadow-blue-600/20">
                            <span class="text-4xl md:text-5xl font-black mb-2">100%</span>
                            <span class="text-sm md:text-base text-white/90 font-medium">Sistem Terintegrasi</span>
                        </div>
                    </div>
                    <div class="space-y-4 md:space-y-6">
                        <div class="bg-slate-900 aspect-[4/3] rounded-3xl p-8 flex flex-col justify-end text-white shadow-2xl">
                            <span class="text-4xl md:text-5xl font-black mb-2">{{ $jumlahAnggota }}+</span>
                            <span class="text-sm md:text-base text-white/80 font-medium">Anggota Aktif</span>
                        </div>
                        <div class="bg-amber-50 border border-amber-100 aspect-square rounded-3xl p-8 flex flex-col justify-end transition-shadow hover:shadow-lg hover:bg-white">
                            <span class="text-4xl md:text-5xl font-black text-amber-600 mb-2">0</span>
                            <span class="text-sm md:text-base text-amber-700/70 font-semibold">Ribet Pinjam</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTENT SECTION 2: LAYANAN (Selang-Seling: Kiri Grid Kartu, Kanan Teks) -->
    <section id="layanan" class="py-32 bg-slate-50 px-6 md:px-12 overflow-hidden border-y border-slate-200/60">
        <div class="max-w-7xl mx-auto flex flex-col-reverse lg:flex-row items-center gap-20">
            <!-- Kiri Grid Layanan -->
            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-6 w-full slide-in-left">
                <!-- Card 1 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Katalog Cerdas</h3>
                    <p class="text-slate-600 leading-relaxed">Cari berdasarkan judul, penulis, atau kategori dengan hasil instan dan cek ketersediaan buku secara real-time sebelum datang ke perpus.</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 sm:translate-y-12 group">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Portal Mandiri</h3>
                    <p class="text-slate-600 leading-relaxed">Siswa memiliki akses ke portal pribadi untuk mengecek riwayat pinjaman, sisa waktu pengembalian, dan total denda denda langsung dari layar HP.</p>
                </div>
            </div>
            
            <!-- Kanan Teks -->
            <div class="flex-1 slide-in-right">
                <p class="text-blue-600 font-bold tracking-widest text-sm uppercase mb-4">Fokus Kami</p>
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-[1.1] tracking-tight">
                    Dirancang eksklusif untuk <span class="font-serif italic text-blue-600 font-normal">kemudahan</span> Anda.
                </h2>
                <p class="text-slate-600 text-lg leading-relaxed mb-8">
                    Ucapkan selamat tinggal pada pencatatan manual yang panjang. Sistem kami memadukan antarmuka yang modern dengan basis data yang tangguh, memastikan alur peminjaman buku berjalan lancar dan efisien.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                        <span class="text-slate-700 font-medium">Pencatatan real-time otomatis.</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                        <span class="text-slate-700 font-medium">Kalkulasi denda transparan.</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                        <span class="text-slate-700 font-medium">Multi-role: Akses Admin & Siswa.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- FOOTER SECTION (Lumina Inspired Tapi Disesuaikan ke Tema Perpustakaan) -->
    <footer class="bg-slate-900 px-6 pb-6 pt-24 text-slate-300">
        <div class="max-w-7xl mx-auto bg-slate-800/40 rounded-3xl p-8 md:p-14 border border-slate-700/50 fade-in relative overflow-hidden">
            <!-- Subtle glow in footer -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 md:grid-cols-12 gap-12 mb-16">
                <!-- Brand Info -->
                <div class="md:col-span-5">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center p-1.5 shadow-sm">
                            <img src="{{ asset('favicon.png') }}" alt="Logo" class="w-full h-full object-contain">
                        </div>
                        <span class="text-2xl font-bold text-white tracking-tight">Perpustakaan SMKN 40 Jakarta</span>
                    </div>
                    <p class="text-base leading-relaxed text-slate-400 max-w-sm mb-6">
                        Sistem Informasi Perpustakaan Digital SMKN 40 Jakarta. Mewujudkan ekosistem membaca yang modern, inklusif, dan tertata rapi.
                    </p>
                    <div class="flex gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-5 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-500 transition">Buka Dasbor</a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-500 transition">Masuk Akun</a>
                        @endauth
                    </div>
                </div>

                <!-- Links Grid -->
                <div class="md:col-span-7 grid grid-cols-2 md:grid-cols-3 gap-8">
                    <div>
                        <h4 class="text-xs uppercase tracking-widest text-slate-500 font-bold mb-6">Pintasan</h4>
                        <ul class="space-y-4 text-sm text-slate-300 font-medium">
                            <li><a href="#tentang" class="hover:text-white transition-colors">Tentang Perpus</a></li>
                            <li><a href="#layanan" class="hover:text-white transition-colors">Layanan Digital</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Daftar Koleksi</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-xs uppercase tracking-widest text-slate-500 font-bold mb-6">Informasi</h4>
                        <ul class="space-y-4 text-sm text-slate-300 font-medium">
                            <li><a href="#" class="hover:text-white transition-colors">Tata Tertib</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Jam Buka</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Kebijakan Denda</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-xs uppercase tracking-widest text-slate-500 font-bold mb-6">Bantuan</h4>
                        <ul class="space-y-4 text-sm text-slate-300 font-medium">
                            <li><a href="#" class="hover:text-white transition-colors">Cara Pinjam Buku</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Lupa Password</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Hubungi Pustakawan</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="relative z-10 pt-8 border-t border-slate-700/50 flex flex-col md:flex-row items-center justify-between gap-6">
                <p class="text-[11px] uppercase tracking-widest text-slate-500 font-bold">
                    &copy; {{ date('Y') }} Perpustakaan SMKN 40 Jakarta. All rights reserved.
                </p>
                <div class="flex items-center gap-5">
                    <span class="text-[11px] uppercase tracking-widest text-slate-500 font-bold mr-1">Terkoneksi:</span>
                    <!-- Simple SVG Icons -->
                    <a href="#" class="text-slate-500 hover:text-white transition-colors transform hover:-translate-y-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-white transition-colors transform hover:-translate-y-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts for Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Navbar Glass Transition on Scroll
            const nav = document.querySelector('nav');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    nav.classList.add('shadow-sm');
                    nav.style.background = 'rgba(255, 255, 255, 0.9)';
                    nav.style.backdropFilter = 'blur(16px)';
                } else {
                    nav.classList.remove('shadow-sm');
                    nav.style.background = 'rgba(255, 255, 255, 0.7)';
                    nav.style.backdropFilter = 'blur(16px)';
                }
            });

            // 1. Animasi Teks Ketikan (Staggered Hero Text)
            const heroText = "Eksplorasi Dunia\nTanpa Batas.";
            const headingEl = document.getElementById('hero-heading');
            
            const lines = heroText.split('\n');
            let charCount = 0;
            const charDelay = 40; // ms
            const initialDelay = 150; // ms

            lines.forEach((line) => {
                const lineDiv = document.createElement('div');
                lineDiv.className = "whitespace-nowrap";
                
                const chars = Array.from(line);
                chars.forEach((char) => {
                    const span = document.createElement('span');
                    span.className = 'char';
                    span.textContent = char === ' ' ? '\u00A0' : char; 
                    
                    const delay = initialDelay + (charCount * charDelay);
                    setTimeout(() => {
                        span.classList.add('visible');
                    }, delay);
                    
                    lineDiv.appendChild(span);
                    charCount++;
                });
                
                headingEl.appendChild(lineDiv);
            });

            // 2. Intersection Observer untuk Efek Fade/Slide saat Scroll
            const observeElements = document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        let extraDelay = 0;
                        entry.target.classList.forEach(cls => {
                            if (cls.startsWith('delay-')) {
                                extraDelay = parseInt(cls.split('-')[1]);
                            }
                        });
                        
                        if(extraDelay > 0) {
                            setTimeout(() => {
                                entry.target.classList.add('visible');
                            }, extraDelay);
                        } else {
                            entry.target.classList.add('visible');
                        }
                        
                        // Stop observing once animated
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15,
                rootMargin: "0px 0px -50px 0px"
            });

            observeElements.forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
