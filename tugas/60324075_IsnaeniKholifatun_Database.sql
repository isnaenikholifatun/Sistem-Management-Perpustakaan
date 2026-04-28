-- =========================================
-- DATABASE PERPUSTAKAAN
-- Tugas 2 Desain Database Lengkap

-- =========================
-- 1. CREATE DATABASE
-- =========================
CREATE DATABASE perpustakaan_db;
USE perpustakaan_db;

-- =========================
-- 2. CREATE TABLE
-- =========================

-- Tabel Kategori Buku
CREATE TABLE kategori_buku (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Tabel Penerbit
CREATE TABLE penerbit (
    id_penerbit INT AUTO_INCREMENT PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(15),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Tabel Rak (Bonus)
CREATE TABLE rak (
    id_rak INT AUTO_INCREMENT PRIMARY KEY,
    nama_rak VARCHAR(50),
    lokasi VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Tabel Buku
CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(100),
    penulis VARCHAR(100),
    tahun_terbit INT,
    id_kategori INT,
    id_penerbit INT,
    id_rak INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,

    FOREIGN KEY (id_kategori) REFERENCES kategori_buku(id_kategori),
    FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit),
    FOREIGN KEY (id_rak) REFERENCES rak(id_rak)
);

-- =========================
-- 3. INSERT DATA
-- =========================

-- Kategori
INSERT INTO kategori_buku (nama_kategori, deskripsi) VALUES
('Novel', 'Buku cerita fiksi'),
('Pendidikan', 'Buku pelajaran'),
('Teknologi', 'Buku IT dan komputer'),
('Sejarah', 'Buku sejarah dunia'),
('Agama', 'Buku keagamaan');

-- Penerbit
INSERT INTO penerbit (nama_penerbit, alamat, telepon, email) VALUES
('Gramedia', 'Jakarta', '0811111111', 'gramedia@email.com'),
('Erlangga', 'Jakarta', '0822222222', 'erlangga@email.com'),
('Informatika', 'Bandung', '0833333333', 'info@email.com'),
('Mizan', 'Bandung', '0844444444', 'mizan@email.com'),
('Andi Offset', 'Yogyakarta', '0855555555', 'andi@email.com');

-- Rak
INSERT INTO rak (nama_rak, lokasi) VALUES
('Rak A', 'Lantai 1'),
('Rak B', 'Lantai 1'),
('Rak C', 'Lantai 2'),
('Rak D', 'Lantai 2'),
('Rak E', 'Lantai 3');

-- Buku (15 data)
INSERT INTO buku (judul, penulis, tahun_terbit, id_kategori, id_penerbit, id_rak) VALUES
('Laskar Pelangi', 'Andrea Hirata', 2005, 1, 1, 1),
('Bumi Manusia', 'Pramoedya', 1980, 1, 2, 2),
('Algoritma Dasar', 'Abdul Kadir', 2010, 3, 3, 3),
('Sejarah Dunia', 'Herodotus', 2000, 4, 2, 4),
('Fiqih Islam', 'Sulaiman', 2015, 5, 4, 5),
('Matematika SMA', 'Sutrisno', 2018, 2, 2, 1),
('Pemrograman Java', 'Deitel', 2012, 3, 3, 2),
('Sejarah Indonesia', 'Sartono', 2001, 4, 1, 3),
('Tafsir Al-Quran', 'Quraish Shihab', 2016, 5, 4, 4),
('Fisika Dasar', 'Halliday', 2011, 2, 2, 5),
('Negeri 5 Menara', 'Ahmad Fuadi', 2009, 1, 1, 1),
('Basis Data', 'Elmasri', 2013, 3, 3, 2),
('Kimia SMA', 'Sutrisno', 2017, 2, 2, 3),
('Sejarah Eropa', 'John Hirst', 2005, 4, 5, 4),
('Hadis Shahih', 'Bukhari', 1999, 5, 4, 5);

-- =========================
-- 4. QUERY
-- =========================

-- JOIN Buku + Kategori + Penerbit
SELECT b.judul, b.penulis, k.nama_kategori, p.nama_penerbit
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;

-- Jumlah buku per kategori
SELECT k.nama_kategori, COUNT(b.id_buku) AS jumlah_buku
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
GROUP BY k.nama_kategori;

-- Jumlah buku per penerbit
SELECT p.nama_penerbit, COUNT(b.id_buku) AS jumlah_buku
FROM buku b
JOIN penerbit p ON b.id_penerbit = p.id_penerbit
GROUP BY p.nama_penerbit;

-- Detail lengkap buku
SELECT b.*, k.nama_kategori, p.nama_penerbit, r.nama_rak
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit
JOIN rak r ON b.id_rak = r.id_rak;

-- =========================
-- 5. STORED PROCEDURE
-- =========================

DELIMITER $$

CREATE PROCEDURE tambah_buku(
    IN p_judul VARCHAR(100),
    IN p_penulis VARCHAR(100),
    IN p_tahun INT,
    IN p_kategori INT,
    IN p_penerbit INT,
    IN p_rak INT
)
BEGIN
    INSERT INTO buku (judul, penulis, tahun_terbit, id_kategori, id_penerbit, id_rak)
    VALUES (p_judul, p_penulis, p_tahun, p_kategori, p_penerbit, p_rak);
END $$

DELIMITER ;