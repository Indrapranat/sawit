<aside class="fixed inset-y-0 left-0 w-64 bg-emerald-900 text-white transition-transform duration-300 transform -translate-x-full md:translate-x-0 z-30" id="sidebar">
    <div class="flex items-center justify-center h-16 border-b border-emerald-800 bg-emerald-950">
        <h1 class="text-xl font-bold tracking-wider uppercase">Sawit<span class="text-emerald-400">Pro</span></h1>
    </div>

    <nav class="mt-5 px-4 space-y-2">
        <a href="<?= BASE_URL ?>/dashboard" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-emerald-800 transition-colors group <?= (strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false) ? 'bg-emerald-800' : '' ?>">
            <svg class="w-5 h-5 mr-3 text-emerald-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
            Dashboard
        </a>

        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-semibold text-emerald-400 uppercase tracking-wider">
                Master Data
            </p>
        </div>

        <a href="<?= BASE_URL ?>/blok" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-emerald-800 transition-colors group <?= (strpos($_SERVER['REQUEST_URI'], '/blok') !== false) ? 'bg-emerald-800' : '' ?>">
            <svg class="w-5 h-5 mr-3 text-emerald-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Data Blok Lahan
        </a>

        <a href="<?= BASE_URL ?>/karyawan" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-emerald-800 transition-colors group <?= (strpos($_SERVER['REQUEST_URI'], '/karyawan') !== false) ? 'bg-emerald-800' : '' ?>">
            <svg class="w-5 h-5 mr-3 text-emerald-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            Data Karyawan
        </a>

        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-semibold text-emerald-400 uppercase tracking-wider">
                Operasional
            </p>
        </div>

        <a href="<?= BASE_URL ?>/panen" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-emerald-800 transition-colors group <?= (strpos($_SERVER['REQUEST_URI'], '/panen') !== false) ? 'bg-emerald-800' : '' ?>">
            <svg class="w-5 h-5 mr-3 text-emerald-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Input Hasil Panen
        </a>

        <a href="<?= BASE_URL ?>/laporan" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-emerald-800 transition-colors group <?= (strpos($_SERVER['REQUEST_URI'], '/laporan') !== false) ? 'bg-emerald-800' : '' ?>">
            <svg class="w-5 h-5 mr-3 text-emerald-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Laporan
        </a>
    </nav>
    <div class="px-4 py-3 border-t border-emerald-800 absolute bottom-0 w-full bg-emerald-950">
        <a href="<?= BASE_URL ?>/dashboard/logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')" class="flex items-center px-4 py-2 text-sm font-medium text-red-400 hover:text-red-300 hover:bg-emerald-900 rounded-lg transition-colors">
             <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
             </svg>
             Keluar Aplikasi
        </a>
    </div>
</aside>
