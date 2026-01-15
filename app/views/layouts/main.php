<?php
// Ensure this is not accessed directly without context if possible, 
// though for a layout it's often included.
if (!defined('BASE_URL')) {
    // Fallback if BASE_URL not defined, assuming root installation.
    // In production we should define this efficiently.
    define('BASE_URL', '/sawit/public');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Manajemen Perkebunan Sawit' ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom scrollbar for sidebar */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        /* Transition utility */
        .fade-enter {
            opacity: 0;
            transform: translateY(10px);
        }
        .fade-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 300ms, transform 300ms;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden ml-0 md:ml-64 w-full transition-all duration-300" id="main-content">
            
            <!-- Top Header -->
            <?php include __DIR__ . '/header.php'; ?>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                
                <!-- Content Container -->
                <div class="container mx-auto max-w-7xl animate-fade-in-up">
                    
                    <?php if (isset($content)): ?>
                        <?= $content ?>
                    <?php else: ?>
                        <!-- Fallback content or flash messages can go here -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Content not loaded.
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </main>
            
            <!-- Footer (Simple) -->
            <footer class="bg-white border-t border-gray-200 py-4 px-6 text-center text-sm text-gray-500">
                &copy; <?= date('Y') ?> SawitPro - Sistem Manajemen Perkebunan Kelapa Sawit.
            </footer>
        </div>
        
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 z-20 hidden md:hidden"></div>

    <script>
        // Sidebar Toggle Logic
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            
            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            }

            if(sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }
            
            if(sidebarOverlay) {
                sidebarOverlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>

</body>
</html>
