<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5.3">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

<div align="center">
  <h1>📚 Sistem Informasi Perpustakaan</h1>
  <p><strong>Sistem Manajemen Perpustakaan Digital berbasis Web</strong></p>
  <p>
    Aplikasi manajemen perpustakaan modern untuk mengelola data buku, anggota, 
    dan transaksi peminjaman secara efisien dengan fitur notifikasi keterlambatan 
    dan pelaporan yang lengkap.
  </p>
</div>

---

## 📋 Daftar Isi

- [Deskripsi Project](#-deskripsi-project)
- [Fitur Lengkap](#-fitur-lengkap)
- [Screenshots](#-screenshots)
- [Tech Stack](#️-tech-stack)
- [Struktur Database](#-struktur-database)
- [Instalasi Step-by-Step](#-instalasi-step-by-step)
- [Cara Penggunaan](#-cara-penggunaan)
- [Author](#-author)

---

## 📖 Deskripsi Project

**Sistem Informasi Perpustakaan** adalah aplikasi web berbasis **Laravel 13** yang dirancang untuk mengelola operasional perpustakaan secara digital. Aplikasi ini mencakup manajemen koleksi buku, data anggota, transaksi peminjaman dan pengembalian, notifikasi keterlambatan, serta pelaporan yang lengkap.

Dibangun dengan antarmuka yang **modern, responsif, dan user-friendly** menggunakan Bootstrap 5.3 dengan desain sistem yang konsisten di seluruh halaman.

### Tujuan:

- ✅ Mempermudah pencatatan dan pelacakan peminjaman buku
- ✅ Menyediakan dashboard informasi real-time tentang status perpustakaan
- ✅ Mendeteksi dan menampilkan notifikasi keterlambatan secara otomatis
- ✅ Menyediakan riwayat peminjaman lengkap per anggota
- ✅ Menghasilkan laporan transaksi dalam format PDF

---

## ✨ Fitur Lengkap

### 📊 Dashboard

- [x] Kartu statistik utama (Total Buku, Anggota Aktif, Sedang Dipinjam, dll.)
- [x] Grafik transaksi 6 bulan terakhir (Chart.js)
- [x] Grafik donat 5 buku terpopuler
- [x] **Widget Buku Terlambat** dengan daftar anggota dan denda
- [x] Daftar anggota teraktif
- [x] Transaksi terbaru

### 📚 Manajemen Buku

- [x] CRUD lengkap (Create, Read, Update, Delete)
- [x] Pencarian dan filter berdasarkan kata kunci & tahun terbit
- [x] Kategori buku yang dapat dipilih
- [x] Bulk delete (hapus massal)
- [x] Export data ke CSV
- [x] Detail buku dengan riwayat peminjaman
- [x] Rekomendasi buku serupa berdasarkan kategori

### 👥 Manajemen Anggota

- [x] CRUD lengkap (Create, Read, Update, Delete)
- [x] Pencarian dan filter berdasarkan status
- [x] Export data ke Excel
- [x] Kode anggota otomatis
- [x] **Riwayat peminjaman lengkap** per anggota
- [x] Statistik peminjaman anggota (Total Pinjam, Denda, dll.)
- [x] Filter riwayat berdasarkan status transaksi

### 🔄 Transaksi Peminjaman

- [x] Peminjaman buku dengan pemilihan anggota & buku
- [x] Tanggal kembali otomatis (H+7)
- [x] Validasi stok buku sebelum peminjaman
- [x] Pengembalian buku dengan konfirmasi SweetAlert2
- [x] Perhitungan denda otomatis (Rp 5.000/hari)
- [x] **Notifikasi keterlambatan** di detail transaksi
- [x] Badge "Terlambat X hari" di tabel transaksi

### 📈 Laporan

- [x] Filter laporan berdasarkan tanggal, status, dan anggota
- [x] Ringkasan statistik (Total, Dipinjam, Dikembalikan, Denda)
- [x] Export laporan ke **PDF** (DomPDF)

### 🔐 Autentikasi & Keamanan

- [x] Login & Register
- [x] Reset password
- [x] Proteksi route dengan middleware auth
- [x] Manajemen profil pengguna

### 🎨 Desain & UX

- [x] Antarmuka modern dengan desain sistem yang konsisten
- [x] Navigasi sticky dengan glassmorphism effect
- [x] Breadcrumb di setiap halaman
- [x] Kartu statistik dengan ikon gradien
- [x] Tabel modern dengan hover effect
- [x] **Fully responsive** (mobile, tablet, desktop)
- [x] Font Inter yang modern dan mudah dibaca
- [x] Animasi dan transisi halus
- [x] Auto-dismiss flash messages
- [x] SweetAlert2 untuk konfirmasi tindakan


---

## 🛠️ Tech Stack

### Backend

| Teknologi | Keterangan |
|-----------|------------|
| **Laravel 13** | Framework PHP modern dengan arsitektur MVC |
| **PHP 8.3+** | Bahasa pemrograman backend |
| **MySQL** | Database relasional |
| **Eloquent ORM** | Database abstraction layer |

### Frontend

| Teknologi | Keterangan |
|-----------|------------|
| **Bootstrap 5.3** | CSS framework responsive |
| **Inter Font** | Typeface modern dari Google Fonts |
| **Bootstrap Icons** | Icon set terintegrasi |
| **Chart.js** | Library grafik interaktif |
| **SweetAlert2** | Dialog dan notifikasi modern |
| **Flatpickr** | Date picker yang ringan |

### Package & Library

| Package | Fungsi |
|---------|--------|
| **Laravel Breeze** | Autentikasi scaffolding |
| **Barryvdh DomPDF** | Export laporan ke PDF |
| **Maatwebsite Excel** | Export data ke Excel/CSV |
| **Carbon** | Manipulasi tanggal |

---

## 🗄️ Struktur Database

### Tabel Users

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint, PK | Primary key |
| `name` | varchar(255) | Nama pengguna |
| `email` | varchar(255), unique | Email login |
| `password` | varchar(255) | Password (bcrypt) |
| `email_verified_at` | timestamp, nullable | Verifikasi email |

### Tabel Buku

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint, PK | Primary key |
| `kode_buku` | varchar(20), unique | Kode unik buku |
| `judul` | varchar(200) | Judul buku |
| `kategori` | enum | Programming, Database, Web Design, Networking, Data Science |
| `pengarang` | varchar(100) | Nama pengarang |
| `penerbit` | varchar(100) | Nama penerbit |
| `tahun_terbit` | year | Tahun terbit |
| `isbn` | varchar(20), nullable | Nomor ISBN |
| `harga` | decimal(10,2) | Harga buku |
| `stok` | integer | Jumlah stok |
| `deskripsi` | text, nullable | Deskripsi buku |
| `bahasa` | varchar(20) | Bahasa buku |

### Tabel Anggota

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint, PK | Primary key |
| `kode_anggota` | varchar(20), unique | Kode unik anggota |
| `nama` | varchar(100) | Nama lengkap |
| `email` | varchar(100), unique | Alamat email |
| `telepon` | varchar(15) | Nomor telepon |
| `alamat` | text | Alamat rumah |
| `tanggal_lahir` | date | Tanggal lahir |
| `jenis_kelamin` | enum | Laki-laki / Perempuan |
| `pekerjaan` | varchar(50), nullable | Pekerjaan |
| `tanggal_daftar` | date | Tanggal pendaftaran |
| `status` | enum | Aktif / Nonaktif |

### Tabel Transaksis

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint, PK | Primary key |
| `kode_transaksi` | varchar(20), unique | Kode unik transaksi |
| `anggota_id` | bigint, FK → anggota | ID anggota |
| `buku_id` | bigint, FK → buku | ID buku |
| `tanggal_pinjam` | date | Tanggal peminjaman |
| `tanggal_kembali` | date | Batas tanggal kembali |
| `tanggal_dikembalikan` | date, nullable | Tanggal actual kembali |
| `status` | enum | Dipinjam / Dikembalikan |
| `denda` | integer | Total denda (Rp) |
| `keterangan` | text, nullable | Catatan transaksi |

---

## 🚀 Instalasi Step-by-Step

### Prasyarat

Pastikan sistem Anda telah terinstall:
- **PHP** ≥ 8.3
- **Composer** (dependency manager PHP)
- **MySQL** / MariaDB
- **Node.js** & **NPM** (untuk assets)
- **Git** (opsional)

### Langkah Instalasi

#### 1. Clone Repository

```bash
git clone https://github.com/username/sistem-perpustakaan.git
cd sistem-perpustakaan
```

Atau download dan extract file ZIP ke direktori web server (misal: `C:\xampp\htdocs\Pemweb\final`).

#### 2. Install Dependencies PHP

```bash
composer install
```

#### 3. Konfigurasi Environment

```bash
# Salin file environment
cp .env.example .env
```

> **Catatan:** Jika tidak ada file `.env.example`, buat file `.env` baru dan isi dengan konfigurasi berikut:
>
> ```env
> APP_NAME="Sistem Perpustakaan"
> APP_ENV=local
> APP_DEBUG=true
> APP_URL=http://localhost:8000
>
> DB_CONNECTION=mysql
> DB_HOST=127.0.0.1
> DB_PORT=3306
> DB_DATABASE=db_perpustakaan
> DB_USERNAME=root
> DB_PASSWORD=
> ```

#### 4. Generate Application Key

```bash
php artisan key:generate
```

#### 5. Buat Database

Buat database MySQL baru:

```sql
CREATE DATABASE db_perpustakaan;
```

Kemudian sesuaikan konfigurasi database di file `.env` sesuai dengan environment Anda.

#### 6. Jalankan Migration & Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan:
- Membuat semua tabel yang diperlukan
- Mengisi data awal (buku, anggota, kategori)

#### 7. Install & Build Frontend Assets (Opsional)

```bash
npm install
npm run build
```

#### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

#### 9. Login

Buat akun pengguna melalui halaman Register, atau gunakan data yang sudah di-seed (jika ada).

---

## 💡 Cara Penggunaan

### Alur Kerja Umum

1. **Login** — Masuk menggunakan email dan password
2. **Kelola Buku** — Tambah data buku baru melalui menu Buku
3. **Kelola Anggota** — Daftarkan anggota baru melalui menu Anggota
4. **Transaksi Peminjaman** — Pilih anggota & buku untuk membuat transaksi
5. **Pantau Dashboard** — Lihat statistik, buku terlambat, dan grafik
6. **Pengembalian** — Klik tombol "Proses Pengembalian" di detail transaksi
7. **Laporan** — Filter dan export laporan ke PDF

### Fitur Unggulan

| Fitur | Cara Akses |
|-------|------------|
| **Dashboard** | Navigasi → Dashboard |
| **Widget Buku Terlambat** | Muncul otomatis di Dashboard jika ada yang terlambat |
| **Riwayat Anggota** | Klik detail anggota → Scroll ke Riwayat Peminjaman |
| **Filter Status Riwayat** | Di halaman detail anggota → dropdown filter status |
| **Export PDF** | Laporan → Export PDF |
| **Pencarian Global** | Search bar di navbar (pojok kanan atas) |

---

## 👨‍💻 Author

<div align="center">
  <table>
    <tr>
      <td><strong>Nama</strong></td>
      <td>Lukman Shodik</td>
    </tr>
    <tr>
      <td><strong>NIM</strong></td>
      <td>603240655</td>
    </tr>
    <tr>
      <td><strong>Mata Kuliah</strong></td>
      <td>Pemrograman Web 2</td>
    </tr>
    <tr>
      <td><strong>Universitas</strong></td>
      <td>UIN K.H. Abdurrahman Wahid Pekalongan</td>
    </tr>
    <tr>
      <td><strong>Email</strong></td>
      <td>lukman.shodik99@gmail.com</td>
    </tr>
  </table>
</div>

---

<div align="center">
  <p>
    <strong>Sistem Informasi Perpustakaan</strong><br>
    Dibangun dengan ❤️ menggunakan Laravel 12
  </p>
  <p>
    <sub>© 2026 — All Rights Reserved</sub>
  </p>
</div>
