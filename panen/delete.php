<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) {
    try {
        $sql = "DELETE FROM hasil_panen WHERE id = ?";
        dbExecute($sql, [$id]);
    } catch (PDOException $e) {
        echo "<script>
            alert('Gagal menghapus data. Silakan coba lagi.');
            window.location.href = 'index.php';
        </script>";
        exit;
    }
}

header("Location: index.php");
exit;
