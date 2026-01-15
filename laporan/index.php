<?php
require_once '../config/database.php';

// Default date range: current month
$defaultStart = date('Y-m-01');
$defaultEnd = date('Y-m-t');

// Filters
$filterStartDate = $_GET['start_date'] ?? $defaultStart;
$filterEndDate = $_GET['end_date'] ?? $defaultEnd;
$filterBlok = $_GET['blok_id'] ?? '';
$filterKaryawan = $_GET['karyawan_id'] ?? '';

// Build query
$sql = "SELECT h.*, b.nama_blok, b.luas_hektar, k.nama as nama_karyawan, k.jabatan 
        FROM hasil_panen h 
        JOIN blok_lahan b ON h.blok_id = b.id 
        JOIN karyawan k ON h.karyawan_id = k.id 
        WHERE h.tanggal BETWEEN ? AND ?";
$params = [$filterStartDate, $filterEndDate];

if (!empty($filterBlok)) {
    $sql .= " AND h.blok_id = ?";
    $params[] = $filterBlok;
}

if (!empty($filterKaryawan)) {
    $sql .= " AND h.karyawan_id = ?";
    $params[] = $filterKaryawan;
}

$sql .= " ORDER BY h.tanggal DESC, h.id DESC";

$data = dbQuery($sql, $params);

// Get filter options
$blokOptions = dbQuery("SELECT * FROM blok_lahan ORDER BY nama_blok");
$karyawanOptions = dbQuery("SELECT * FROM karyawan ORDER BY nama");

// Calculate statistics
$totalBerat = array_sum(array_column($data, 'berat_kg'));
$totalTandan = array_sum(array_column($data, 'jumlah_tandan'));
$totalTransaksi = count($data);

// Group by Blok
$groupByBlok = [];
foreach ($data as $row) {
    $blokId = $row['blok_id'];
    if (!isset($groupByBlok[$blokId])) {
        $groupByBlok[$blokId] = [
            'nama_blok' => $row['nama_blok'],
            'total_berat' => 0,
            'total_tandan' => 0,
            'transaksi' => 0
        ];
    }
    $groupByBlok[$blokId]['total_berat'] += $row['berat_kg'];
    $groupByBlok[$blokId]['total_tandan'] += $row['jumlah_tandan'];
    $groupByBlok[$blokId]['transaksi']++;
}

// Group by Karyawan
$groupByKaryawan = [];
foreach ($data as $row) {
    $karyawanId = $row['karyawan_id'];
    if (!isset($groupByKaryawan[$karyawanId])) {
        $groupByKaryawan[$karyawanId] = [
            'nama_karyawan' => $row['nama_karyawan'],
            'total_berat' => 0,
            'total_tandan' => 0,
            'transaksi' => 0
        ];
    }
    $groupByKaryawan[$karyawanId]['total_berat'] += $row['berat_kg'];
    $groupByKaryawan[$karyawanId]['total_tandan'] += $row['jumlah_tandan'];
    $groupByKaryawan[$karyawanId]['transaksi']++;
}

$pageTitle = "Laporan Hasil Panen";
ob_start();
?>

<div class="space-y-6">
    <!-- Filter & Export Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
        <div class="flex flex-col lg:flex-row lg:items-end gap-4">
            <form method="GET" action="" class="flex-1 grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm p-2 border" 
                           value="<?= htmlspecialchars($filterStartDate) ?>">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm p-2 border" 
                           value="<?= htmlspecialchars($filterEndDate) ?>">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Blok</label>
                    <select name="blok_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm p-2 border">
                        <option value="">Semua Blok</option>
                        <?php foreach ($blokOptions as $blok): ?>
                            <option value="<?= $blok['id'] ?>" <?= $filterBlok == $blok['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($blok['nama_blok']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Karyawan</label>
                    <select name="karyawan_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm p-2 border">
                        <option value="">Semua Karyawan</option>
                        <?php foreach ($karyawanOptions as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= $filterKaryawan == $k['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($k['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filter
                    </button>
                </div>
            </form>
            
            <div class="flex gap-2">
                <a href="export.php?<?= http_build_query($_GET) ?>" 
                   class="inline-flex items-center px-4 py-2 border border-emerald-600 rounded-md text-emerald-600 bg-white hover:bg-emerald-50 transition-colors text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Excel
                </a>
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 print:grid-cols-3">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Transaksi</p>
                    <p class="text-3xl font-bold mt-1"><?= number_format($totalTransaksi) ?></p>
                    <p class="text-blue-100 text-xs mt-1">
                        <?= date('d M Y', strtotime($filterStartDate)) ?> - <?= date('d M Y', strtotime($filterEndDate)) ?>
                    </p>
                </div>
                <div class="p-3 bg-blue-400 bg-opacity-40 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Total Berat</p>
                    <p class="text-3xl font-bold mt-1"><?= number_format($totalBerat, 2, ',', '.') ?></p>
                    <p class="text-emerald-100 text-xs mt-1">Kilogram (Kg)</p>
                </div>
                <div class="p-3 bg-emerald-400 bg-opacity-40 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Total Tandan</p>
                    <p class="text-3xl font-bold mt-1"><?= number_format($totalTandan) ?></p>
                    <p class="text-orange-100 text-xs mt-1">Tandan Sawit</p>
                </div>
                <div class="p-3 bg-orange-400 bg-opacity-40 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary by Blok -->
    <?php if (!empty($groupByBlok)): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Ringkasan Per Blok Lahan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Blok</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Transaksi</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Berat (Kg)</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Tandan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rata-rata/Transaksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($groupByBlok as $item): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= htmlspecialchars($item['nama_blok']) ?></td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900"><?= number_format($item['transaksi']) ?></td>
                        <td class="px-6 py-4 text-sm text-right font-semibold text-emerald-600"><?= number_format($item['total_berat'], 2, ',', '.') ?></td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900"><?= number_format($item['total_tandan']) ?></td>
                        <td class="px-6 py-4 text-sm text-right text-gray-500"><?= number_format($item['total_berat'] / $item['transaksi'], 2, ',', '.') ?> Kg</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- Summary by Karyawan -->
    <?php if (!empty($groupByKaryawan)): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Ringkasan Per Karyawan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Karyawan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Transaksi</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Berat (Kg)</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Tandan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rata-rata/Transaksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($groupByKaryawan as $item): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= htmlspecialchars($item['nama_karyawan']) ?></td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900"><?= number_format($item['transaksi']) ?></td>
                        <td class="px-6 py-4 text-sm text-right font-semibold text-emerald-600"><?= number_format($item['total_berat'], 2, ',', '.') ?></td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900"><?= number_format($item['total_tandan']) ?></td>
                        <td class="px-6 py-4 text-sm text-right text-gray-500"><?= number_format($item['total_berat'] / $item['transaksi'], 2, ',', '.') ?> Kg</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- Detailed Data -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Data Detail Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Blok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Karyawan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Berat (Kg)</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Tandan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($data)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada data untuk periode yang dipilih
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($data as $index => $row): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500"><?= $index + 1 ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($row['nama_blok']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($row['nama_karyawan']) ?></td>
                            <td class="px-6 py-4 text-sm text-right font-semibold text-emerald-600"><?= number_format($row['berat_kg'], 2, ',', '.') ?></td>
                            <td class="px-6 py-4 text-sm text-right text-gray-900"><?= number_format($row['jumlah_tandan']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate"><?= htmlspecialchars($row['catatan'] ?: '-') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    .print\:hidden { display: none !important; }
    body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
}
</style>

<?php
$content = ob_get_clean();
require_once '../app/views/layouts/main.php';
?>
