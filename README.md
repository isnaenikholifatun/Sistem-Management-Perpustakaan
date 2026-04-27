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
![Query1](images/Query1.png)

### 2. Total Inventaris
Menghitung total nilai inventaris (harga × stok).
![Query2](images/Query2.png)

### 3. Rata-rata Harga
Menampilkan rata-rata harga semua buku.
![Query3](images/Query3.png)

### 4. Buku Termahal
Menampilkan buku dengan harga tertinggi.
![Query4](images/Query4.png)

### 5. Stok Terbanyak
Menampilkan buku dengan stok paling banyak.
![Query5](images/Query5.png)

---

## 🔍 Filter dan Pencarian

### 6. Buku Programming < 100000
Menampilkan buku kategori Programming dengan harga kurang dari 100000.
![Query6](images/Query6.jpeg)

### 7. Judul PHP/MySQL
Menampilkan buku yang judulnya mengandung kata PHP atau MySQL.
![Query7](images/Query7.jpeg)

### 8. Tahun 2024
Menampilkan buku yang terbit pada tahun 2024.
![Query8](images/Query8.jpeg)

### 9. Stok 5-10
Menampilkan buku dengan stok antara 5 sampai 10.
![Query9](images/Query9.jpeg)

### 10. Pengarang Budi Raharjo
Menampilkan buku dengan pengarang Budi Raharjo.
![Query10](images/Query10.jpeg)

---

## 📊 Grouping dan Agregasi

### 11. Jumlah per Kategori
Menampilkan jumlah buku dan total stok berdasarkan kategori.
![Query11](images/Query11.jpeg)

### 12. Rata-rata per Kategori
Menampilkan rata-rata harga buku pada setiap kategori.
![Query12](images/Query12.jpeg)

### 13. Inventaris Terbesar
Menampilkan kategori dengan total nilai inventaris terbesar.
![Query13](images/Query13.jpeg)

---

## ✏️ Update Data

### 14. Update Harga
Menaikkan harga buku kategori Programming sebesar 5%.
![Query14](images/Query14.jpeg)

### 15. Update Stok
Menambahkan stok 10 untuk buku yang stoknya kurang dari 5.
![Query15](images/Query15.jpeg)

---

## 📋 Laporan Khusus

### 16. Restocking
Menampilkan buku yang perlu restocking (stok kurang dari 5).
![Query16](images/Query16.jpeg)

### 17. Top 5 Termahal
Menampilkan 5 buku dengan harga tertinggi.
![Query17](images/Query17.png)

## 🏗️ Struktur dan Relasi Database

### 18. Entity Relationship Diagram (ERD)
Hubungan antar tabel dalam database perpustakaan.
![ERD](images/ERD.jpeg)

### 19. Skema Tabel (Structure)
Detail kolom dan tipe data dari masing-masing tabel:
- **Struktur Buku**: ![Struktur Buku](images/struktur_buku.jpeg)
- **Struktur Kategori**: ![Struktur Kategori](images/struktur_kategoribuku.jpeg)
- **Struktur Penerbit**: ![Struktur Penerbit](images/struktur_penerbit.jpeg)
- **Struktur Rak**: ![Struktur Rak](images/struktur_rak.jpeg)

---

## 💾 Data Master (Data Dump)

### 20. Isi Tabel Database
Tampilan data yang telah diinputkan ke dalam sistem:
- **Data Buku**: ![Data Buku](images/data_buku.jpeg)
- **Data Kategori**: ![Data Kategori](images/data_kategori_buku.jpeg)
- **Data Penerbit**: ![Data Penerbit](images/data_penerbit.jpeg)
- **Data Rak**: ![Data Rak](images/data_rak.jpeg)

---

## 🔗 Laporan Join Terpadu

### 21. Hasil Query Join
Laporan lengkap yang menggabungkan tabel buku, kategori, penerbit, dan rak.
![Hasil Query Join](images/hasilqueryjoin.jpeg)