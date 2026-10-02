<?php
require_once '../config/database.php';

// Fetch all karyawan
$sql = "SELECT * FROM karyawan ORDER BY nama ASC";
$data = dbQuery($sql);

$pageTitle = "Data Karyawan";
ob_start();
?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100" x-data="{search:'',deleteId:null,deleteModal:false}">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-gray-50/50 rounded-t-2xl">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Daftar Karyawan</h3>
            <p class="text-sm text-gray-500 mt-0.5">Kelola data karyawan perkebunan</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" x-model="search" placeholder="Cari karyawan..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sawit-600 focus:border-transparent w-48">
            </div>
            <a href="form.php" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-sawit-700 hover:bg-sawit-800 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Tambah Karyawan
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Karyawan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terdaftar</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($data)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 whitespace-nowrap text-sm text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="font-medium text-gray-600">Belum ada data karyawan</p>
                            <p class="text-gray-400 text-xs mt-1">Klik tombol "Tambah Karyawan" untuk menambahkan data baru</p>
                        </div>
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach ($data as $row): ?>
                    <tr class="hover:bg-gray-50 transition-colors" x-show="!search || '<?= strtolower(htmlspecialchars($row['nama'])) ?>'.includes(search.toLowerCase()) || '<?= strtolower(htmlspecialchars($row['jabatan'])) ?>'.includes(search.toLowerCase())" x-transition>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-sawit-100 rounded-full flex items-center justify-center">
                                    <span class="text-sawit-700 font-bold text-sm"><?= strtoupper(substr($row['nama'], 0, 2)) ?></span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($row['nama']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-mono rounded bg-gray-100 text-gray-800">
                                <?= htmlspecialchars($row['nik']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                <?= htmlspecialchars($row['jabatan']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= date('d M Y', strtotime($row['created_at'])) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="form.php?id=<?= $row['id'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-3 inline-flex items-center transition-colors" title="Edit">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            <a href="#" @click.prevent="deleteId=<?= $row['id'] ?>;deleteModal=true" class="text-red-600 hover:text-red-900 inline-flex items-center transition-colors" title="Hapus">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Footer -->
    <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl flex items-center justify-between">
        <span class="text-sm text-gray-500">Total: <strong><?= count($data) ?></strong> Karyawan</span>
    </div>

    <!-- Delete Modal -->
    <div x-show="deleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition>
        <div class="fixed inset-0 bg-black/50" @click="deleteModal=false"></div>
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full relative z-10 shadow-2xl" x-transition>
            <div class="text-center">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Karyawan?</h3>
                <p class="text-sm text-gray-500 mb-6">Data yang dihapus tidak dapat dikembalikan.</p>
                <div class="flex gap-3">
                    <button @click="deleteModal=false" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition">Batal</button>
                    <a :href="'delete.php?id='+deleteId" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-medium hover:bg-red-700 transition text-center">Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once '../app/views/layouts/main.php';
?>
