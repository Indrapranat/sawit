<?php
$currentPage = basename(dirname($_SERVER['SCRIPT_NAME']));
?>
<aside class="fixed inset-y-0 left-0 z-40 bg-gradient-to-b from-sawit-900 to-sawit-950 text-white shadow-2xl transition-all duration-300 transform"
       :class="[sidebarOpen?'translate-x-0':'-translate-x-full lg:translate-x-0', collapsed?'w-20':'w-64']">
    <div class="flex items-center justify-between p-4 border-b border-white/10" :class="collapsed?'justify-center':''">
        <a href="/dashboard/" class="flex items-center space-x-2" :class="collapsed?'justify-center':''">
            <div class="w-10 h-10 bg-sawit-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
            <span x-show="!collapsed" class="text-lg font-bold">Sawit<span class="text-sawit-500">Pro</span></span>
        </a>
        <button @click="collapsed=!collapsed" class="hidden lg:block text-white/50 hover:text-white transition" x-show="!collapsed">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
        </button>
        <button @click="collapsed=false" class="hidden lg:block text-white/50 hover:text-white transition" x-show="collapsed" x-cloak>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
        </button>
        <button @click="sidebarOpen=false" class="lg:hidden text-white/50 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <nav class="p-3 space-y-1 mt-2">
        <a href="/dashboard/" class="sidebar-link <?= $currentPage === 'dashboard' ? 'active' : 'text-white/70' ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span x-show="!collapsed">Dashboard</span>
        </a>
        <a href="/blok/" class="sidebar-link <?= $currentPage === 'blok' ? 'active' : 'text-white/70' ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span x-show="!collapsed">Blok Lahan</span>
        </a>
        <a href="/karyawan/" class="sidebar-link <?= $currentPage === 'karyawan' ? 'active' : 'text-white/70' ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span x-show="!collapsed">Karyawan</span>
        </a>
        <a href="/panen/" class="sidebar-link <?= $currentPage === 'panen' ? 'active' : 'text-white/70' ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
            <span x-show="!collapsed">Panen</span>
        </a>
        <a href="/laporan/" class="sidebar-link <?= $currentPage === 'laporan' ? 'active' : 'text-white/70' ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span x-show="!collapsed">Laporan</span>
        </a>
    </nav>

    <div class="absolute bottom-0 left-0 right-0 p-3 border-t border-white/10">
        <a href="/dashboard/logout.php" class="sidebar-link text-red-300 hover:text-red-200 hover:bg-red-900/30">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            <span x-show="!collapsed">Logout</span>
        </a>
    </div>
</aside>
