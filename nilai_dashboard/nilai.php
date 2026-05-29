<?php
session_start();

// Proteksi halaman dashboard
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

// Memanggil koneksi database dari folder luar
require_once '../koneksi.php';
include "../switch.php"; 

global $link;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nilai - FILKOM</title>

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/crud.css">
    
    <style>
        /* CSS Tambahan Khusus untuk Menangani Tabel Data yang Padat */
        .table-responsive-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        /* Optimasi ukuran font dan padding agar tidak memakan banyak ruang */
        .crud-table-compact {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
            background-color: #ffffff;
        }

        .crud-table-compact th {
            background-color: #f8fafc;
            color: #334155;
            font-weight: 600;
            padding: 12px 10px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .crud-table-compact td {
            padding: 10px 10px;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
            vertical-align: middle;
        }

        .crud-table-compact tr:hover {
            background-color: #f1f5f9;
        }

        /* Badge Status Kelulusan yang Lebih Intuitif & Profesional */
        .badge-status {
            display: inline-block;
            padding: 6px 12px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 6px;
            text-align: center;
            line-height: 1.2;
            white-space: nowrap;
        }
        
        /* WARNA BARU: Mengganti warna merah salah sasaran kemarin */
        .status-sangat-memuaskan { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; } /* Biru Sky */
        .status-memuaskan { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }        /* Hijau Emerald */
        .status-lulus-biasa { background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }       /* Hijau Mint */
        .status-gagal { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }             /* Merah Pastel (Khusus Gagal) */
        
        /* Merapikan format teks komponen tugas */
        .text-muted-small {
            color: #64748b;
            font-size: 0.78rem;
            display: block;
            margin-top: 2px;
        }
    </style>
</head>

<body>
    <header class="header-site">
        <img src="../images/logo.png" alt="Logo BEM FILKOM" class="navbar-logo">

        <div class="header-content">
            <?php include "../layouts/atas.php"; ?>
        </div>
    </header>

    <div class="main-container">

        <aside class="sidebar-site">
            <?php include "../layouts/menu_kiri.php"; ?>
        </aside>

        <main class="content-site">
            <div class="table-container">
                <div class="table-header">
                    <h2>🎓 Data Nilai Mahasiswa Fakultas Ilmu Komputer</h2>
                    <a href="nilai_tambah.php" class="btn btn-primary">+ Tambah Nilai</a>
                </div>

                <div class="table-responsive-wrapper">
                    <table class="crud-table-compact">
                        <thead>
                            <tr>
                                <th width="4%">No</th>
                                <th width="10%">NIM</th>
                                <th width="24%">Nama / Komponen Tugas</th>
                                <th width="8%">UTS</th>
                                <th width="8%">UAS</th>
                                <th width="10%">Nilai Akhir</th>
                                <th width="8%">HM</th>
                                <th width="12%">Status Kelulusan</th>
                                <th width="16%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            
                            // Query JOIN data nilai dan nama mahasiswa
                            $query = "SELECT tbl_nilai.*, tbl_mhs.namamhs 
                                      FROM tbl_nilai 
                                      JOIN tbl_mhs ON tbl_nilai.nim = tbl_mhs.nim
                                      ORDER BY tbl_nilai.nim ASC";
                            
                            $result = mysqli_query($link, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Saring teks menjadi huruf besar untuk akurasi logika pengecekan
                                    $status_text = strtoupper($row['status']);
                                    
                                    // Penentuan warna dinamis berbasis kata kunci status
                                    if (strpos($status_text, 'SANGAT MEMUASKAN') !== false) {
                                        $badge_class = 'status-sangat-memuaskan';
                                    } elseif (strpos($status_text, 'MEMUASKAN') !== false) {
                                        $badge_class = 'status-memuaskan';
                                    } elseif ($status_text == 'LULUS' || strpos($status_text, 'MEMENUHI') !== false) {
                                        $badge_class = 'status-lulus-biasa';
                                    } else {
                                        $badge_class = 'status-gagal'; // Tetap merah jika benar-benar gagal
                                    }
                            ?>
                            <tr>
                                <td><center><?= $no++; ?></center></td>
                                <td><strong><?= htmlspecialchars($row['nim']); ?></strong></td>
                                <td>
                                    <span style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($row['namamhs']); ?></span>
                                    <span class="text-muted-small">Tugas: <?= htmlspecialchars($row['tugas']); ?></span>
                                </td>
                                <td><?= htmlspecialchars($row['uts']); ?></td>
                                <td><?= htmlspecialchars($row['uas']); ?></td>
                                <td><span style="color: #0284c7; font-weight: 600;"><?= htmlspecialchars($row['akhir']); ?></span></td>
                                <td><center><strong><?= htmlspecialchars($row['hm']); ?></strong></center></td>
                                <td>
                                    <span class="badge-status <?= $badge_class; ?>">
                                        <?= htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="nilai_edit.php?nim=<?= urlencode($row['nim']); ?>" class="btn-action btn-edit" style="padding: 5px 10px; font-size: 0.8rem;">
                                        Ubah
                                    </a>
                                    <a href="nilai_hapus.php?nim=<?= urlencode($row['nim']); ?>" 
                                       onclick="return confirm('Yakin ingin menghapus data nilai NIM <?= htmlspecialchars($row['nim']); ?>?')" 
                                       class="btn-action btn-delete" style="padding: 5px 10px; font-size: 0.8rem;">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                } 
                            } else {
                            ?>
                            <tr>
                                <td colspan="9" style="text-align:center; color: #64748b; padding: 20px;">
                                    Belum ada rekaman data nilai mahasiswa.
                                </td>
                            </tr>
                            <?php
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <footer class="footer-site">
        <?php include "../layouts/bawah.php"; ?>
    </footer>
</body>

</html>