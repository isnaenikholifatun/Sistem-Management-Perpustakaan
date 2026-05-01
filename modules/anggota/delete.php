<?php
session_start();
require_once 'config.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Ambil data untuk tahu nama file foto
    $stmt = $pdo->prepare("SELECT foto FROM anggota WHERE id_anggota = ?");
    $stmt->execute([$id]);
    $anggota = $stmt->fetch();

    if ($anggota) {
        // Hapus foto fisik jika ada
        if (!empty($anggota['foto']) && file_exists('uploads/' . $anggota['foto'])) {
            unlink('uploads/' . $anggota['foto']);
        }

        // Hapus data dari DB
        $stmtDelete = $pdo->prepare("DELETE FROM anggota WHERE id_anggota = ?");
        $stmtDelete->execute([$id]);

        $_SESSION['success'] = "Data anggota dan fotonya berhasil dihapus.";
    }
}

header("Location: index.php");
exit;
?>