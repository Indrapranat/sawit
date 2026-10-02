<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

$pageTitle = 'Dashboard';

// Get stats
try {
    $db = getConnection();
    $totalBlok = $db->query("SELECT COUNT(*) FROM blok_lahan")->fetchColumn();
    $totalKaryawan = $db->query("SELECT COUNT(*) FROM karyawan")->fetchColumn();
    $totalPanen = $db->query("SELECT COUNT(*) FROM hasil_panen")->fetchColumn();
    $totalBerat = $db->query("SELECT COALESCE(SUM(berat_kg), 0) FROM hasil_panen")->fetchColumn();

    // Monthly production for chart
    $monthlyData = $db->query("SELECT DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(berat_kg) as total FROM hasil_panen WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY bulan ORDER BY bulan")->fetchAll();

    // Recent harvests
    $recentPanen = $db->query("SELECT p.*, b.nama_blok as blok_nama, k.nama as karyawan_nama FROM hasil_panen p LEFT JOIN blok_lahan b ON p.blok_id = b.id LEFT JOIN karyawan k ON p.karyawan_id = k.id ORDER BY p.tanggal DESC LIMIT 5")->fetchAll();
} catch (PDOException $e) {
    $totalBlok = $totalKaryawan = $totalPanen = $totalBerat = 0;
    $monthlyData = [];
    $recentPanen = [];
}

// Time-based greeting
$hour = (int)date('H');
if ($hour < 11) $greeting = 'Selamat Pagi';
elseif ($hour < 15) $greeting = 'Selamat Siang';
elseif ($hour < 18) $greeting = 'Selamat Sore';
else $greeting = 'Selamat Malam';

ob_start();
?>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900"><?= $greeting ?>, <?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?>!</h1>
    <p class="text-gray-500 mt-1">Berikut ringkasan data perkebunan Anda hari ini.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-sawit-600 to-sawit-800 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900"><?= number_format($totalBlok) ?></p>
        <p class="text-sm text-gray-500 mt-1">Total Blok</p>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900"><?= number_format($totalKaryawan) ?></p>
        <p class="text-sm text-gray-500 mt-1">Total Karyawan</p>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900"><?= number_format($totalPanen) ?></p>
        <p class="text-sm text-gray-500 mt-1">Total Panen</p>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900"><?= number_format($totalBerat) ?> <span class="text-lg text-gray-400">Kg</span></p>
        <p class="text-sm text-gray-500 mt-1">Total Berat Panen</p>
    </div>
</div>

<!-- Chart + Recent -->
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Produksi 6 Bulan Terakhir</h3>
        <canvas id="productionChart" height="120"></canvas>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Panen Terbaru</h3>
        <div class="space-y-3">
            <?php if (empty($recentPanen)): ?>
            <p class="text-gray-400 text-sm text-center py-4">Belum ada data panen</p>
            <?php else: ?>
            <?php foreach ($recentPanen as $p): ?>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-sawit-50 transition">
                <div>
                    <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($p['karyawan_nama'] ?? '-') ?></p>
                    <p class="text-xs text-gray-500"><?= htmlspecialchars($p['blok_nama'] ?? '-') ?> &middot; <?= date('d/m/Y', strtotime($p['tanggal'])) ?></p>
                </div>
                <span class="text-sm font-bold text-sawit-700"><?= number_format($p['berat_kg']) ?> Kg</span>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('productionChart');
if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($monthlyData, 'bulan')) ?>,
            datasets: [{
                label: 'Produksi (Kg)',
                data: <?= json_encode(array_map(fn($r) => (float)$r['total'], $monthlyData)) ?>,
                backgroundColor: 'rgba(79, 119, 45, 0.8)',
                borderColor: '#4f772d',
                borderWidth: 1,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../app/views/layouts/main.php';
?>
