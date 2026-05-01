<?php
require_once 'config.php';

// Ambil parameter filter yang sama dengan index.php
$search = $_GET['search'] ?? '';
$filterStatus = $_GET['status'] ?? '';
$filterJk = $_GET['jk'] ?? '';

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

$query = "SELECT kode_anggota, nama, email, telepon, jenis_kelamin, tanggal_lahir, pekerjaan, alamat, tanggal_daftar, status FROM anggota $whereClause ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$data = $stmt->fetchAll();

// Set header Excel/CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Laporan_Anggota_' . date('Ymd_His') . '.csv');

// Buka output stream
$output = fopen('php://output', 'w');

// Header Tabel CSV
fputcsv($output, ['Kode Anggota', 'Nama', 'Email', 'Telepon', 'Jenis Kelamin', 'Tanggal Lahir', 'Pekerjaan', 'Alamat', 'Tanggal Daftar', 'Status']);

// Loop data ke dalam CSV
foreach ($data as $row) {
    fputcsv($output, $row);
}

fclose($output);
exit;
?>