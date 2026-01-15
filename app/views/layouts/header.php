<header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 sticky top-0 z-20">
    <div class="flex items-center">
        <button id="sidebar-toggle" class="text-gray-500 focus:outline-none md:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <h2 class="text-xl font-semibold text-gray-800 ml-4 md:ml-0">
            <?= $pageTitle ?? 'Dashboard' ?>
        </h2>
    </div>

    <div class="flex items-center space-x-4">
        <div class="flex items-center">
            <div class="text-right mr-3 hidden sm:block">
                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin User') ?></div>
                <div class="text-xs text-gray-500 capitalize"><?= htmlspecialchars($_SESSION['user_role'] ?? 'Administrator') ?></div>
            </div>
            <div class="h-10 w-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 font-bold border border-emerald-200">
                <?= htmlspecialchars(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?>
            </div>
        </div>
        
        <div class="border-l pl-4 border-gray-200">
            <a href="<?= BASE_URL ?>/auth/logout.php" class="text-gray-500 hover:text-red-600 transition-colors p-2 rounded-full hover:bg-red-50" title="Sign Out">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </a>
        </div>
    </div>
</header>
