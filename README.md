# Tugas Database - Query SQL

## 👤 Identitas Diri
- Nama  : Isnaeni Kholifatun
- NIM   : 60324075
- Kelas : B
- Mata Kuliah : Pemograman WEB 2
- Prodi : Informatika

---

## Deskripsi
Tugas ini bertujuan untuk melakukan eksplorasi database perpustakaan menggunakan query SQL, meliputi statistik, filtering, agregasi, update data, dan pembuatan laporan.

---

## 📊 Statistik Buku

### 1. Total Buku
Menampilkan jumlah seluruh buku dalam tabel.

```sql
SELECT COUNT(*) AS total_buku FROM buku;
```
![Query1](images/Query1.png)

### 2. Total Inventaris
Menghitung total nilai inventaris (harga × stok).
```sql
SELECT SUM(harga * stok) AS total_inventaris FROM buku;
```
![Query2](images/Query2.png)

### 3. Rata-rata Harga
Menampilkan rata-rata harga semua buku.
```sql
SELECT AVG(harga) AS rata_rata_harga FROM buku;
```
![Query3](images/Query3.png)

### 4. Buku Termahal
Menampilkan buku dengan harga tertinggi.
```sql
SELECT judul, harga 
FROM buku 
ORDER BY harga DESC 
LIMIT 1;
```
![Query4](images/Query4.png)

### 5. Stok Terbanyak
Menampilkan buku dengan stok paling banyak.
```sql
SELECT judul, stok 
FROM buku 
ORDER BY stok DESC 
LIMIT 1;
```
![Query5](images/Query5.png)

---

## 🔍 Filter dan Pencarian

### 6. Buku Programming < 100000
Menampilkan buku kategori Programming dengan harga kurang dari 100000.
```sql
SELECT * 
FROM buku 
WHERE kategori = 'Programming' AND harga < 100000;
```
![Query6](images/Query6.jpeg)

### 7. Judul PHP/MySQL
Menampilkan buku yang judulnya mengandung kata PHP atau MySQL.
```sql
SELECT * 
FROM buku 
WHERE judul LIKE '%PHP%' OR judul LIKE '%MySQL%';
```
![Query7](images/Query7.jpeg)

### 8. Tahun 2024
Menampilkan buku yang terbit pada tahun 2024.
```sql
SELECT * 
FROM buku 
WHERE tahun_terbit = 2024;
```
![Query8](images/Query8.jpeg)

### 9. Stok 5-10
Menampilkan buku dengan stok antara 5 sampai 10.
```sql
SELECT * 
FROM buku 
WHERE stok BETWEEN 5 AND 10;
```
![Query9](images/Query9.jpeg)

### 10. Pengarang Budi Raharjo
Menampilkan buku dengan pengarang Budi Raharjo.
```sql
SELECT * 
FROM buku 
WHERE pengarang = 'Budi Raharjo';
```
![Query10](images/Query10.jpeg)

---

## 📊 Grouping dan Agregasi

### 11. Jumlah per Kategori
Menampilkan jumlah buku dan total stok berdasarkan kategori.
```sql
SELECT kategori, COUNT(*) AS jumlah_buku, SUM(stok) AS total_stok
FROM buku
GROUP BY kategori;
```
![Query11](images/Query11.jpeg)

### 12. Rata-rata per Kategori
Menampilkan rata-rata harga buku pada setiap kategori.
```sql
SELECT kategori, AVG(harga) AS rata_rata_harga
FROM buku
GROUP BY kategori;
```
![Query12](images/Query12.jpeg)

### 13. Inventaris Terbesar
Menampilkan kategori dengan total nilai inventaris terbesar.
```sql
SELECT kategori, SUM(harga * stok) AS total_inventaris
FROM buku
GROUP BY kategori
ORDER BY total_inventaris DESC
LIMIT 1;
```
![Query13](images/Query13.jpeg)

---

## ✏️ Update Data

### 14. Update Harga
Menaikkan harga buku kategori Programming sebesar 5%.
```sql
UPDATE buku
SET harga = harga * 1.05
WHERE kategori = 'Programming';
```
![Query14](images/Query14.jpeg)

### 15. Update Stok
Menambahkan stok 10 untuk buku yang stoknya kurang dari 5.
```sql
UPDATE buku
SET stok = stok + 10
WHERE stok < 5;
```
![Query15](images/Query15.jpeg)

---

## 📋 Laporan Khusus

### 16. Restocking
Menampilkan buku yang perlu restocking (stok kurang dari 5).
```sql
SELECT * 
FROM buku 
WHERE stok < 5;
```
![Query16](images/Query16.jpeg)

### 17. Top 5 Termahal
Menampilkan 5 buku dengan harga tertinggi.
```sql
SELECT judul, harga 
FROM buku 
ORDER BY harga DESC 
LIMIT 5;
```
![Query17](images/Query17.png)

## 🏗️ Struktur dan Relasi Database

### 18. Entity Relationship Diagram (ERD)
Hubungan antar tabel dalam database perpustakaan.
![ERD](images/ERD.png)

### 19. Skema Tabel (Structure)
Detail kolom dan tipe data dari masing-masing tabel:
- **Struktur Buku**: ![Struktur Buku](images/struktur_buku.png)
- **Struktur Kategori Buku**: ![Struktur Kategori](images/struktur_kategoribuku.png)
- **Struktur Penerbit**: ![Struktur Penerbit](images/struktur_penerbit.png)
- **Struktur Rak**: ![Struktur Rak](images/struktur_rak.png)

---

## 💾 Data Master (Data Dump)

### 20. Isi Tabel Database
Tampilan data yang telah diinputkan ke dalam sistem:
- **Data Buku**: ![Data Buku](images/data_buku.png)
- **Data Kategori Buku**: ![Data Kategori](images/data_kategoribuku.png)
- **Data Penerbit**: ![Data Penerbit](images/data_penerbit.png)
- **Data Rak**: ![Data Rak](images/data_rak.png)

---

## 🔗 Laporan Join Terpadu

### 21. Hasil Query Join 
Laporan lengkap yang menggabungkan tabel buku, kategori, penerbit, dan rak.
- **Query join** :![Query join](images/query_join.png)
- **Jumlah buku perkategori** :![Jumlah buku perkategori](images/jumlah_buku_perkategori.png)
- **Jumlah buku perpenerbit** :![Jumlah buku perpenerbit](images/jumlah_buku_perpenerbit.png)
- **Detail lengkap buku** :![Detail lengkap buku](images/detail_lengkapbuku.png)