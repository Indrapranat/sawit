<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
$error = null;
$data = [
    'nama' => '',
    'nik' => '',
    'jabatan' => ''
];

// Predefined jabatan options
$jabatanOptions = [
    'Pemanen',
    'Mandor',
    'Supir',
    'Mekanik',
    'Security',
    'Admin',
    'Lainnya'
];

// If editing, fetch existing data
if ($id) {
    $item = dbQueryOne("SELECT * FROM karyawan WHERE id = ?", [$id]);
    if ($item) {
        $data = $item;
    } else {
        header("Location: index.php");
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $nik = trim($_POST['nik'] ?? '');
    $jabatan = trim($_POST['jabatan'] ?? '');
    $jabatan_lain = trim($_POST['jabatan_lain'] ?? '');
    
    // If "Lainnya" selected, use custom jabatan
    if ($jabatan === 'Lainnya' && !empty($jabatan_lain)) {
        $jabatan = $jabatan_lain;
    }

    // Validation
    if (empty($nama)) {
        $error = "Nama karyawan harus diisi.";
    } elseif (empty($nik)) {
        $error = "NIK harus diisi.";
    } elseif (!preg_match('/^[0-9]{6,20}$/', $nik)) {
        $error = "NIK harus berupa angka (6-20 digit).";
    } elseif (empty($jabatan)) {
        $error = "Jabatan harus dipilih.";
    } else {
        try {
            // Check NIK uniqueness (except for current record when editing)
            $checkSql = $id 
                ? "SELECT id FROM karyawan WHERE nik = ? AND id != ?" 
                : "SELECT id FROM karyawan WHERE nik = ?";
            $checkParams = $id ? [$nik, $id] : [$nik];
            $existing = dbQueryOne($checkSql, $checkParams);
            
            if ($existing) {
                $error = "NIK sudah terdaftar untuk karyawan lain.";
            } else {
                if ($id) {
                    // Update
                    $sql = "UPDATE karyawan SET nama = ?, nik = ?, jabatan = ? WHERE id = ?";
                    dbExecute($sql, [$nama, $nik, $jabatan, $id]);
                } else {
                    // Insert
                    $sql = "INSERT INTO karyawan (nama, nik, jabatan) VALUES (?, ?, ?)";
                    dbExecute($sql, [$nama, $nik, $jabatan]);
                }
                
                header("Location: index.php");
                exit;
            }
        } catch (Exception $e) {
            $error = "Gagal menyimpan data. Silakan coba lagi.";
        }
    }
    
    // Preserve input on error
    $data = ['nama' => $nama, 'nik' => $nik, 'jabatan' => $jabatan];
}

$pageTitle = $id ? "Edit Karyawan" : "Tambah Karyawan";
ob_start();
?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-800"><?= $pageTitle ?></h3>
                <p class="text-sm text-gray-500 mt-0.5"><?= $id ? 'Perbarui informasi karyawan' : 'Masukkan data karyawan baru' ?></p>
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
                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" required autocomplete="off"
                           class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border"
                           value="<?= htmlspecialchars($data['nama']) ?>"
                           placeholder="Masukkan nama lengkap karyawan">
                </div>

                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">
                        NIK (Nomor Induk Karyawan) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nik" id="nik" required autocomplete="off"
                           class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border font-mono"
                           value="<?= htmlspecialchars($data['nik']) ?>"
                           placeholder="Contoh: 123456"
                           pattern="[0-9]{6,20}"
                           title="NIK harus berupa angka 6-20 digit">
                    <p class="mt-1 text-xs text-gray-500">NIK harus unik dan terdiri dari 6-20 digit angka.</p>
                </div>

                <!-- Jabatan -->
                <div>
                    <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <select name="jabatan" id="jabatan" required
                            class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border"
                            onchange="toggleJabatanLain(this)">
                        <option value="">-- Pilih Jabatan --</option>
                        <?php foreach ($jabatanOptions as $opt): ?>
                            <option value="<?= $opt ?>" <?= ($data['jabatan'] === $opt || (!in_array($data['jabatan'], $jabatanOptions) && $opt === 'Lainnya' && !empty($data['jabatan']))) ? 'selected' : '' ?>>
                                <?= $opt ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Jabatan Lainnya (hidden by default) -->
                <div id="jabatan_lain_container" class="<?= (!in_array($data['jabatan'], $jabatanOptions) && !empty($data['jabatan'])) ? '' : 'hidden' ?>">
                    <label for="jabatan_lain" class="block text-sm font-medium text-gray-700 mb-1">
                        Jabatan Lainnya
                    </label>
                    <input type="text" name="jabatan_lain" id="jabatan_lain"
                           class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border"
                           value="<?= (!in_array($data['jabatan'], $jabatanOptions) && !empty($data['jabatan'])) ? htmlspecialchars($data['jabatan']) : '' ?>"
                           placeholder="Masukkan jabatan">
                </div>

                <!-- Submit -->
                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <a href="index.php" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <?= $id ? 'Update Data' : 'Simpan Data' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleJabatanLain(select) {
    const container = document.getElementById('jabatan_lain_container');
    const input = document.getElementById('jabatan_lain');
    if (select.value === 'Lainnya') {
        container.classList.remove('hidden');
        input.required = true;
    } else {
        container.classList.add('hidden');
        input.required = false;
        input.value = '';
    }
}
</script>

<?php
$content = ob_get_clean();
require_once '../app/views/layouts/main.php';
?>
