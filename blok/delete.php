<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        // Check dependencies (optional, but good practice)
        // If DELETE CASCADE is not desired on DB level, check here.
        // Our DB schema uses ON DELETE RESTRICT for hasil_panen -> blok_lahan
        // So this will fail if there is related data, which is correct.
        
        $sql = "DELETE FROM blok_lahan WHERE id = ?";
        dbExecute($sql, [$id]);
        
    } catch (PDOException $e) {
        // Handle FK Constraint violation
        if ($e->getCode() == '23000') {
            echo "<script>
                alert('Gagal menghapus! Data blok ini masih digunakan di data Hasil Panen.');
                window.location.href = 'index.php';
            </script>";
            exit;
        } else {
            die("Error: " . $e->getMessage());
        }
    }
}

header("Location: index.php");
exit;
