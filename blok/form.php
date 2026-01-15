<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
$error = null;
$success = null;
$data = [
    'nama_blok' => '',
    'luas_hektar' => '',
    'tahun_tanam' => date('Y')
];

// If ID exists, fetch data for Edit
if ($id) {
    $item = dbQueryOne("SELECT * FROM blok_lahan WHERE id = ?", [$id]);
    if ($item) {
        $data = $item;
    } else {
        header("Location: index.php");
        exit;
    }
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_blok = trim($_POST['nama_blok']);
    $luas_hektar = trim($_POST['luas_hektar']);
    $tahun_tanam = trim($_POST['tahun_tanam']);

    // Basic Validation
    if (empty($nama_blok) || empty($luas_hektar) || empty($tahun_tanam)) {
        $error = "Semua field harus diisi.";
    } elseif (!is_numeric($luas_hektar) || $luas_hektar <= 0) {
        $error = "Luas lahan harus berupa angka positif.";
    } elseif (!is_numeric($tahun_tanam) || strlen($tahun_tanam) != 4) {
        $error = "Tahun tanam tidak valid.";
    } else {
        try {
            if ($id) {
                // Update
                $sql = "UPDATE blok_lahan SET nama_blok = ?, luas_hektar = ?, tahun_tanam = ? WHERE id = ?";
                $params = [$nama_blok, $luas_hektar, $tahun_tanam, $id];
            } else {
                // Insert
                $sql = "INSERT INTO blok_lahan (nama_blok, luas_hektar, tahun_tanam) VALUES (?, ?, ?)";
                $params = [$nama_blok, $luas_hektar, $tahun_tanam];
            }

            dbExecute($sql, $params);
            
            header("Location: index.php");
            exit;

        } catch (Exception $e) {
            $error = "Gagal menyimpan data: " . $e->getMessage();
        }
    }
}

$pageTitle = $id ? "Edit Blok Lahan" : "Tambah Blok Lahan";
ob_start();
?>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800"><?= $pageTitle ?></h3>
            <a href="index.php" class="text-sm text-gray-500 hover:text-gray-700 font-medium inline-flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="p-6">
            <?php if ($error): ?>
                <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
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
                <!-- Nama Blok -->
                <div>
                    <label for="nama_blok" class="block text-sm font-medium text-gray-700">Nama Blok</label>
                    <div class="mt-1">
                        <input type="text" name="nama_blok" id="nama_blok" required
                               class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border"
                               value="<?= htmlspecialchars($data['nama_blok'] ?? '') ?>"
                               placeholder="Contoh: Blok A1">
                    </div>
                </div>

                <!-- Luas Hektar -->
                <div>
                    <label for="luas_hektar" class="block text-sm font-medium text-gray-700">Luas (Hektar)</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="number" step="0.01" name="luas_hektar" id="luas_hektar" required
                               class="focus:ring-emerald-500 focus:border-emerald-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md p-2.5 border"
                               value="<?= htmlspecialchars($data['luas_hektar'] ?? '') ?>"
                               placeholder="0.00">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Ha</span>
                        </div>
                    </div>
                </div>

                <!-- Tahun Tanam -->
                <div>
                    <label for="tahun_tanam" class="block text-sm font-medium text-gray-700">Tahun Tanam</label>
                    <div class="mt-1">
                        <input type="number" min="1990" max="<?= date('Y') ?>" name="tahun_tanam" id="tahun_tanam" required
                               class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 border"
                               value="<?= htmlspecialchars($data['tahun_tanam'] ?? '') ?>">
                        <p class="mt-1 text-xs text-gray-500">Maksimal tahun sekarang.</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
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
