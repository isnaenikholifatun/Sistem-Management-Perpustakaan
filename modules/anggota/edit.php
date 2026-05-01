<?php
session_start();
require_once 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: index.php"); exit; }

// Fetch existing data
$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id_anggota = ?");
$stmt->execute([$id]);
$anggota = $stmt->fetch();

if (!$anggota) { header("Location: index.php"); exit; }

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = trim($_POST['kode_anggota']);
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']);
    $alamat = trim($_POST['alamat']);
    $tgl_lahir = $_POST['tanggal_lahir'];
    $jk = $_POST['jenis_kelamin'];
    $pekerjaan = trim($_POST['pekerjaan']);
    $status = $_POST['status'];
    
    if(empty($kode) || empty($nama) || empty($email) || empty($telepon) || empty($alamat) || empty($tgl_lahir) || empty($jk)) {
        $error = "Semua field yang bertanda * wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } elseif (!preg_match('/^08[0-9]{8,13}$/', $telepon)) {
        $error = "Nomor telepon harus diawali 08 dan berisi 10-15 angka.";
    } else {
        $dob = new DateTime($tgl_lahir);
        $now = new DateTime();
        $age = $now->diff($dob)->y;
        
        if ($age < 10) {
            $error = "Umur minimal harus 10 tahun.";
        } else {
            // Cek Unik Kode/Email (kecuali user ini sendiri)
            $stmtCek = $pdo->prepare("SELECT id_anggota FROM anggota WHERE (kode_anggota = ? OR email = ?) AND id_anggota != ?");
            $stmtCek->execute([$kode, $email, $id]);
            if ($stmtCek->rowCount() > 0) {
                $error = "Kode Anggota atau Email sudah dipakai orang lain.";
            }
        }
    }

    if (empty($error)) {
        $foto_name = $anggota['foto']; // Default pakai foto lama
        
        // Cek jika ada upload foto baru
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png'];
            $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $foto_name = time() . '_' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $foto_name);
                
                // Hapus foto lama
                if (!empty($anggota['foto']) && file_exists('uploads/' . $anggota['foto'])) {
                    unlink('uploads/' . $anggota['foto']);
                }
            } else {
                $error = "Format foto harus JPG/PNG.";
            }
        }
    }

    if (empty($error)) {
        $stmtUpdate = $pdo->prepare("UPDATE anggota SET kode_anggota=?, nama=?, email=?, telepon=?, alamat=?, tanggal_lahir=?, jenis_kelamin=?, pekerjaan=?, status=?, foto=? WHERE id_anggota=?");
        $stmtUpdate->execute([$kode, $nama, $email, $telepon, $alamat, $tgl_lahir, $jk, $pekerjaan, $status, $foto_name, $id]);
        
        $_SESSION['success'] = "Data anggota berhasil diubah!";
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4 mb-5" style="max-width: 800px;">
    <h2>Edit Data Anggota</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Kembali</a>

    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Kode Anggota *</label>
                        <input type="text" name="kode_anggota" class="form-control" required value="<?= htmlspecialchars($anggota['kode_anggota']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="nama" class="form-control" required value="<?= htmlspecialchars($anggota['nama']) ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($anggota['email']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Telepon *</label>
                        <input type="text" name="telepon" class="form-control" required value="<?= htmlspecialchars($anggota['telepon']) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Alamat Lengkap *</label>
                    <textarea name="alamat" class="form-control" rows="3" required><?= htmlspecialchars($anggota['alamat']) ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" class="form-control" required value="<?= htmlspecialchars($anggota['tanggal_lahir']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Jenis Kelamin *</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="Laki-laki" <?= $anggota['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= $anggota['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Aktif" <?= $anggota['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="Nonaktif" <?= $anggota['status'] == 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" value="<?= htmlspecialchars($anggota['pekerjaan']) ?>">
                </div>

                <div class="mb-3">
                    <label>Update Foto (Kosongkan jika tidak diubah)</label><br>
                    <?php if(!empty($anggota['foto'])): ?>
                        <img src="uploads/<?= $anggota['foto'] ?>" width="80" class="mb-2 rounded">
                    <?php endif; ?>
                    <input type="file" name="foto" class="form-control" accept="image/jpeg, image/png">
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Data Anggota</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>