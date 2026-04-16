<!Doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pencarian Buku Advanced</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php
// ================= DATA BUKU =================
$buku_list = [
    ["kode"=>"BK001","judul"=>"Belajar PHP","kategori"=>"Programming","pengarang"=>"Andi","penerbit"=>"Elex","tahun"=>2020,"harga"=>50000,"stok"=>5],
    ["kode"=>"BK002","judul"=>"JavaScript Dasar","kategori"=>"Programming","pengarang"=>"Budi","penerbit"=>"Informatika","tahun"=>2019,"harga"=>60000,"stok"=>0],
    ["kode"=>"BK003","judul"=>"Python untuk Pemula","kategori"=>"Programming","pengarang"=>"Cici","penerbit"=>"Andi","tahun"=>2021,"harga"=>70000,"stok"=>3],
    ["kode"=>"BK004","judul"=>"Desain Grafis","kategori"=>"Design","pengarang"=>"Dedi","penerbit"=>"Elex","tahun"=>2018,"harga"=>55000,"stok"=>2],
    ["kode"=>"BK005","judul"=>"UI UX Design","kategori"=>"Design","pengarang"=>"Eka","penerbit"=>"Informatika","tahun"=>2022,"harga"=>80000,"stok"=>1],
    ["kode"=>"BK006","judul"=>"HTML CSS","kategori"=>"Web Design","pengarang"=>"Fajar","penerbit"=>"Andi","tahun"=>2021,"harga"=>70000,"stok"=>9],
    ["kode"=>"BK007","judul"=>"Laravel Framework","kategori"=>"Programming","pengarang"=>"Gilang","penerbit"=>"Elex","tahun"=>2023,"harga"=>90000,"stok"=>4],
    ["kode"=>"BK008","judul"=>"Database MySQL","kategori"=>"Database","pengarang"=>"Hani","penerbit"=>"Informatika","tahun"=>2017,"harga"=>65000,"stok"=>6],
    ["kode"=>"BK009","judul"=>"Machine Learning","kategori"=>"AI","pengarang"=>"Indra","penerbit"=>"Andi","tahun"=>2022,"harga"=>100000,"stok"=>2],
    ["kode"=>"BK010","judul"=>"Deep Learning","kategori"=>"AI","pengarang"=>"Joko","penerbit"=>"Elex","tahun"=>2023,"harga"=>120000,"stok"=>1],
    ["kode"=>"BK011","judul"=>"Algoritma Dasar","kategori"=>"Programming","pengarang"=>"Kiki","penerbit"=>"Elex","tahun"=>2016,"harga"=>40000,"stok"=>7],
    ["kode"=>"BK012","judul"=>"Struktur Data","kategori"=>"Programming","pengarang"=>"Lina","penerbit"=>"Andi","tahun"=>2018,"harga"=>75000,"stok"=>5],
    ["kode"=>"BK013","judul"=>"Pemrograman Java","kategori"=>"Programming","pengarang"=>"Maya","penerbit"=>"Informatika","tahun"=>2020,"harga"=>85000,"stok"=>3],
    ["kode"=>"BK014","judul"=>"React JS","kategori"=>"Web Design","pengarang"=>"Nina","penerbit"=>"Elex","tahun"=>2021,"harga"=>95000,"stok"=>2],
    ["kode"=>"BK015","judul"=>"Vue JS","kategori"=>"Web Design","pengarang"=>"Oki","penerbit"=>"Andi","tahun"=>2022,"harga"=>90000,"stok"=>4],
    ["kode"=>"BK016","judul"=>"Photoshop Editing","kategori"=>"Design","pengarang"=>"Putri","penerbit"=>"Informatika","tahun"=>2019,"harga"=>70000,"stok"=>6],
    ["kode"=>"BK017","judul"=>"Corel Draw","kategori"=>"Design","pengarang"=>"Qori","penerbit"=>"Elex","tahun"=>2017,"harga"=>65000,"stok"=>5],
    ["kode"=>"BK018","judul"=>"Big Data","kategori"=>"Database","pengarang"=>"Rian","penerbit"=>"Andi","tahun"=>2023,"harga"=>110000,"stok"=>2],
    ["kode"=>"BK019","judul"=>"Cyber Security","kategori"=>"IT","pengarang"=>"Sari","penerbit"=>"Informatika","tahun"=>2022,"harga"=>105000,"stok"=>3],
    ["kode"=>"BK020","judul"=>"Cloud Computing","kategori"=>"IT","pengarang"=>"Tono","penerbit"=>"Elex","tahun"=>2023,"harga"=>115000,"stok"=>1],
];

