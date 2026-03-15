<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { sawit: { 900:'#1a4d2e', 700:'#4f772d', 600:'#90a955', 500:'#ecf39e' } } } } }
    </script>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-sawit-600/30">404</h1>
        <h2 class="text-2xl font-bold text-gray-900 mt-4">Halaman Tidak Ditemukan</h2>
        <p class="text-gray-500 mt-2 mb-8">Maaf, halaman yang Anda cari tidak tersedia.</p>
        <div class="space-x-4">
            <a href="/" class="bg-sawit-600 hover:bg-sawit-700 text-white font-semibold py-3 px-6 rounded-xl transition shadow-lg">Ke Beranda</a>
            <a href="/dashboard/" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-xl transition">Dashboard</a>
        </div>
    </div>
</body>
</html>
