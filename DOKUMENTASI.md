# DOKUMENTASI SISTEM — Toko Komputer

Web Aplikasi Penjualan Berbasis CodeIgniter 3

---

## DAFTAR ISI

1. [Sekilas Sistem](#1-sekilas-sistem)
2. [Fitur & Pemetaan Ketentuan UAS](#2-fitur--pemetaan-ketentuan-uas)
3. [Struktur Folder](#3-struktur-folder)
4. [Alur Kerja Sistem](#4-alur-kerja-sistem)
5. [Struktur Database & Relasi](#5-struktur-database--relasi)
6. [Panduan Screenshot untuk Laporan](#6-panduan-screenshot-untuk-laporan)
7. [Cara Menjalankan](#7-cara-menjalankan)

---

## 1. Sekilas Sistem

**Toko Komputer** adalah sistem informasi penjualan berbasis web yang dibangun menggunakan:

| Komponen | Teknologi |
|----------|-----------|
| Framework | CodeIgniter 3 (MVC) |
| Bahasa | PHP 8.x (≥5.3.7) |
| Database | MySQL / MariaDB (InnoDB) |
| Template | Bootstrap 4.6.2 + FontAwesome 5 |
| Chart | Chart.js 4 |
| PDF | Dompdf 2 |
| Excel | PhpSpreadsheet 1 |

### Aktor Sistem

| Role | Hak Akses |
|------|-----------|
| **Admin** | Full akses — CRUD semua data, kelola users, laporan |
| **Petugas** | Terbatas — hanya lihat dashboard, produk, penjualan, laporan |

---

## 2. Fitur & Pemetaan Ketentuan UAS

| No | Ketentuan UAS | Implementasi | Letak File |
|----|--------------|--------------|------------|
| 1 | **Login Multiuser** (Admin & Petugas) | Login dengan role `admin` / `petugas`. Session `logged_in` + `role`. | `controllers/Auth.php` |
| 2 | **Dashboard** | 4 kartu statistik + grafik Chart.js + tabel penjualan terbaru | `controllers/Dashboard.php` + `views/dashboard/v_dashboard.php` |
| 3 | **CRUD seluruh master data** | Kategori (C,R,U,D), Produk (C,R,U,D), Users (C,R,U,D), Penjualan (C,R,D) | Masing-masing controller & view |
| 4 | **Relasi Foreign Key** | 4 FK: `produk→kategori`, `penjualan→users`, `detail_penjualan→penjualan`, `detail_penjualan→produk` | `database.sql` |
| 5 | **Upload gambar** | Produk — upload ke `assets/uploads/produk/`, format jpg/jpeg/png, max 2MB | `controllers/Produk.php:25-42` |
| 6 | **Pencarian (Search)** | Pencarian produk (by nama), penjualan (by nota) | `controllers/Produk.php:45`, `controllers/Penjualan.php:37` |
| 7 | **Filter data** | Filter produk by kategori, filter penjualan by tanggal | `controllers/Produk.php:46`, `controllers/Penjualan.php:40` |
| 8 | **Pagination** | Produk — 5 data per halaman | `controllers/Produk.php:48-69` |
| 9 | **Validasi Form** | CI3 `form_validation` — required, numeric, min_length, is_unique | Semua method `create()` & `edit()` |
| 10 | **Flash Message** | `set_flashdata('pesan', ...)` sukses, `('error', ...)` gagal | Semua controller |
| 11 | **Export PDF** | Download PDF produk & penjualan via Dompdf | `controllers/Laporan.php:34-67` |
| 12 | **Export Excel** | Download XLSX produk & penjualan via PhpSpreadsheet | `controllers/Laporan.php:71-147` |
| 13 | **Cetak Laporan** | Halaman cetak dengan tombol print (`window.print()`) | `controllers/Laporan.php:151-165` + `views/laporan/cetak_*.php` |
| 14 | **Chart.js di Dashboard** | Grafik batang penjualan 6 bulan + grafik donat produk per kategori | `views/dashboard/v_dashboard.php` (script Chart.js) |
| 15 | **Hak akses based role** | `_is_admin()` guard di controller; sidebar berbeda untuk petugas | Semua controller |
| 16 | **URL tanpa index.php** | `.htaccess` mod_rewrite | `.htaccess` |
| 17 | **Template Bootstrap** | Bootstrap 4.6.2 via CDN + sidebar custom #1a237e | Semua view |
| 18 | **MVC CodeIgniter 3** | Controller di `controllers/`, Model di `models/`, View di `views/` | Struktur folder |
| 19 | **Password hash** | `password_hash(PASSWORD_DEFAULT)` saat register; `password_verify()` saat login | `controllers/Auth.php:39`, `controllers/Users.php:47,86` |
| 20 | **Database MySQL (3NF)** | 5 tabel, tidak ada redundansi, semua FK on update cascade | `database.sql` |

---

## 3. Struktur Folder

```
UAS-WEB2/
├── index.php                 # Front controller CI3
├── .htaccess                 # Rewrite rule (URL tanpa index.php)
├── composer.json             # Dependency: dompdf, phpspreadsheet
├── database.sql              # Export database (struktur + data)
├── application/
│   ├── config/
│   │   ├── config.php        # Base URL, session, dll
│   │   ├── database.php      # Koneksi MySQL
│   │   ├── routes.php        # Routing default
│   │   └── autoload.php      # Library/helper autoload
│   ├── controllers/
│   │   ├── Auth.php          # Login, logout, proses login
│   │   ├── Dashboard.php     # Dashboard + data chart
│   │   ├── Kategori.php      # CRUD kategori
│   │   ├── Produk.php        # CRUD produk + upload gambar
│   │   ├── Penjualan.php     # Transaksi penjualan
│   │   ├── Users.php         # CRUD users (admin only)
│   │   ├── Laporan.php       # PDF, Excel, Cetak
│   │   └── Welcome.php       # Landing page
│   ├── models/
│   │   ├── M_auth.php        # Check login (by username)
│   │   ├── M_kategori.php    # Query kategori
│   │   └── M_produk.php      # Query produk (join kategori)
│   └── views/
│       ├── auth/
│       │   └── v_login.php   # Halaman login
│       ├── dashboard/
│       │   └── v_dashboard.php
│       ├── kategori/
│       │   ├── index.php     # Daftar kategori
│       │   └── form.php      # Tambah/edit kategori
│       ├── produk/
│       │   ├── index.php     # Daftar produk + search + filter + pagination
│       │   └── form.php      # Tambah/edit produk + upload gambar
│       ├── penjualan/
│       │   ├── index.php     # Daftar transaksi
│       │   ├── create.php    # Form transaksi baru
│       │   └── detail.php    # Detail transaksi
│       ├── users/
│       │   ├── v_list.php    # Daftar users
│       │   └── v_form.php    # Tambah/edit users
│       ├── laporan/
│       │   ├── index.php     # Menu laporan
│       │   ├── pdf_produk.php
│       │   ├── pdf_penjualan.php
│       │   ├── cetak_produk.php
│       │   └── cetak_penjualan.php
│       └── landing/
│           └── v_landing.php # Halaman awal (welcome)
├── assets/
│   └── uploads/
│       └── produk/           # Gambar produk
│           ├── default.jpg
│           └── produk_*.jpg
├── system/                   # Core CodeIgniter 3 (tidak dimodifikasi)
└── vendor/                   # Composer dependencies
    ├── autoload.php
    ├── dompdf/
    └── phpoffice/
```

---

## 4. Alur Kerja Sistem

### 4.1 Autentikasi

```
User → [GET] /auth → form login
    → [POST] /auth/login_process
        → username & password valid? → redirect /dashboard
        → username & password invalid? → flash error + redirect /auth
    → [GET] /auth/logout → destroy session → redirect /auth
```

### 4.2 CRUD Produk (contoh alur lengkap)

```
LIST:   [GET] /produk
            → Produk::index()
                → M_produk::get_produk_with_kategori(limit, start, search, filter)
                → load view produk/index

CREATE: [GET] /produk/create
            → Produk::create() → form validation fail → load view produk/form
        [POST] /produk/create
            → Produk::create() → form validation pass
                → _upload_gambar() (optional)
                → M_produk::insert_produk($data)
                → flash success → redirect /produk

EDIT:   [GET] /produk/edit/1
            → Produk::edit($id) → load view produk/form (dengan data)
        [POST] /produk/edit/1
            → Produk::edit($id) → update database → flash success → redirect

DELETE: [GET] /produk/delete/1
            → Produk::delete($id) → hapus data + file gambar → flash success → redirect
```

### 4.3 Transaksi Penjualan

```
1. Admin/petugas buka /penjualan/create
2. Pilih produk (centang), isi jumlah beli
3. Submit → POST /penjualan/store
4. Sistem:
   a. Generate nomor nota (NOTA-YYYYMMDD-XXXX)
   b. Cek stok setiap produk
   c. Kurangi stok
   d. Insert header penjualan
   e. Insert detail_penjualan
   f. Redirect ke /penjualan/detail/{id}
```

### 4.4 Laporan

```
Menu /laporan → pilih jenis laporan:

┌─────────────────┬────────────────────┬─────────────────────┐
│                 │   Produk           │   Penjualan         │
├─────────────────┼────────────────────┼─────────────────────┤
│ Cetak (Print)   │ /laporan/cetak_produk → window.print()   │
│ PDF (Download)  │ /laporan/produk_pdf → Dompdf::stream()   │
│ Excel (Download)│ /laporan/produk_excel → Xlsx writer      │
└─────────────────┴────────────────────┴─────────────────────┘
```

---

## 5. Struktur Database & Relasi

### 5.1 Entity Relationship Diagram (textual)

```
kategori ──< produk ──< detail_penjualan >── penjualan >── users
                                                  
Legenda: ──< = one-to-many, >── = many-to-one
```

### 5.2 Tabel & Relasi

| Tabel | PK | FK | Kolom |
|-------|----|----|-------|
| **kategori** | `id_kategori` | - | `nama_kategori` |
| **produk** | `id_produk` | `id_kategori` → kategori(`id_kategori`) ON UPDATE CASCADE | `nama_produk`, `harga_jual`, `stok`, `gambar` |
| **users** | `id_user` | - | `username` (UNIQUE), `password` (hash), `nama_lengkap`, `role` (ENUM: admin/petugas) |
| **penjualan** | `id_penjualan` | `id_user` → users(`id_user`) ON UPDATE CASCADE | `nota_transaksi` (UNIQUE), `tanggal_transaksi`, `total_bayar` |
| **detail_penjualan** | `id_detail` | `id_penjualan` → penjualan(`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE, `id_produk` → produk(`id_produk`) ON UPDATE CASCADE | `jumlah_beli`, `subtotal` |

### 5.3 Normalisasi (3NF)

| Bentuk Normal | Status | Penjelasan |
|---------------|--------|------------|
| **1NF** | ✅ | Semua kolom atomic. Setiap tabel punya Primary Key. |
| **2NF** | ✅ | Tidak ada partial dependency. Kolom non-key bergantung penuh pada PK. |
| **3NF** | ✅ | Tidak ada transitive dependency. Contoh: `nama_kategori` tidak ada di `produk` karena sudah di-relasi-kan via FK. |

> **Catatan**: `total_bayar` di tabel `penjualan` adalah derived field (bisa dihitung dari SUM subtotal). Ini adalah denormalisasi ringan yang disengaja untuk optimasi query dan merupakan praktik umum.

---

## 6. Panduan Screenshot untuk Laporan

Berikut daftar halaman yang perlu di-screenshot untuk menunjukkan setiap ketentuan terpenuhi:

| No | Halaman | URL | Yang Ditunjukkan |
|----|---------|-----|------------------|
| 1 | Login | `http://localhost/UAS-WEB2/auth` | Form login, validasi role |
| 2 | Dashboard | `http://localhost/UAS-WEB2/dashboard` | Kartu statistik + **Chart.js** (grafik batang + donat) |
| 3 | Daftar Produk | `http://localhost/UAS-WEB2/produk` | Tabel produk, **search**, **filter kategori**, **pagination** |
| 4 | Tambah Produk | `http://localhost/UAS-WEB2/produk/create` | **Form upload gambar**, validasi |
| 5 | Edit Produk | Klik tombol Edit di daftar | Form terisi data lama |
| 6 | Hapus Produk | Klik tombol Hapus | Konfirmasi + flash message |
| 7 | Daftar Kategori | `http://localhost/UAS-WEB2/kategori` | CRUD kategori |
| 8 | Daftar Users | `http://localhost/UAS-WEB2/users` | CRUD users (admin only) |
| 9 | Penjualan | `http://localhost/UAS-WEB2/penjualan` | Daftar transaksi + detail |
| 10 | Transaksi Baru | `http://localhost/UAS-WEB2/penjualan/create` | Form pilih produk + jumlah |
| 11 | Halaman Laporan | `http://localhost/UAS-WEB2/laporan` | 6 tombol laporan (PDF, Excel, Cetak) |
| 12 | Cetak Produk | `http://localhost/UAS-WEB2/laporan/cetak_produk` | Tampilan cetak + tombol print |
| 13 | Download PDF | `http://localhost/UAS-WEB2/laporan/produk_pdf` | File PDF terdownload |
| 14 | Download Excel | `http://localhost/UAS-WEB2/laporan/produk_excel` | File Excel terdownload |
| 15 | Sidebar Petugas | Login sebagai `petugas` | Menu Users tidak muncul |
| 16 | Database | phpMyAdmin | Tabel + relasi + FK |
| 17 | Password hash | phpMyAdmin → tabel `users` | Kolom `password` ter-hash |
| 18 | URL tanpa index.php | Browser address bar | URL bersih tanpa `index.php` |

### Tips Screenshot

1. Gunakan **Windows + Shift + S** (Snipping Tool) untuk screenshot area tertentu
2. Untuk halaman penuh: gunakan ekstensi browser **Full Page Screen Capture**
3. Untuk menampilkan validasi: isi form dengan data salah lalu submit, screenshot pesan error merah
4. Untuk flash message: lakukan aksi sukses, screenshot notifikasi hijau yang muncul
5. Untuk chart: pastikan ada data penjualan agar grafik tidak kosong

---

## 7. Cara Menjalankan

### Prasyarat
- XAMPP (PHP 8.x, MariaDB/MySQL)
- Composer (untuk install library)

### Langkah

```bash
# 1. Letakkan folder di htdocs
#    D:\xampp\htdocs\UAS-WEB2\

# 2. Import database
#    Buka phpMyAdmin → Import → pilih file database.sql
#    ATAU via command line:
mysql -u root < database.sql

# 3. Install dependencies (PDF, Excel)
cd D:\xampp\htdocs\UAS-WEB2
composer install --no-interaction --prefer-dist

# 4. Akses di browser
#    http://localhost/UAS-WEB2/

# 5. Login dengan:
#    Admin:   username = admin,   password = admin123
#    Petugas: username = petugas, password = admin123
```

### Catatan
- Base URL sudah diatur di `application/config/config.php:26`
- Database config di `application/config/database.php:76-96`
- Session menggunakan file driver (default)
- Upload gambar produk max 2MB, format jpg/jpeg/png
