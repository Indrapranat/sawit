<?php if (!isset($_SESSION['user_id'])) { header('Location: /login.php'); exit; } ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'SawitPro' ?> - SawitPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sawit: { 950:'#0f2d1a', 900:'#1a4d2e', 800:'#31572c', 700:'#4f772d', 600:'#90a955', 500:'#ecf39e' }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak]{display:none!important}
        .sidebar-link{display:flex;align-items:center;gap:0.75rem;padding:0.75rem 1rem;border-radius:0.75rem;font-size:0.875rem;font-weight:500;transition:all 0.2s}
        .sidebar-link:hover{background:rgba(49,87,44,0.5);color:#fff}
        .sidebar-link.active{background:#4f772d;color:#fff;box-shadow:0 10px 15px -3px rgba(0,0,0,.1)}
    </style>
</head>
<body class="bg-gray-50 antialiased" x-data="{sidebarOpen:false,collapsed:false}">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>

        <!-- Main -->
        <div class="flex-1 flex flex-col transition-all duration-300" :class="collapsed?'lg:ml-20':'lg:ml-64'">
            <!-- Header -->
            <?php include __DIR__ . '/header.php'; ?>

            <!-- Content -->
            <main class="flex-1 p-6">
                <!-- Flash Messages -->
                <?php if (isset($_SESSION['flash_success'])): ?>
                <div x-data="{show:true}" x-show="show" x-transition x-init="setTimeout(()=>show=false,4000)"
                     class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center justify-between">
                    <div class="flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><?= $_SESSION['flash_success'] ?></div>
                    <button @click="show=false" class="text-green-500 hover:text-green-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <?php unset($_SESSION['flash_success']); endif; ?>

                <?php if (isset($_SESSION['flash_error'])): ?>
                <div x-data="{show:true}" x-show="show" x-transition x-init="setTimeout(()=>show=false,4000)"
                     class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center justify-between">
                    <div class="flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><?= $_SESSION['flash_error'] ?></div>
                    <button @click="show=false" class="text-red-500 hover:text-red-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <?php unset($_SESSION['flash_error']); endif; ?>

                <?= $content ?? '' ?>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-6 py-4">
                <p class="text-center text-gray-500 text-sm">&copy; <?= date('Y') ?> SawitPro. All rights reserved.</p>
            </footer>
        </div>
    </div>

    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen=false" class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-transition.opacity></div>
</body>
</html>
