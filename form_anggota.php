<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$success = false;

// keep value
$nama = $email = $telepon = $alamat = $jk = $tgl_lahir = $pekerjaan = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama = sanitize($_POST['nama'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $telepon = sanitize($_POST['telepon'] ?? '');
    $alamat = sanitize($_POST['alamat'] ?? '');
    $jk = $_POST['jk'] ?? '';
    $tgl_lahir = $_POST['tgl_lahir'] ?? '';
    $pekerjaan = $_POST['pekerjaan'] ?? '';

    // VALIDASI

    // Nama
    if (empty($nama)) {
        $errors['nama'] = "Nama wajib diisi";
    } elseif (strlen($nama) < 3) {
        $errors['nama'] = "Nama minimal 3 karakter";
    }

    // Email
    if (empty($email)) {
        $errors['email'] = "Email wajib diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format email tidak valid";
    }

    // Telepon
    if (empty($telepon)) {
        $errors['telepon'] = "Telepon wajib diisi";
    } elseif (!preg_match("/^08[0-9]{8,11}$/", $telepon)) {
        $errors['telepon'] = "Format telepon 08xxxxxxxxxx (10-13 digit)";
    }

    // Alamat
    if (empty($alamat)) {
        $errors['alamat'] = "Alamat wajib diisi";
    } elseif (strlen($alamat) < 10) {
        $errors['alamat'] = "Alamat minimal 10 karakter";
    }

    // Jenis Kelamin
    if (empty($jk)) {
        $errors['jk'] = "Pilih jenis kelamin";
    }

    // Tanggal Lahir
    if (empty($tgl_lahir)) {
        $errors['tgl_lahir'] = "Tanggal lahir wajib diisi";
    } else {
        $umur = date_diff(date_create($tgl_lahir), date_create('today'))->y;
        if ($umur < 10) {
            $errors['tgl_lahir'] = "Umur minimal 10 tahun";
        }
    }

    // Pekerjaan
    if (empty($pekerjaan)) {
        $errors['pekerjaan'] = "Pilih pekerjaan";
    }

    // Jika tidak ada error
    if (count($errors) == 0) {
        $success = true;
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Form Registrasi Anggota</h4>
                </div>

                <div class="card-body">

                    <!-- SUCCESS -->
                    <?php if ($success): ?>
                        <div class="card border-success p-3 mb-4">
                            <h5 class="text-success">Registrasi Berhasil!</h5>
                            <p><b>Nama:</b> <?= $nama ?></p>
                            <p><b>Email:</b> <?= $email ?></p>
                            <p><b>Telepon:</b> <?= $telepon ?></p>
                            <p><b>Alamat:</b> <?= $alamat ?></p>
                            <p><b>Jenis Kelamin:</b> <?= $jk ?></p>
                            <p><b>Tanggal Lahir:</b> <?= $tgl_lahir ?></p>
                            <p><b>Pekerjaan:</b> <?= $pekerjaan ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- ERROR GLOBAL -->
                    <?php if (count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            Terdapat <?= count($errors); ?> kesalahan, silakan periksa kembali.
                        </div>
                    <?php endif; ?>

                    <form method="POST" novalidate>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama"
                                class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>"
                                value="<?= $nama ?>">
                            <div class="invalid-feedback">
                                <?= $errors['nama'] ?? '' ?>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                value="<?= $email ?>">
                            <div class="invalid-feedback">
                                <?= $errors['email'] ?? '' ?>
                            </div>
                        </div>

                        <!-- Telepon -->
                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon"
                                class="form-control <?= isset($errors['telepon']) ? 'is-invalid' : '' ?>"
                                value="<?= $telepon ?>">
                            <div class="invalid-feedback">
                                <?= $errors['telepon'] ?? '' ?>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat"
                                class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>"
                                rows="3"><?= $alamat ?></textarea>
                            <div class="invalid-feedback">
                                <?= $errors['alamat'] ?? '' ?>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio" name="jk" value="Laki-laki"
                                    <?= $jk == 'Laki-laki' ? 'checked' : '' ?>>
                                <label class="form-check-label">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio" name="jk" value="Perempuan"
                                    <?= $jk == 'Perempuan' ? 'checked' : '' ?>>
                                <label class="form-check-label">Perempuan</label>
                            </div>
                            <div class="text-danger small">
                                <?= $errors['jk'] ?? '' ?>
                            </div>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir"
                                class="form-control <?= isset($errors['tgl_lahir']) ? 'is-invalid' : '' ?>"
                                value="<?= $tgl_lahir ?>">
                            <div class="invalid-feedback">
                                <?= $errors['tgl_lahir'] ?? '' ?>
                            </div>
                        </div>

                        <!-- Pekerjaan -->
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <select name="pekerjaan"
                                class="form-control <?= isset($errors['pekerjaan']) ? 'is-invalid' : '' ?>">
                                <option value="">-- Pilih --</option>
                                <option <?= $pekerjaan == 'Pelajar' ? 'selected' : '' ?>>Pelajar</option>
                                <option <?= $pekerjaan == 'Mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
                                <option <?= $pekerjaan == 'Pegawai' ? 'selected' : '' ?>>Pegawai</option>
                                <option <?= $pekerjaan == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $errors['pekerjaan'] ?? '' ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Daftar
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>