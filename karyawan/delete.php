<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        // Attempt to delete
        $sql = "DELETE FROM karyawan WHERE id = ?";
        dbExecute($sql, [$id]);
        
    } catch (PDOException $e) {
        // Handle FK Constraint violation (karyawan has related hasil_panen)
        if ($e->getCode() == '23000') {
            echo "<script>
                alert('Gagal menghapus! Karyawan ini memiliki data hasil panen yang terkait.');
                window.location.href = 'index.php';
            </script>";
            exit;
        } else {
            die("Error: Terjadi kesalahan saat menghapus data.");
        }
    }
}

header("Location: index.php");
exit;
