<?php
require_once '../config/database.php';

// Get filters from query string
$filterStartDate = $_GET['start_date'] ?? date('Y-m-01');
$filterEndDate = $_GET['end_date'] ?? date('Y-m-t');
$filterBlok = $_GET['blok_id'] ?? '';
$filterKaryawan = $_GET['karyawan_id'] ?? '';

// Build query (same as index.php)
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

// Set headers for CSV download
$filename = "Laporan_Panen_" . date('Y-m-d_His') . ".csv";
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open output stream
$output = fopen('php://output', 'w');

// Add BOM for Excel UTF-8 compatibility
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Header info
fputcsv($output, ['LAPORAN HASIL PANEN']);
fputcsv($output, ['Periode:', date('d/m/Y', strtotime($filterStartDate)) . ' - ' . date('d/m/Y', strtotime($filterEndDate))]);
fputcsv($output, ['Dicetak:', date('d/m/Y H:i:s')]);
fputcsv($output, []); // Empty row

// Summary statistics
$totalBerat = array_sum(array_column($data, 'berat_kg'));
$totalTandan = array_sum(array_column($data, 'jumlah_tandan'));
$totalTransaksi = count($data);

fputcsv($output, ['RINGKASAN']);
fputcsv($output, ['Total Transaksi', $totalTransaksi]);
fputcsv($output, ['Total Berat (Kg)', number_format($totalBerat, 2, '.', '')]);
fputcsv($output, ['Total Tandan', $totalTandan]);
fputcsv($output, []); // Empty row

// Column headers for data
fputcsv($output, [
    'No',
    'Tanggal',
    'Blok Lahan',
    'Luas Blok (Ha)',
    'Karyawan',
    'Jabatan',
    'Berat (Kg)',
    'Jumlah Tandan',
    'Catatan'
]);

// Data rows
$no = 1;
foreach ($data as $row) {
    fputcsv($output, [
        $no++,
        date('d/m/Y', strtotime($row['tanggal'])),
        $row['nama_blok'],
        $row['luas_hektar'],
        $row['nama_karyawan'],
        $row['jabatan'],
        $row['berat_kg'],
        $row['jumlah_tandan'],
        $row['catatan']
    ]);
}

fclose($output);
exit;
