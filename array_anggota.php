<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Array Data Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">📚 Data Anggota Perpustakaan</h2>

<?php
// MULTIDIMENSIONAL ARRAY (seperti contoh buku)
$anggota_list = [
    [
        "id" => "AGT-001",
        "nama" => "Rahendra Asyatir Asyafii",
        "email" => "rahendra@email.com",
        "telepon" => "081234567890",
        "status" => "aktif",
        "total_pinjam" => 5
    ],
    [
        "id" => "AGT-002",
        "nama" => "Keysa Nathania",
        "email" => "keysa@email.com",
        "telepon" => "082345678901",
        "status" => "non-aktif",
        "total_pinjam" => 2
    ],
    [
        "id" => "AGT-003",
        "nama" => "Fiya Adistiya",
        "email" => "fiya@email.com",
        "telepon" => "083456789012",
        "status" => "aktif",
        "total_pinjam" => 8
    ],
    [
        "id" => "AGT-004",
        "nama" => "Saputra Winanto",
        "email" => "saputra@email.com",
        "telepon" => "084567890123",
        "status" => "aktif",
        "total_pinjam" => 3
    ],
    [
        "id" => "AGT-005",
        "nama" => "Edy Soemarno",
        "email" => "edy@email.com",
        "telepon" => "085678901234",
        "status" => "non-aktif",
        "total_pinjam" => 1
    ]
];

// ================== LOGIKA ==================
$total_anggota = count($anggota_list);

$aktif = 0;
$nonaktif = 0;
$total_pinjam = 0;

$anggota_teraktif = $anggota_list[0];

foreach ($anggota_list as $a) {
    if ($a['status'] == 'aktif') {
        $aktif++;
    } else {
        $nonaktif++;
    }

    $total_pinjam += $a['total_pinjam'];

    if ($a['total_pinjam'] > $anggota_teraktif['total_pinjam']) {
        $anggota_teraktif = $a;
    }
}

$persen_aktif = ($aktif / $total_anggota) * 100;
$persen_nonaktif = ($nonaktif / $total_anggota) * 100;
$rata_pinjam = $total_pinjam / $total_anggota;

// FILTER
$filter = isset($_GET['status']) ? $_GET['status'] : 'semua';
?>

<!-- STATISTIK -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-bg-primary">
            <div class="card-body">
                <h6>Total</h6>
                <h4><?= $total_anggota ?></h4>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card text-bg-success">
            <div class="card-body">
                <h6>Aktif</h6>
                <h4><?= round($persen_aktif,1) ?>%</h4>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card text-bg-danger">
            <div class="card-body">
                <h6>Non-Aktif</h6>
                <h4><?= round($persen_nonaktif,1) ?>%</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-bg-warning">
            <div class="card-body">
                <h6>Rata Pinjam</h6>
                <h4><?= round($rata_pinjam,1) ?></h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-bg-dark">
            <div class="card-body">
                <h6>Teraktif</h6>
                <small><?= $anggota_teraktif['nama'] ?></small>
                <h5><?= $anggota_teraktif['total_pinjam'] ?>x</h5>
            </div>
        </div>
    </div>
</div>

<!-- FILTER -->
<div class="mb-3">
    <a href="?status=semua" class="btn btn-secondary btn-sm">Semua</a>
    <a href="?status=aktif" class="btn btn-success btn-sm">Aktif</a>
    <a href="?status=non-aktif" class="btn btn-danger btn-sm">Non-Aktif</a>
</div>

<!-- TABEL -->
<div class="card">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Daftar Anggota</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Status</th>
                    <th>Total Pinjam</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($anggota_list as $a): ?>
                    <?php if ($filter == 'semua' || $a['status'] == $filter): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $a['id']; ?></td>
                        <td><?= $a['nama']; ?></td>
                        <td><?= $a['email']; ?></td>
                        <td><?= $a['telepon']; ?></td>
                        <td>
                            <span class="badge <?= $a['status']=='aktif' ? 'bg-success':'bg-danger' ?>">
                                <?= $a['status']; ?>
                            </span>
                        </td>
                        <td><?= $a['total_pinjam']; ?></td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</div>

</body>
</html>