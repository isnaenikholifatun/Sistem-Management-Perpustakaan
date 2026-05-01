<?php
session_start();
require_once 'config.php';

// --- STATISTIK DASHBOARD ---
$stmtStats = $pdo->query("
    SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'Aktif' THEN 1 ELSE 0 END) as aktif,
        SUM(CASE WHEN status = 'Nonaktif' THEN 1 ELSE 0 END) as nonaktif
    FROM anggota
");
$stats = $stmtStats->fetch();

// --- FILTER & PENCARIAN ---
$search = $_GET['search'] ?? '';
$filterStatus = $_GET['status'] ?? '';
$filterJk = $_GET['jk'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$whereClause = "WHERE 1=1";
$params = [];

if (!empty($search)) {
    $whereClause .= " AND (nama LIKE :search OR email LIKE :search OR telepon LIKE :search)";
    $params['search'] = "%$search%";
}
if (!empty($filterStatus)) {
    $whereClause .= " AND status = :status";
    $params['status'] = $filterStatus;
}
if (!empty($filterJk)) {
    $whereClause .= " AND jenis_kelamin = :jk";
    $params['jk'] = $filterJk;
}

// Hitung total data untuk pagination
$stmtTotal = $pdo->prepare("SELECT COUNT(*) FROM anggota $whereClause");
$stmtTotal->execute($params);
$totalData = $stmtTotal->fetchColumn();
$totalPages = ceil($totalData / $limit);

// Fetch data anggota
$query = "SELECT * FROM anggota $whereClause ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$anggota = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4 mb-5">
    <h2 class="mb-4">Data Anggota Perpustakaan</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div class="row mb-4 text-center">
        <div class="col-md-4"><div class="card bg-primary text-white p-3"><h5>Total: <?= $stats['total'] ?></h5></div></div>
        <div class="col-md-4"><div class="card bg-success text-white p-3"><h5>Aktif: <?= $stats['aktif'] ?? 0 ?></h5></div></div>
        <div class="col-md-4"><div class="card bg-danger text-white p-3"><h5>Nonaktif: <?= $stats['nonaktif'] ?? 0 ?></h5></div></div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama/Email/Telp" value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Aktif" <?= $filterStatus == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Nonaktif" <?= $filterStatus == 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="jk" class="form-select">
                        <option value="">Semua Gender</option>
                        <option value="Laki-laki" <?= $filterJk == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $filterJk == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
                <div class="col-md-3 text-end">
                    <a href="create.php" class="btn btn-success">+ Tambah</a>
                    <a href="export.php?<?= http_build_query($_GET) ?>" class="btn btn-warning">Export Excel</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Foto</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anggota as $row): ?>
                    <tr>
                        <td>
                            <?php if(!empty($row['foto']) && file_exists('uploads/'.$row['foto'])): ?>
                                <img src="uploads/<?= $row['foto'] ?>" width="50" height="50" class="rounded-circle object-fit-cover">
                            <?php else: ?>
                                <div class="bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">NA</div>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['kode_anggota']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td>
                            <small><?= htmlspecialchars($row['email']) ?><br><?= htmlspecialchars($row['telepon']) ?></small>
                        </td>
                        <td>
                            <span class="badge <?= $row['jenis_kelamin'] == 'Laki-laki' ? 'bg-info' : 'bg-pink' ?>" style="<?= $row['jenis_kelamin'] == 'Perempuan' ? 'background-color:#e83e8c' : '' ?>">
                                <?= $row['jenis_kelamin'] ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge <?= $row['status'] == 'Aktif' ? 'bg-success' : 'bg-danger' ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id_anggota'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete.php?id=<?= $row['id_anggota'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus anggota ini?');">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($anggota)): ?>
                        <tr><td colspan="7" class="text-center py-3">Tidak ada data ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if($totalPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($filterStatus) ?>&jk=<?= urlencode($filterJk) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>
</body>
</html>