<?php
session_start();

// Jika tidak ada session login atau nilainya bukan true, kunci halamannya dengan SweetAlert2
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: "Poppins", sans-serif; }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Akses Ditolak!',
                text: 'Anda tidak memiliki izin. Silakan login terlebih dahulu untuk masuk ke sistem.',
                icon: 'warning',
                confirmButtonColor: '#e67e22',
                confirmButtonText: 'Menuju Halaman Login',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = 'auth/login.php';
            });
        });
    </script>
    <?php
    exit;
}

// Memanggil koneksi database untuk menghitung jumlah data secara dinamis
require_once 'koneksi.php';

// Memanggil fitur pengingat waktu lokalisasi Indonesia
include "switch.php"; 

global $link;

// Mengambil jumlah total data dari masing-masing tabel untuk counter card
$total_mhs   = mysqli_num_rows(mysqli_query($link, "SELECT nim FROM tbl_mhs"));
$total_dsn   = mysqli_num_rows(mysqli_query($link, "SELECT nid FROM tbl_dosen"));
$total_dopem = mysqli_num_rows(mysqli_query($link, "SELECT nim FROM tbl_dopem"));
$total_mk    = mysqli_num_rows(mysqli_query($link, "SELECT kodemk FROM tbl_matakuliah")); // Query mengambil data mata kuliah
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Fakultas Ilmu Komputer - Dashboard</title>
    
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/crud.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Desain Kustom khusus halaman Beranda Utama agar terlihat premium */
        body {
            font-family: 'Poppins', sans-serif;
        }

        .welcome-box {
            background: linear-gradient(135deg, #005b7f 0%, #008cb3 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 91, 127, 0.15);
        }

        .welcome-box h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .welcome-box p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        /* Sistem Grid Otomatis untuk Kotak Informasi Angka (Responsif 4 Kolom) */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .stat-info h3 {
            margin: 0;
            color: #64748b;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info .stat-number {
            margin: 5px 0 0 0;
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }

        .stat-icon {
            font-size: 2.2rem;
            padding: 10px;
            border-radius: 12px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Skema Pewarnaan Ikon Statistik */
        .icon-mhs { background-color: #eff6ff; color: #3b82f6; }
        .icon-dsn { background-color: #fdf2f8; color: #ec4899; }
        .icon-dopem { background-color: #f0fdf4; color: #22c55e; }
        .icon-mk { background-color: #fff7ed; color: #f97316; } /* Warna Oranye Lembut untuk Mata Kuliah */

        /* Komponen Pengingat Waktu & Sistem */
        .quick-info-box {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .quick-info-box h2 {
            margin: 0 0 15px 0;
            font-size: 1.2rem;
            color: #1e293b;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-list li span.meta-icon {
            margin-right: 12px;
            font-size: 1.2rem;
            display: inline-block;
            width: 24px;
            text-align: center;
        }
        
        .badge-date {
            background-color: #f1f5f9;
            color: #0f172a;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
            margin-left: auto;
        }
    </style>
</head>

<body>
    <header class="header-site">
        <img src="images/logo.png" alt="Logo BEM FILKOM" class="navbar-logo">

        <div class="header-content">
            <?php include "layouts/atas.php"; ?>
        </div>
    </header>

    <div class="main-container">

        <aside class="sidebar-site">
            <?php include "layouts/menu_kiri.php"; ?>
        </aside>

        <main class="content-site" style="background-color: #f8fafc; padding: 30px;">
            
            <div class="welcome-box">
                <h1>👋 Selamat Datang Kembali, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Administrator'; ?></h1>
                <p>Sistem Informasi Akademik Manajemen Pembagian Dosen Pembimbing Fakultas Ilmu Komputer.</p>
            </div>

            <div class="dashboard-grid">
                
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Total Mahasiswa</h3>
                        <div class="stat-number"><?php echo $total_mhs; ?></div>
                    </div>
                    <div class="stat-icon icon-mhs">🎓</div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Total Data Dosen</h3>
                        <div class="stat-number"><?php echo $total_dsn; ?></div>
                    </div>
                    <div class="stat-icon icon-dsn">👨‍🏫</div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Sudah Di-Plot Bimbingan</h3>
                        <div class="stat-number"><?php echo $total_dopem; ?></div>
                    </div>
                    <div class="stat-icon icon-dopem">📋</div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Total Mata Kuliah</h3>
                        <div class="stat-number"><?php echo $total_mk; ?></div>
                    </div>
                    <div class="stat-icon icon-mk">📚</div>
                </div>

            </div>

            <div class="quick-info-box">
                <h2>📅 Informasi Waktu & Sesi</h2>
                <ul class="info-list">
                    <li>
                        <span class="meta-icon">📌</span> 
                        <strong>Hari Aktif:</strong> 
                        <span class="badge-date" style="background-color: #f0fdf4; color: #16a34a;">
                            <?php echo $hari; ?>
                        </span>
                    </li>
                    <li>
                        <span class="meta-icon">📆</span> 
                        <strong>Tanggal Sistem:</strong> 
                        <span class="badge-date">
                            <?php echo "$tgl $bulan $thn"; ?>
                        </span>
                    </li>
                    <li>
                        <span class="meta-icon">🛡️</span> 
                        <strong>Hak Akses Sesi:</strong> 
                        <span class="badge-date" style="background-color: #eff6ff; color: #2563eb; font-size: 0.8rem; text-transform: uppercase;">
                            <?php echo isset($_SESSION['level']) ? htmlspecialchars($_SESSION['level']) : 'Administrator'; ?>
                        </span>
                    </li>
                </ul>
            </div>

        </main>
    </div>

    <footer class="footer-site">
        <?php include "layouts/bawah.php"; ?>
    </footer>
</body>
</html>