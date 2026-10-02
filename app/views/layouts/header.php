<header class="bg-white border-b border-gray-200 sticky top-0 z-20">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center space-x-4">
            <button @click="sidebarOpen=true" class="lg:hidden text-gray-500 hover:text-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div>
                <h2 class="text-lg font-bold text-gray-900"><?= $pageTitle ?? 'Dashboard' ?></h2>
                <?php if (isset($breadcrumb)): ?>
                <nav class="text-sm text-gray-500 mt-0.5">
                    <a href="/dashboard/" class="hover:text-sawit-700 transition">Dashboard</a>
                    <?php foreach ($breadcrumb as $label => $url): ?>
                        <span class="mx-1">/</span>
                        <?php if ($url): ?><a href="<?= $url ?>" class="hover:text-sawit-700 transition"><?= $label ?></a>
                        <?php else: ?><span class="text-gray-700"><?= $label ?></span><?php endif; ?>
                    <?php endforeach; ?>
                </nav>
                <?php endif; ?>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <div class="hidden sm:flex items-center space-x-2 bg-gray-50 rounded-xl px-3 py-2">
                <div class="w-8 h-8 bg-sawit-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm"><?= strtoupper(substr($_SESSION['nama'] ?? 'U', 0, 1)) ?></span>
                </div>
                <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?></span>
            </div>
            <a href="/dashboard/logout.php" class="text-gray-400 hover:text-red-500 transition" title="Logout">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </a>
        </div>
    </div>
</header>
