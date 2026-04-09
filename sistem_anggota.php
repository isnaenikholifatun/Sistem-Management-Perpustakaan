<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
<?php
require_once 'functions_anggota.php';

// BONUS FUNCTION
function sort_by_nama($anggota_list) {
    usort($anggota_list, function($a, $b) {
        return strcmp($a['nama'], $b['nama']);
    });
    return $anggota_list;
}

function search_by_nama($anggota_list, $keyword) {
    $hasil = [];
    foreach ($anggota_list as $anggota) {
        if (stripos($anggota['nama'], $keyword) !== false) {
            $hasil[] = $anggota;
        }
    }
    return $hasil;
}

// Data anggota
$anggota_list = [
    ["id"=>"AGT-001","nama"=>"Isnaeni Kholifatun","email"=>"isnaeni@email.com","status"=>"Aktif","total_pinjaman"=>5,"tanggal_daftar"=>"2024-01-10"],
    ["id"=>"AGT-002","nama"=>"Saffarrudin","email"=>"saffar@email.com","status"=>"Non-Aktif","total_pinjaman"=>2,"tanggal_daftar"=>"2024-02-12"],
    ["id"=>"AGT-003","nama"=>"Iswati","email"=>"iswati@email.com","status"=>"Aktif","total_pinjaman"=>8,"tanggal_daftar"=>"2024-03-05"],
    ["id"=>"AGT-004","nama"=>"Eko Susilo","email"=>"eko@email.com","status"=>"Aktif","total_pinjaman"=>3,"tanggal_daftar"=>"2024-01-25"],
    ["id"=>"AGT-005","nama"=>"Riska Umiyati","email"=>"riska@email.com","status"=>"Non-Aktif","total_pinjaman"=>1,"tanggal_daftar"=>"2024-02-20"]
];

// SEARCH
$keyword = isset($_GET['search']) ? $_GET['search'] : '';
$data_tampil = $keyword ? search_by_nama($anggota_list, $keyword) : $anggota_list;

// SORT
$data_tampil = sort_by_nama($data_tampil);

// Statistik
$total = hitung_total_anggota($anggota_list);
$aktif = hitung_anggota_aktif($anggota_list);
$nonaktif = $total - $aktif;
$rata = hitung_rata_rata_pinjaman($anggota_list);
$teraktif = cari_anggota_teraktif($anggota_list);

// Filter
$list_aktif = filter_by_status($anggota_list, "Aktif");
$list_nonaktif = filter_by_status($anggota_list, "Non-Aktif");
?>

<div class="container mt-5">
    <h1 class="mb-4"><i class="bi bi-people"></i> Sistem Anggota Perpustakaan</h1>

    <!-- Search -->
    <form class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari nama anggota..." value="<?= $keyword ?>">
    </form>

    <!-- Dashboard -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h5>Total</h5>
                    <h3><?= $total ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5>Aktif</h5>
                    <h3><?= $aktif ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-danger">
                <div class="card-body">
                    <h5>Non-Aktif</h5>
                    <h3><?= $nonaktif ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h5>Rata Pinjaman</h5>
                    <h3><?= number_format($rata,1) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Daftar Anggota
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Pinjaman</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data_tampil as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= $a['nama'] ?></td>
                        <td><?= $a['email'] ?></td>
                        <td>
                            <span class="badge bg-<?= $a['status']=="Aktif" ? "success":"secondary" ?>">
                                <?= $a['status'] ?>
                            </span>
                        </td>
                        <td><?= $a['total_pinjaman'] ?></td>
                        <td><?= format_tanggal_indo($a['tanggal_daftar']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Anggota Teraktif -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            Anggota Teraktif
        </div>
        <div class="card-body">
            <h5><?= $teraktif['nama'] ?></h5>
            <p>Total Pinjaman: <?= $teraktif['total_pinjaman'] ?></p>
        </div>
    </div>

    <!-- Aktif & Non Aktif -->
    <div class="row">
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-header bg-success text-white">Anggota Aktif</div>
                <div class="card-body">
                    <ul>
                        <?php foreach($list_aktif as $a): ?>
                            <li><?= $a['nama'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">Non-Aktif</div>
                <div class="card-body">
                    <ul>
                        <?php foreach($list_nonaktif as $a): ?>
                            <li><?= $a['nama'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>