<?php
session_start();
require_once 'config.php';

// Buat folder uploads jika belum ada
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

$error = '';
$today = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = trim($_POST['kode_anggota']);
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']);
    $alamat = trim($_POST['alamat']);
    $tgl_lahir = $_POST['tanggal_lahir'];
    $jk = $_POST['jenis_kelamin'];
    $pekerjaan = trim($_POST['pekerjaan']);
    
    // Validasi Field Required
    if(empty($kode) || empty($nama) || empty($email) || empty($telepon) || empty($alamat) || empty($tgl_lahir) || empty($jk)) {
        $error = "Semua field yang bertanda * wajib diisi.";
    } 
    // Validasi Email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    }
    // Validasi Telepon (08xxxxxxxxxx)
    elseif (!preg_match('/^08[0-9]{8,13}$/', $telepon)) {
        $error = "Nomor telepon harus diawali 08 dan berisi 10-15 angka.";
    } else {
        // Validasi Umur minimal 10 tahun
        $dob = new DateTime($tgl_lahir);
        $now = new DateTime();
        $age = $now->diff($dob)->y;
        
        if ($age < 10) {
            $error = "Umur minimal harus 10 tahun.";
        } else {
            // Cek Unik Kode dan Email
            $stmtCek = $pdo->prepare("SELECT id_anggota FROM anggota WHERE kode_anggota = ? OR email = ?");
            $stmtCek->execute([$kode, $email]);
            if ($stmtCek->rowCount() > 0) {
                $error = "Kode Anggota atau Email sudah terdaftar.";
            }
        }
    }

    if (empty($error)) {
        // Handle File Upload
        $foto_name = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png'];
            $filename = $_FILES['foto']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $foto_name = time() . '_' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $foto_name);
            } else {
                $error = "Format foto harus JPG/PNG.";
            }
        }
    }

    if (empty($error)) {
        // Insert Data
        $stmt = $pdo->prepare("INSERT INTO anggota (kode_anggota, nama, email, telepon, alamat, tanggal_lahir, jenis_kelamin, pekerjaan, tanggal_daftar, status, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Aktif', ?)");
        $stmt->execute([$kode, $nama, $email, $telepon, $alamat, $tgl_lahir, $jk, $pekerjaan, $today, $foto_name]);
        
        $_SESSION['success'] = "Anggota berhasil ditambahkan!";
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4 mb-5" style="max-width: 800px;">
    <h2>Tambah Anggota Baru</h2>
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
                        <input type="text" name="kode_anggota" class="form-control" required value="<?= htmlspecialchars($_POST['kode_anggota'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="nama" class="form-control" required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Telepon * (Mulai dengan 08)</label>
                        <input type="text" name="telepon" class="form-control" required value="<?= htmlspecialchars($_POST['telepon'] ?? '') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Alamat Lengkap *</label>
                    <textarea name="alamat" class="form-control" rows="3" required><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" class="form-control" required value="<?= htmlspecialchars($_POST['tanggal_lahir'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Jenis Kelamin *</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">Pilih...</option>
                            <option value="Laki-laki" <?= (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control" value="<?= htmlspecialchars($_POST['pekerjaan'] ?? '') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Upload Foto (Opsional, JPG/PNG)</label>
                    <input type="file" name="foto" class="form-control" accept="image/jpeg, image/png">
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan Data Anggota</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>