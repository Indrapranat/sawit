<?php
session_start();
require_once 'config/database.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard/');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama'] = $user['nama'];
                header('Location: dashboard/');
                exit;
            } else {
                $error = 'Username atau password salah!';
            }
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan sistem.';
        }
    } else {
        $error = 'Harap isi semua field!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SawitPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        .bg-grid{background-image:radial-gradient(circle,rgba(255,255,255,.1) 1px,transparent 1px);background-size:30px 30px}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-15px)}}
        .animate-float{animation:float 6s ease-in-out infinite}
        .animate-float-d{animation:float 6s ease-in-out 2s infinite}
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-sawit-950 via-sawit-900 to-sawit-800 flex items-center justify-center p-4 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-30"></div>
    <div class="absolute top-10 right-10 w-72 h-72 bg-sawit-600/20 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-10 left-10 w-96 h-96 bg-sawit-700/15 rounded-full blur-3xl animate-float-d"></div>

    <div class="w-full max-w-md relative z-10" x-data="{showPw:false,loading:false}">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-sawit-600 rounded-2xl shadow-2xl mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Sawit<span class="text-sawit-500">Pro</span></h1>
            <p class="text-white/60 text-sm mt-1">Masuk ke akun Anda</p>
        </div>

        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 shadow-2xl border border-white/20">
            <?php if ($error): ?>
            <div class="bg-red-500/20 border border-red-500/30 text-red-200 px-4 py-3 rounded-xl mb-6 flex items-center text-sm">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>

            <form method="POST" @submit="loading=true">
                <div class="mb-5">
                    <label class="block text-white/80 text-sm font-medium mb-2">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center"><svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></span>
                        <input type="text" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                            class="w-full bg-white/10 border border-white/20 rounded-xl py-3 pl-10 pr-4 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-sawit-600 focus:border-transparent transition" placeholder="Masukkan username">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-white/80 text-sm font-medium mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center"><svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></span>
                        <input :type="showPw?'text':'password'" name="password" required
                            class="w-full bg-white/10 border border-white/20 rounded-xl py-3 pl-10 pr-12 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-sawit-600 focus:border-transparent transition" placeholder="Masukkan password">
                        <button type="button" @click="showPw=!showPw" class="absolute inset-y-0 right-0 pr-3 flex items-center text-white/40 hover:text-white/70 transition">
                            <svg x-show="!showPw" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPw" style="display:none" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>
                <button type="submit" :disabled="loading"
                    class="w-full bg-sawit-600 hover:bg-sawit-700 text-white font-semibold py-3 rounded-xl transition-all shadow-lg hover:shadow-xl disabled:opacity-50 flex items-center justify-center">
                    <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <span x-text="loading?'Memproses...':'Masuk'">Masuk</span>
                </button>
            </form>
        </div>

        <p class="text-center text-white/40 text-sm mt-6"><a href="index.php" class="text-sawit-500 hover:text-sawit-600 transition">&larr; Kembali ke Beranda</a></p>
    </div>
</body>
</html>
