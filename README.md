# 🎓 BD2026 — Academic Management Dashboard

> Aplikasi web **PHP Native + MySQL** untuk manajemen data akademik internal — mahasiswa, dosen, mata kuliah, dan nilai — dalam satu dashboard modular yang terpusat.

---

## 📋 Daftar Isi

- [Gambaran Umum](#-gambaran-umum)
- [Fitur Utama](#-fitur-utama)
- [Struktur Folder](#-struktur-folder)
- [Penjelasan Komponen](#-penjelasan-komponen)
- [Alur Kerja Sistem](#️-alur-kerja-sistem)
- [Panduan Setup](#-panduan-setup)
- [Panduan Pengembangan](#-panduan-pengembangan)
- [Tech Stack](#-tech-stack)

---

## 🌐 Gambaran Umum

**BD2026** adalah dashboard manajemen internal berbasis **PHP Native** dan **MySQL** yang dirancang untuk mengelola data akademik sebuah institusi pendidikan. Aplikasi ini dibangun menggunakan pendekatan **arsitektur modular** — memisahkan komponen layout, logika backend, dan stylesheet — guna memastikan kemudahan pemeliharaan (*maintainability*) jangka panjang oleh tim pengembang.

---

## ✨ Fitur Utama

| Modul | Fitur |
|---|---|
| 🔐 **Autentikasi** | Login, logout, manajemen sesi PHP |
| 👤 **Anggota** | Kelola data pengguna/anggota sistem |
| 🎓 **Mahasiswa** | CRUD lengkap: tambah, ubah, hapus, lihat data |
| 👨‍🏫 **Dosen** | Dashboard kelola data dosen |
| 📚 **Mata Kuliah** | Kelola daftar mata kuliah |
| 📊 **Nilai** | Input dan manajemen nilai mahasiswa |
| 🔔 **Notifikasi** | Pop-up interaktif via **SweetAlert2** |

---

## 📁 Struktur Folder

```
bd2026-Kelompok3/
│
├── 📁 auth/                          # Sistem autentikasi
│   ├── buat_admin.php                # Registrasi akun admin
│   ├── login.php                     # Halaman form login
│   ├── logout.php                    # Handler logout & destroy session
│   └── proses_login.php              # Logika validasi login
│
├── 📁 css/                           # Stylesheet terpusat
│   ├── crud.css                      # Style komponen CRUD (tabel, form, tombol)
│   ├── index.css                     # Style halaman utama/landing
│   └── login.css                     # Style halaman login
│
├── 📁 layouts/                       # Komponen layout yang dapat digunakan ulang
│   ├── atas.php                      # Header & tag <head> (CSS, meta)
│   ├── bawah.php                     # Footer & tag penutup </body></html>
│   └── menu_kiri.php                 # Sidebar navigasi utama
│
├── 📁 images/                        # Aset gambar & ikon
│
├── 📁 anggota_dashboard/             # Modul manajemen anggota
│   └── anggota.php                   # Halaman kelola data anggota
│
├── 📁 mahasiswa_dashboard/           # Modul CRUD mahasiswa (referensi utama)
│   ├── mahasiswa.php                 # Halaman utama: tabel daftar mahasiswa
│   ├── mahasiswa_tambah.php          # Form tambah mahasiswa baru
│   ├── mahasiswa_ubah.php            # Form edit data mahasiswa
│   └── mahasiswa_hapus.php           # Handler hapus data mahasiswa
│
├── 📁 dosen_dashboard/               # Modul manajemen dosen
│   └── dosen.php                     # Halaman kelola data dosen
│
├── 📁 dopem_dashboard/               # Modul dosen pembimbing
│   └── dopem.php                     # Halaman kelola data dopem
│
├── 📁 matakuliah_dashboard/          # Modul manajemen mata kuliah
│   └── mata_kuliah.php               # Halaman kelola mata kuliah
│
├── 📁 nilai_dashboard/               # Modul manajemen nilai
│   └── nilai.php                     # Halaman kelola nilai mahasiswa
│
├── koneksi.php                       # ⚙️  Konfigurasi koneksi database (MySQL)
├── index.php                         # 🏠 Entry point / halaman utama
├── utama.php                         # Halaman dashboard utama (post-login)
├── welcome.php                       # Halaman selamat datang
├── switch.php                        # Router/switch antar modul
├── querymhs.php                      # Query helper khusus data mahasiswa
└── test.php                          # File pengujian (development only)
```

---

## 🔧 Penjelasan Komponen

### `koneksi.php` — Jembatan Database
File **paling krusial** dalam seluruh aplikasi. Berisi konfigurasi PDO/MySQLi untuk terhubung ke database `basisdata2026`. Setiap file yang membutuhkan akses data **wajib** memanggil file ini di baris paling atas:

```php
require_once "../koneksi.php";
```

---

### `layouts/` — Komponen UI yang Dapat Digunakan Ulang
Memanfaatkan teknik `include` PHP untuk menyuntikkan komponen antarmuka ke setiap halaman. Cukup ubah **satu file**, seluruh halaman otomatis ter-update.

```
layouts/
├── atas.php       → <head>, CSS links, session check, buka <body>
├── menu_kiri.php  → Sidebar navigasi (ubah di sini jika ada menu baru)
└── bawah.php      → Tutup </body></html>, script JS footer
```

Contoh penggunaan dalam setiap halaman dashboard:

```php
<?php
require_once "../koneksi.php";
include "../layouts/atas.php";
include "../layouts/menu_kiri.php";

// ... konten halaman ...

include "../layouts/bawah.php";
?>
```

---

### `css/` — Stylesheet Terpusat
Kode visual **sengaja dipisah** dari struktur PHP/HTML agar file utama tetap bersih dan mudah dibaca.

| File | Kegunaan |
|---|---|
| `crud.css` | Kelas utama: `.table-container`, `.crud-table`, `.form-box-full`, `.btn-mhs` |
| `index.css` | Style untuk halaman landing/welcome |
| `login.css` | Style khusus halaman autentikasi |

---

### `mahasiswa_dashboard/` — Referensi Implementasi CRUD
Modul ini adalah **template pola (pattern reference)** untuk semua modul lainnya. Menerapkan operasi CRUD lengkap:

| File | Operasi | Keterangan |
|---|---|---|
| `mahasiswa.php` | **Read** | Tampilkan semua data dalam tabel |
| `mahasiswa_tambah.php` | **Create** | Form input data mahasiswa baru |
| `mahasiswa_ubah.php` | **Update** | Form edit dengan NIM di-*disabled* (jaga integritas FK) |
| `mahasiswa_hapus.php` | **Delete** | Handler hapus + konfirmasi SweetAlert2 |

---

## ⚙️ Alur Kerja Sistem

```
[Browser] 
   │
   ▼
[index.php / welcome.php]
   │
   ▼ (belum login?)
[auth/login.php] ──► [auth/proses_login.php] ──► Session::set('user')
   │
   ▼ (login berhasil)
[utama.php — Dashboard Utama]
   │
   ├──► [anggota_dashboard/anggota.php]
   ├──► [mahasiswa_dashboard/mahasiswa.php] ──► tambah / ubah / hapus
   ├──► [dosen_dashboard/dosen.php]
   ├──► [matakuliah_dashboard/mata_kuliah.php]
   └──► [nilai_dashboard/nilai.php]
            │
            ▼ (setiap halaman)
       require_once koneksi.php
       include layouts/atas.php
       include layouts/menu_kiri.php
            │
            ▼
       [MySQL: basisdata2026]
```

### 1. 🔐 Keamanan & Autentikasi
Setiap halaman dashboard dilindungi oleh **Session PHP**. Jika pengguna belum login, sistem otomatis memblokir akses dan redirect ke halaman login.

```php
// Contoh proteksi di awal setiap halaman dashboard
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /bd2026/auth/login.php");
    exit();
}
```

### 2. 🔗 Navigasi Anti-Broken Link
`menu_kiri.php` menggunakan **Absolute Path** berbasis root `/bd2026/` — bukan relative path — sehingga navigasi tetap bekerja sempurna dari sub-folder sedalam apapun.

```php
// ✅ Benar — Absolute path
<a href="/bd2026/mahasiswa_dashboard/mahasiswa.php">Data Mahasiswa</a>

// ❌ Hindari — Relative path (rentan broken)
<a href="../mahasiswa_dashboard/mahasiswa.php">Data Mahasiswa</a>
```

### 3. 🎨 User Experience
- **Form Modern**: Layout satu kolom penuh (max-width `800px`) dengan efek *glowing* saat input aktif
- **Input Terkunci**: Kolom NIM di-`disabled` saat edit untuk menjaga integritas relasi tabel
- **Notifikasi SweetAlert2**: Semua feedback operasi (sukses/gagal) ditampilkan sebagai dialog pop-up interaktif — bukan teks mentah

---

## 🚀 Panduan Setup

### Prasyarat
- PHP `>= 7.4`
- MySQL / MariaDB
- Web Server: **XAMPP** / **Laragon** / **WAMP**

### Langkah Instalasi

1. **Clone / copy** project ke folder htdocs:
   ```bash
   # Untuk XAMPP (Windows)
   C:/xampp/htdocs/bd2026/
   
   # Untuk Laragon
   C:/laragon/www/bd2026/
   ```

2. **Import database** via phpMyAdmin:
   - Buat database baru bernama `basisdata2026`
   - Import file `.sql` yang tersedia

3. **Konfigurasi koneksi** di `koneksi.php`:
   ```php
   $host     = "localhost";
   $dbname   = "basisdata2026";
   $username = "root";
   $password = "";           // sesuaikan dengan password MySQL kamu
   ```

4. **Akses aplikasi** di browser:
   ```
   http://localhost/bd2026/
   ```

---

## 👨‍💻 Panduan Pengembangan

Arsitektur ini dirancang berbasis **pola seragam (pattern-based)**. Untuk menyelesaikan modul yang belum lengkap (Dosen, Nilai, Mata Kuliah), ikuti pola modul Mahasiswa:

### Langkah Membuat Modul Baru

**1. Buat file di sub-folder dashboard yang sesuai:**
```
dosen_dashboard/
├── dosen.php             ← Read (tabel daftar)
├── dosen_tambah.php      ← Create (form tambah)
├── dosen_ubah.php        ← Update (form edit)
└── dosen_hapus.php       ← Delete (handler hapus)
```

**2. Template dasar setiap file:**
```php
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /bd2026/auth/login.php");
    exit();
}

require_once "../koneksi.php";
include "../layouts/atas.php";
include "../layouts/menu_kiri.php";
?>

<!-- Konten halaman di sini -->

<?php include "../layouts/bawah.php"; ?>
```

**3. Gunakan kelas CSS yang sudah tersedia** dari `css/crud.css`:

| Kelas | Kegunaan |
|---|---|
| `.table-container` | Wrapper tabel dengan shadow & border-radius |
| `.crud-table` | Style tabel data utama |
| `.form-box-full` | Container form full-width (max 800px) |
| `.btn-mhs` | Tombol aksi (tambah, simpan, batal) |

**4. Tambahkan menu** ke `layouts/menu_kiri.php`:
```php
<a href="/bd2026/dosen_dashboard/dosen.php" class="menu-item">
    <i class="icon-dosen"></i> Data Dosen
</a>
```

---

## 🛠️ Tech Stack

| Teknologi | Peran |
|---|---|
| **PHP Native** | Backend logic & server-side rendering |
| **MySQL / MariaDB** | Database penyimpanan data akademik |
| **HTML5 + CSS3** | Struktur & styling antarmuka |
| **JavaScript** | Interaksi dinamis sisi klien |
| **SweetAlert2** | Library notifikasi pop-up interaktif |
| **XAMPP / Laragon** | Local development server |

---

## 📌 Catatan Penting untuk Developer

> ⚠️ **`test.php`** — File ini hanya untuk keperluan pengujian lokal selama development. **Jangan di-deploy** ke server produksi.

> 💡 **Pola `require_once` vs `include`** — Gunakan `require_once` untuk `koneksi.php` (fatal jika gagal) dan `include` untuk komponen layout (non-fatal).

> 🔒 **Keamanan** — Pastikan input form selalu di-*sanitize* sebelum dimasukkan ke query database. Pertimbangkan penggunaan **Prepared Statements** (PDO) untuk mencegah SQL Injection.

---

<div align="center">
  <sub>Dikembangkan untuk keperluan akademik · Mata Kuliah Basis Data 2026</sub>
</div>
