<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Informasi Buku</h1>

        <?php
        //Data Buku 1
        $judul = "Pemrograman Web dengan PHP";
        $pengarang = "Budi Raharjo";
        $penerbit = "Informatika";
        $tahun_terbit = 2023;
        $harga = 85000;
        $stok =15;
        $isbn = "978-602-1234-56-7";
        $kategori = "Programming";
        $bahasa = "Indonesia";
        $halaman = 320;
        $berat = 500;
        ?>

        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <?php echo $judul; ?>
                    <span class="badge bg-dark text-light"><?php echo $kategori; ?></span>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th width="200">Pengarang</th><td>: <?php echo $pengarang; ?></td></tr>
                    <tr><th>Penerbit</th><td>: <?php echo $penerbit; ?></td></tr>
                    <tr><th>Tahun Terbit</th><td>: <?php echo $tahun_terbit; ?></td></tr>
                    <tr><th>ISBN</th><td>: <?php echo $isbn; ?></td></tr>
                    <tr><th>Kategori</th><td>: <?php echo $kategori; ?></td></tr>
                    <tr><th>Bahasa</th><td>: <?php echo $bahasa; ?></td></tr>
                    <tr><th>Jumlah Halaman</th><td>: <?php echo $halaman; ?></td></tr>
                    <tr><th>Berat</th><td>: <?php echo $berat; ?> gram</td></tr>
                    <tr><th>Harga</th><td>: Rp <?php echo number_format($harga, 0, ',', '.'); ?></td></tr>
                    <tr><th>Stok</th><td>: <?php echo $stok; ?> buku</td></tr>
                </table>
            </div>
        </div>

        <?php
        //Data Buku 2
        $judul = "Pemrograman PHP Modern";
        $pengarang = "Rudi Hartono";
        $penerbit = "Elex Media";
        $tahun_terbit = 2022;
        $harga = 95000;
        $stok = 12;
        $isbn = "978-602-8888-11-2";
        $kategori = "Programming";
        $bahasa = "Indonesia";
        $halaman = 450;
        $berat = 550;
        ?>

        <div class="card mb-4">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">
                    <?php echo $judul; ?>
                    <span class="badge bg-light text-dark"><?php echo $kategori; ?></span>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th width="200">Pengarang</th><td>: <?php echo $pengarang; ?></td></tr>
                    <tr><th>Penerbit</th><td>: <?php echo $penerbit; ?></td></tr>
                    <tr><th>Tahun Terbit</th><td>: <?php echo $tahun_terbit; ?></td></tr>
                    <tr><th>ISBN</th><td>: <?php echo $isbn; ?></td></tr>
                    <tr><th>Kategori</th><td>: <?php echo $kategori; ?></td></tr>
                    <tr><th>Bahasa</th><td>: <?php echo $bahasa; ?></td></tr>
                    <tr><th>Jumlah Halaman</th><td>: <?php echo $halaman; ?></td></tr>
                    <tr><th>Berat</th><td>: <?php echo $berat; ?> gram</td></tr>
                    <tr><th>Harga</th><td>: Rp <?php echo number_format($harga, 0, ',', '.'); ?></td></tr>
                    <tr><th>Stok</th><td>: <?php echo $stok; ?> buku</td></tr>
                </table>
            </div>
        </div>

        <?php
        //Data Buku 3
        $judul = "MySQL Database Administration";
        $pengarang = "Paul DuBois";
        $penerbit = "Oracle Press";
        $tahun_terbit = 2021;
        $harga = 120000;
        $stok = 8;
        $isbn = "978-007-149504-1";
        $kategori = "Database";
        $bahasa = "Inggris";
        $halaman = 380;
        $berat = 600;
        ?>

        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <?php echo $judul; ?>
                    <span class="badge bg-dark text-light"><?php echo $kategori; ?></span>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th width="200">Pengarang</th><td>: <?php echo $pengarang; ?></td></tr>
                    <tr><th>Penerbit</th><td>: <?php echo $penerbit; ?></td></tr>
                    <tr><th>Tahun Terbit</th><td>: <?php echo $tahun_terbit; ?></td></tr>
                    <tr><th>ISBN</th><td>: <?php echo $isbn; ?></td></tr>
                    <tr><th>Kategori</th><td>: <?php echo $kategori; ?></td></tr>
                    <tr><th>Bahasa</th><td>: <?php echo $bahasa; ?></td></tr>
                    <tr><th>Jumlah Halaman</th><td>: <?php echo $halaman; ?></td></tr>
                    <tr><th>Berat</th><td>: <?php echo $berat; ?> gram</td></tr>
                    <tr><th>Harga</th><td>: Rp <?php echo number_format($harga, 0, ',', '.'); ?></td></tr>
                    <tr><th>Stok</th><td>: <?php echo $stok; ?> buku</td></tr>
                </table>
            </div>
        </div>

        <?php
        //Data Buku 4
        $judul = "HTML & CSS  Web Design";
        $pengarang = "Jon Duckett";
        $penerbit = "wiley";
        $tahun_terbit = 2020;
        $harga = 140000;
        $stok = 4;
        $isbn = "978-111-80081-8-8";
        $kategori = "Web Design";
        $bahasa = "Inggris";
        $halaman = 490;
        $berat = 700;
        ?>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <?php echo $judul; ?>
                    <span class="badge bg-light text-dark"><?php echo $kategori; ?></span>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th width="200">Pengarang</th><td>: <?php echo $pengarang; ?></td></tr>
                    <tr><th>Penerbit</th><td>: <?php echo $penerbit; ?></td></tr>
                    <tr><th>Tahun Terbit</th><td>: <?php echo $tahun_terbit; ?></td></tr>
                    <tr><th>ISBN</th><td>: <?php echo $isbn; ?></td></tr>
                    <tr><th>Kategori</th><td>: <?php echo $kategori; ?></td></tr>
                    <tr><th>Bahasa</th><td>: <?php echo $bahasa; ?></td></tr>
                    <tr><th>Jumlah Halaman</th><td>: <?php echo $halaman; ?></td></tr>
                    <tr><th>Berat</th><td>: <?php echo $berat; ?> gram</td></tr>
                    <tr><th>Harga</th><td>: Rp <?php echo number_format($harga, 0, ',', '.'); ?></td></tr>
                    <tr><th>Stok</th><td>: <?php echo $stok; ?> buku</td></tr>
                </table>
            </div>
        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>