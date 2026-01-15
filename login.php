<?php
session_start();
require_once 'config/database.php';

// If already logged in, redirect
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard/");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Perkebunan Sawit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sawit: {
                            900: '#1a4d2e',
                            800: '#31572c',
                            700: '#4f772d',
                            600: '#90a955',
                            500: '#ecf39e',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center">

    <div class="w-full max-w-md p-6">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-sawit-900 p-8 text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 bg-[url('https://images.unsplash.com/photo-1598506180597-2a07c6451000?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')] bg-cover bg-center"></div>
                
                <div class="relative z-10 flex flex-col items-center">
                    <span class="bg-white p-3 rounded-full mb-3 shadow-lg">
                        <svg class="w-8 h-8 text-sawit-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </span>
                    <h2 class="text-2xl font-bold text-white">Selamat Datang</h2>
                    <p class="text-sawit-500 text-sm mt-1">Silakan masuk untuk melanjutkan</p>
                </div>
            </div>

            <!-- Form -->
            <div class="p-8 pt-6">
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-sm flex items-start" role="alert">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        <p><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 text-sm flex items-start" role="alert">
                         <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        <p><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
                    </div>
                <?php endif; ?>

                <form action="process_login.php" method="POST" class="space-y-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="text" name="username" id="username" required 
                                class="focus:ring-sawit-600 focus:border-sawit-600 block w-full pl-10 sm:text-sm border-gray-300 rounded-lg py-3 border focus:outline-none transition" 
                                placeholder="Masukkan username Anda">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input type="password" name="password" id="password" required 
                                class="focus:ring-sawit-600 focus:border-sawit-600 block w-full pl-10 sm:text-sm border-gray-300 rounded-lg py-3 border focus:outline-none transition" 
                                placeholder="Masukkan kata sandi">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-sawit-600 focus:ring-sawit-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                                Ingat saya
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-sawit-700 hover:text-sawit-900 hover:underline">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sawit-800 hover:bg-sawit-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sawit-600 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200">
                            Masuk Sekarang
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-500">
                    &copy; 2024 Manajemen Sawit App. <br>Kembali ke <a href="index.php" class="text-sawit-700 hover:underline font-bold">Beranda</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