// ================= GET =================
$keyword = $_GET['keyword'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$min_harga = $_GET['min_harga'] ?? '';
$max_harga = $_GET['max_harga'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$status = $_GET['status'] ?? 'semua';
$sort = $_GET['sort'] ?? 'judul';
$page = max(1, (int)($_GET['page'] ?? 1));

// ================= VALIDASI =================
$errors = [];

if ($min_harga != '' && $max_harga != '' && $min_harga > $max_harga) {
    $errors[] = "Harga minimum tidak boleh lebih besar dari maksimum";
}

if ($tahun != '' && ($tahun < 1900 || $tahun > date("Y"))) {
    $errors[] = "Tahun tidak valid";
}

// ================= FILTER =================
$hasil = array_filter($buku_list, function($buku) use ($keyword,$kategori,$min_harga,$max_harga,$tahun,$status) {
    if ($keyword && stripos($buku['judul'],$keyword) === false && stripos($buku['pengarang'],$keyword) === false) return false;
    if ($kategori && $buku['kategori'] != $kategori) return false;
    if ($min_harga && $buku['harga'] < $min_harga) return false;
    if ($max_harga && $buku['harga'] > $max_harga) return false;
    if ($tahun && $buku['tahun'] != $tahun) return false;
    if ($status == 'tersedia' && $buku['stok'] <= 0) return false;
    if ($status == 'habis' && $buku['stok'] > 0) return false;
    return true;
});

// ================= SORT =================
usort($hasil, fn($a,$b) => $a[$sort] <=> $b[$sort]);

// ================= PAGINATION =================
$perPage = 10;
$total = count($hasil);
$pages = ceil($total / $perPage);
$start = ($page - 1) * $perPage;
$hasil = array_slice($hasil, $start, $perPage);

// ================= HIGHLIGHT =================
function highlight($text,$keyword){
    if (!$keyword) return htmlspecialchars($text);
    return preg_replace("/($keyword)/i","<mark>$1</mark>",htmlspecialchars($text));
}

// ================= EXPORT CSV =================
if (isset($_GET['export'])) {
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=data_buku.csv");

    $output = fopen("php://output","w");
    fputcsv($output, ["Kode","Judul","Kategori","Tahun","Harga","Stok"]);

    foreach ($hasil as $b) {
        fputcsv($output, $b);
    }
    fclose($output);
    exit;
}
?>

<div class="container mt-4">
    <h3>Pencarian Buku Lanjutan</h3>

    <?php if($errors): ?>
        <div class="alert alert-danger">
            <?php foreach($errors as $e) echo "<div>$e</div>"; ?>
        </div>
    <?php endif; ?>

    <form method="GET" class="row g-2">
        <div class="col-md-3">
            <input name="keyword" class="form-control" placeholder="Keyword"
                   value="<?= htmlspecialchars($keyword) ?>">
        </div>

        <div class="col-md-2">
            <select name="kategori" class="form-select">
                <option value="">Semua</option>
                <option value="Programming" <?= $kategori=="Programming"?"selected":"" ?>>Programming</option>
                <option value="Design" <?= $kategori=="Design"?"selected":"" ?>>Design</option>
                <option value="Web Design" <?= $kategori=="Web Design"?"selected":"" ?>>Web Design</option>
            </select>
        </div>

        <div class="col-md-2">
            <input name="min_harga" type="number" class="form-control" placeholder="Min"
                   value="<?= htmlspecialchars($min_harga) ?>">
        </div>

        <div class="col-md-2">
            <input name="max_harga" type="number" class="form-control" placeholder="Max"
                   value="<?= htmlspecialchars($max_harga) ?>">
        </div>

        <div class="col-md-2">
            <input name="tahun" type="number" class="form-control" placeholder="Tahun"
                   value="<?= htmlspecialchars($tahun) ?>">
        </div>

        <div class="col-md-2">
            <select name="sort" class="form-select">
                <option value="judul" <?= $sort=="judul"?"selected":"" ?>>Sort Judul</option>
                <option value="harga" <?= $sort=="harga"?"selected":"" ?>>Sort Harga</option>
                <option value="tahun" <?= $sort=="tahun"?"selected":"" ?>>Sort Tahun</option>
            </select>
        </div>

        <div class="col-12">
            <button class="btn btn-primary">Cari</button>
            <a href="?<?= http_build_query($_GET + ['export'=>1]) ?>" class="btn btn-success">Export CSV</a>
        </div>
    </form>

    <hr>

    <p>Jumlah hasil: <?= $total ?></p>

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Kode</th><th>Judul</th><th>Kategori</th><th>Tahun</th><th>Harga</th><th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($hasil as $b): ?>
            <tr>
                <td><?= $b['kode'] ?></td>
                <td><?= highlight($b['judul'],$keyword) ?></td>
                <td><?= $b['kategori'] ?></td>
                <td><?= $b['tahun'] ?></td>
                <td>Rp <?= number_format($b['harga']) ?></td>
                <td><?= $b['stok'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- PAGINATION -->
    <?php for($i=1;$i<=$pages;$i++): ?>
        <a 
            href="<?= ($i == $page) ? '#' : '?' . http_build_query($_GET + ['page'=>$i]) ?>" 
            class="btn btn-sm <?= ($i == $page) ? 'btn-primary disabled' : 'btn-outline-primary' ?>"
        >
            <?= $i ?>
        </a>
    <?php endfor; ?>

</div>

</body>
</html>