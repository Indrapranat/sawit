<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
$error = null;
$success = null;
$data = [
    'tanggal' => date('Y-m-d'),
    'blok_id' => '',
    'karyawan_id' => '',
    'berat_kg' => '',
    'jumlah_tandan' => '',
    'catatan' => ''
];

// If editing, fetch existing data
if ($id) {
    $item = dbQueryOne("SELECT * FROM hasil_panen WHERE id = ?", [$id]);
    if ($item) {
        $data = $item;
    } else {
        header("Location: index.php");
        exit;
    }
}

// Fetch dropdown options
$blok_lahan = dbQuery("SELECT * FROM blok_lahan ORDER BY nama_blok ASC");
$karyawan = dbQuery("SELECT * FROM karyawan ORDER BY nama ASC");

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'] ?? '';
    $blok_id = $_POST['blok_id'] ?? '';
    $karyawan_id = $_POST['karyawan_id'] ?? '';
    $berat_kg = $_POST['berat_kg'] ?? '';
    $jumlah_tandan = $_POST['jumlah_tandan'] ?? '';
    $catatan = $_POST['catatan'] ?? '';

    // Validation
    if (empty($tanggal) || empty($blok_id) || empty($karyawan_id) || empty($berat_kg) || empty($jumlah_tandan)) {
        $error = "Mohon lengkapi semua field yang wajib.";
    } elseif (!is_numeric($berat_kg) || $berat_kg <= 0) {
        $error = "Berat harus berupa angka positif.";
    } elseif (!is_numeric($jumlah_tandan) || $jumlah_tandan <= 0) {
        $error = "Jumlah tandan harus berupa angka positif.";
    } else {
        try {
            if ($id) {
                // Update
                $sql = "UPDATE hasil_panen SET tanggal = ?, blok_id = ?, karyawan_id = ?, berat_kg = ?, jumlah_tandan = ?, catatan = ? WHERE id = ?";
                dbExecute($sql, [$tanggal, $blok_id, $karyawan_id, $berat_kg, $jumlah_tandan, $catatan, $id]);
            } else {
                // Insert
                $sql = "INSERT INTO hasil_panen (tanggal, blok_id, karyawan_id, berat_kg, jumlah_tandan, catatan) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                dbExecute($sql, [$tanggal, $blok_id, $karyawan_id, $berat_kg, $jumlah_tandan, $catatan]);
            }
            
            header("Location: index.php");
            exit;

        } catch (Exception $e) {
            $error = "Gagal menyimpan data. Silakan coba lagi.";
        }
    }
    
    // Preserve input on error
    $data = compact('tanggal', 'blok_id', 'karyawan_id', 'berat_kg', 'jumlah_tandan', 'catatan');
}

$pageTitle = $id ? "Edit Hasil Panen" : "Input Hasil Panen";
ob_start();
?>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-800"><?= $pageTitle ?></h3>
                <p class="text-sm text-gray-500 mt-0.5"><?= $id ? 'Perbarui data hasil panen' : 'Tambahkan data hasil panen baru' ?></p>
            </div>
            <a href="index.php" class="text-sm text-gray-500 hover:text-gray-700 font-medium inline-flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="p-6">
            <?php if ($error): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700"><?= htmlspecialchars($error) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-6">
                <!-- Tanggal -->
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Panen <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" required
                           class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border"
                           value="<?= htmlspecialchars($data['tanggal']) ?>">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Blok Lahan -->
                    <div>
                        <label for="blok_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Blok Lahan <span class="text-red-500">*</span>
                        </label>
                        <select name="blok_id" id="blok_id" required
                                class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                            <option value="">-- Pilih Blok --</option>
                            <?php foreach ($blok_lahan as $blok): ?>
                                <option value="<?= $blok['id'] ?>" <?= $data['blok_id'] == $blok['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($blok['nama_blok']) ?> (<?= $blok['luas_hektar'] ?> Ha)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (empty($blok_lahan)): ?>
                            <p class="mt-1 text-xs text-orange-600">⚠️ Belum ada blok lahan. <a href="../blok/form.php" class="underline">Tambah blok</a></p>
                        <?php endif; ?>
                    </div>

                    <!-- Karyawan -->
                    <div>
                        <label for="karyawan_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Karyawan Pemanen <span class="text-red-500">*</span>
                        </label>
                        <select name="karyawan_id" id="karyawan_id" required
                                class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border">
                            <option value="">-- Pilih Karyawan --</option>
                            <?php foreach ($karyawan as $k): ?>
                                <option value="<?= $k['id'] ?>" <?= $data['karyawan_id'] == $k['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($k['nama']) ?> - <?= htmlspecialchars($k['jabatan']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (empty($karyawan)): ?>
                            <p class="mt-1 text-xs text-orange-600">⚠️ Belum ada karyawan. <a href="../karyawan/form.php" class="underline">Tambah karyawan</a></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Berat KG -->
                    <div>
                        <label for="berat_kg" class="block text-sm font-medium text-gray-700 mb-1">
                            Berat Total (Kg) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="number" step="0.01" min="0.01" name="berat_kg" id="berat_kg" required
                                   class="focus:ring-emerald-500 focus:border-emerald-500 block w-full pr-16 sm:text-sm border-gray-300 rounded-md p-2.5 border"
                                   value="<?= htmlspecialchars($data['berat_kg']) ?>"
                                   placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm font-medium">Kg</span>
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah Tandan -->
                    <div>
                        <label for="jumlah_tandan" class="block text-sm font-medium text-gray-700 mb-1">
                            Jumlah Tandan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" min="1" name="jumlah_tandan" id="jumlah_tandan" required
                               class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border"
                               value="<?= htmlspecialchars($data['jumlah_tandan']) ?>"
                               placeholder="0">
                    </div>
                </div>

                <!-- Catatan -->
                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">
                        Catatan <span class="text-gray-400 text-xs">(Opsional)</span>
                    </label>
                    <textarea name="catatan" id="catatan" rows="3"
                              class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border"
                              placeholder="Tambahkan catatan jika diperlukan"><?= htmlspecialchars($data['catatan']) ?></textarea>
                </div>

                <!-- Submit -->
                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <a href="index.php" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 transition-colors">
                        <?= $id ? 'Update Data' : 'Simpan Data' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once '../app/views/layouts/main.php';
?>
