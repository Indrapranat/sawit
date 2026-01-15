<?php
session_start();
require_once 'config/database.php';
// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Sawit - Beranda</title>
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
<body class="bg-gray-50 text-gray-800">
    <!-- Hero Section -->
    <section class="bg-sawit-900 text-white py-20" x-data="{showLogin:false}">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-5xl font-bold mb-4">Manajemen Perkebunan Sawit</h1>
            <p class="text-lg mb-8">Solusi lengkap untuk mengelola kebun, blok, panen, dan laporan produksi.</p>
            <a href="login.php" class="bg-sawit-700 hover:bg-sawit-800 text-white font-semibold py-3 px-6 rounded-full transition">Masuk Aplikasi</a>
        </div>
    </section>

    <!-- About Us -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-semibold text-center text-sawit-900 mb-6">Tentang Kami</h2>
            <p class="max-w-3xl mx-auto text-center text-gray-600">
                Kami menyediakan platform terintegrasi untuk memudahkan pengelolaan kebun kelapa sawit, mulai dari pencatatan blok, pemantauan produksi, hingga laporan berbasis data.
            </p>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 bg-sawit-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-semibold text-center text-sawit-900 mb-10">Fitur Aplikasi</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-sawit-800 mb-2">Manajemen Kebun & Blok</h3>
                    <p class="text-gray-600 text-sm">Kelola data kebun, blok, dan detail lahan secara terpusat.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-sawit-800 mb-2">Pencatatan Panen</h3>
                    <p class="text-gray-600 text-sm">Input hasil panen harian, bulanan, dan tahunan dengan mudah.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-sawit-800 mb-2">Monitoring Produksi</h3>
                    <p class="text-gray-600 text-sm">Dashboard visual untuk memantau performa produksi secara real‑time.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-sawit-800 mb-2">Laporan Berbasis Data</h3>
                    <p class="text-gray-600 text-sm">Ekspor laporan dalam format PDF/Excel untuk analisis lebih lanjut.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-semibold text-center text-sawit-900 mb-8">Galeri</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                <img src="assets/images/placeholder1.jpg" alt="Gallery Image 1" class="w-full h-48 object-cover rounded">
                <img src="assets/images/placeholder2.jpg" alt="Gallery Image 2" class="w-full h-48 object-cover rounded">
                <img src="assets/images/placeholder3.jpg" alt="Gallery Image 3" class="w-full h-48 object-cover rounded">
                <img src="assets/images/placeholder4.jpg" alt="Gallery Image 4" class="w-full h-48 object-cover rounded">
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section class="py-16 bg-sawit-900 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-semibold mb-4">Kontak Kami</h2>
            <p>Jl. Kebun Sawit No.123, Jakarta 12345</p>
            <p>Email: info@sawitapp.id | Tel: +62 21 555 1234</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-4">
        <div class="container mx-auto text-center">
            &copy; 2024 Manajemen Sawit App. All rights reserved.
        </div>
    </footer>
</body>
</html>
