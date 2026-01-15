<?php
require_once '../config/database.php';

// --- HARVEST STATISTICS ---

// 1. Total Panen Hari Ini
$sqlToday = "SELECT COALESCE(SUM(berat_kg), 0) as total FROM hasil_panen WHERE tanggal = CURDATE()";
$panenHariIni = dbQueryOne($sqlToday)['total'];

// 2. Total Panen Bulan Ini
$sqlMonth = "SELECT COALESCE(SUM(berat_kg), 0) as total FROM hasil_panen WHERE DATE_FORMAT(tanggal, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')";
$panenBulanIni = dbQueryOne($sqlMonth)['total'];

// --- MASTER DATA STATISTICS ---

// 3. Total Karyawan
$sqlKaryawan = "SELECT COUNT(*) as total FROM karyawan";
$totalKaryawan = dbQueryOne($sqlKaryawan)['total'];

// 4. Total Blok Lahan
$sqlBlok = "SELECT COUNT(*) as total FROM blok_lahan";
$totalBlok = dbQueryOne($sqlBlok)['total'];

// 5. Top Employee (Bulan Ini)
$sqlTopEmp = "SELECT k.nama, SUM(h.berat_kg) as total_berat 
              FROM hasil_panen h 
              JOIN karyawan k ON h.karyawan_id = k.id 
              WHERE DATE_FORMAT(h.tanggal, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')
              GROUP BY k.id 
              ORDER BY total_berat DESC 
              LIMIT 1";
$topEmployee = dbQueryOne($sqlTopEmp);

// 6. 5 Transaksi Terakhir
$sqlRecent = "SELECT h.*, b.nama_blok, k.nama as nama_karyawan 
              FROM hasil_panen h 
              JOIN blok_lahan b ON h.blok_id = b.id 
              JOIN karyawan k ON h.karyawan_id = k.id 
              ORDER BY h.tanggal DESC, h.id DESC 
              LIMIT 5";
$recentTransactions = dbQuery($sqlRecent);

$pageTitle = "Dashboard Overview";
ob_start();
?>

<div class="space-y-6">
    
    <!-- Hero / Welcome Section -->
    <div class="bg-white rounded-lg p-6 border-l-4 border-emerald-600 shadow-sm flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>!</h2>
            <p class="text-gray-600 mt-1">Berikut adalah ringkasan aktivitas perkebunan hari ini.</p>
        </div>
        <div class="text-right hidden md:block">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Tanggal Hari Ini</p>
            <p class="text-xl font-bold text-gray-800"><?= date('d F Y') ?></p>
        </div>
    </div>

    <!-- Stats Grid Row 1: Key Harvest Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Hari Ini -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-center relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-2 bg-emerald-500"></div>
            <div class="p-3 rounded-full bg-emerald-100 text-emerald-600 mr-4">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Panen Hari Ini</p>
                <div class="flex items-baseline">
                    <p class="text-2xl font-bold text-gray-800"><?= number_format($panenHariIni, 2, ',', '.') ?></p>
                    <span class="ml-1 text-sm text-gray-500">Kg</span>
                </div>
            </div>
        </div>

        <!-- Bulan Ini -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-center relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-2 bg-blue-500"></div>
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Bulan Ini</p>
                <div class="flex items-baseline">
                    <p class="text-2xl font-bold text-gray-800"><?= number_format($panenBulanIni, 2, ',', '.') ?></p>
                    <span class="ml-1 text-sm text-gray-500">Kg</span>
                </div>
            </div>
        </div>

        <!-- Top Employee -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-center relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-2 bg-orange-500"></div>
            <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Top Karyawan (Bulan Ini)</p>
                <?php if ($topEmployee): ?>
                    <p class="text-lg font-bold text-gray-800 truncate w-40" title="<?= htmlspecialchars($topEmployee['nama']) ?>">
                        <?= htmlspecialchars($topEmployee['nama']) ?>
                    </p>
                    <p class="text-xs text-emerald-600 font-semibold"><?= number_format($topEmployee['total_berat'], 0) ?> Kg</p>
                <?php else: ?>
                    <p class="text-sm text-gray-400 italic">Belum ada data</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Stats Grid Row 2: Master Data & Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Mini Stats: Karyawan -->
        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Karyawan</p>
                <p class="text-2xl font-bold text-gray-800"><?= number_format($totalKaryawan) ?></p>
            </div>
            <div class="text-indigo-500 bg-indigo-50 p-2 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Mini Stats: Blok Lahan -->
        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Blok</p>
                <p class="text-2xl font-bold text-gray-800"><?= number_format($totalBlok) ?></p>
            </div>
            <div class="text-teal-500 bg-teal-50 p-2 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="md:col-span-2 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-lg shadow-sm p-4 text-white flex items-center justify-between">
            <div>
                <h3 class="font-bold text-lg">Aksi Cepat</h3>
                <p class="text-emerald-100 text-sm">Pintasan menu operasional</p>
            </div>
            <div class="flex space-x-3">
                <a href="<?= BASE_URL ?>/panen/form.php" class="bg-white text-emerald-600 hover:bg-emerald-50 px-4 py-2 rounded-md font-medium text-sm transition-colors shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Input Panen
                </a>
                <a href="<?= BASE_URL ?>/laporan/index.php" class="bg-emerald-700 text-white hover:bg-emerald-800 px-4 py-2 rounded-md font-medium text-sm transition-colors border border-emerald-500 shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">5 Transaksi Panen Terakhir</h3>
            <a href="<?= BASE_URL ?>/panen/index.php" class="text-sm text-emerald-600 hover:text-emerald-800 font-medium hover:underline inline-flex items-center">
                Lihat Semua
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Karyawan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berat (Kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tandan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($recentTransactions)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                            <p>Belum ada transaksi panen.</p>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($recentTransactions as $row): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="font-medium"><?= date('d M Y', strtotime($row['tanggal'])) ?></div>
                                <div class="text-xs text-gray-500">ID: #<?= $row['id'] ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="px-2 py-1 bg-gray-100 rounded-md text-xs font-medium border border-gray-200">
                                    <?= htmlspecialchars($row['nama_blok']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= htmlspecialchars($row['nama_karyawan']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-emerald-600">
                                    <?= number_format($row['berat_kg'], 2, ',', '.') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $row['jumlah_tandan'] ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once '../app/views/layouts/main.php';
?>
