<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perhitungan Diskon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Sistem Perhitungan Diskon Bertingkat</h1>

<?php

    // Data Pembeli & Buku
    $nama_pembeli = "Budi Santoso";
    $judul_buku = "Laravel Advanced";
    $harga_satuan = 150000;
    $jumlah_beli = 4;
    $is_member = true; // true = member, false = non member

    // Subtotal
    $subtotal = $harga_satuan * $jumlah_beli;

    // Persentase Diskon
    if ($jumlah_beli >= 1 && $jumlah_beli <= 2) {
        $persentase_diskon = 0;
    } elseif ($jumlah_beli >= 3 && $jumlah_beli <= 5) {
        $persentase_diskon = 10;
    } elseif ($jumlah_beli >= 6 && $jumlah_beli <= 10) {
        $persentase_diskon = 15;
    } else {
        $persentase_diskon = 20;
    }

    // Diskon
    $diskon = $subtotal * ($persentase_diskon / 100);

    // Total Setelah Diskon Pertama
    $total_setelah_diskon1 = $subtotal - $diskon;

    // Diskon Member
    $diskon_member = 0;
    if ($is_member) {
        $diskon_member = $total_setelah_diskon1 * 0.05;
    }

    // Total Setelah Semua Diskon
    $total_setelah_diskon = $total_setelah_diskon1 - $diskon_member;

    // PPN 11%
    $ppn = $total_setelah_diskon * 0.11;

    // Total Akhir
    $total_akhir = $total_setelah_diskon + $ppn;

    // Total Penghematan
    $total_hemat = $diskon + $diskon_member;
    ?>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Pembelian Buku</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="250">Nama Pembeli</th>
                    <td><?php echo $nama_pembeli; ?></td>
                </tr>

                <tr>
                    <th>Judul Buku</th>
                    <td><?php echo $judul_buku; ?></td>
                </tr>

                <tr>
                    <th>Harga Satuan</th>
                    <td>Rp <?php echo number_format($harga_satuan,0,',','.'); ?></td>
                </tr>

                <tr>
                    <th>Jumlah Buku</th>
                    <td><?php echo $jumlah_beli; ?> buku</td>
                </tr>

                <tr>
                    <th>Status Member</th>
                    <td>
                        <?php if($is_member){ ?>
                            <span class="badge bg-success">Member</span>
                        <?php } else { ?>
                            <span class="badge bg-secondary">Non Member</span>
                        <?php } ?>
                    </td>
                </tr>

            </table>


            <h5 class="mt-4">Perhitungan</h5>

            <table class="table table-striped">

                <tr>
                    <th width="250">Subtotal</th>
                    <td>Rp <?php echo number_format($subtotal,0,',','.'); ?></td>
                </tr>

                <tr>
                    <th>Diskon (<?php echo $persentase_diskon; ?>%)</th>
                    <td>- Rp <?php echo number_format($diskon,0,',','.'); ?></td>
                </tr>

                <?php if($is_member){ ?>
                <tr>
                    <th>Diskon Member (5%)</th>
                    <td>- Rp <?php echo number_format($diskon_member,0,',','.'); ?></td>
                </tr>
                <?php } ?>

                <tr>
                    <th>Total Setelah Diskon</th>
                    <td>Rp <?php echo number_format($total_setelah_diskon,0,',','.'); ?></td>
                </tr>

                <tr>
                    <th>PPN (11%)</th>
                    <td>Rp <?php echo number_format($ppn,0,',','.'); ?></td>
                </tr>

                <tr class="table-success">
                    <th>Total Akhir</th>
                    <td><strong>Rp <?php echo number_format($total_akhir,0,',','.'); ?></strong></td>
                </tr>

                <tr class="table-warning">
                    <th>Total Penghematan</th>
                    <td><strong>Rp <?php echo number_format($total_hemat,0,',','.'); ?></strong></td>
                </tr>
            </table>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>