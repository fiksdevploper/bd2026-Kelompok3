<?php
session_start();

// Proteksi halaman dashboard
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

// Memanggil koneksi database dari folder luar (keluar 1 tingkat)
require_once '../koneksi.php';
include "../switch.php"; 

global $link;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_sks = isset($_GET['sks']) ? $_GET['sks'] : '';

$where = "WHERE 1=1";
if ($search != '') {
    $s = mysqli_real_escape_string($link, $search);
    $where .= " AND (kodemk LIKE '%$s%' OR namamk LIKE '%$s%')";
}
if ($filter_sks != '') {
    $where .= " AND sks = " . (int) $filter_sks;
}

// Nama tabel disesuaikan dengan 'tbl_matakuliah' sesuai database Anda
$query = mysqli_query($link, "SELECT * FROM tbl_matakuliah $where ORDER BY kodemk ASC");
$total = mysqli_num_rows($query);
$stats = mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(*) AS total, SUM(sks) AS total_sks FROM tbl_matakuliah"));
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah - FILKOM</title>

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/crud.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* CSS Tambahan Khusus Penyelarasan Tabel Kompak & Filter */
        .table-responsive-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

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

        /* Styling Toolbar Pencarian & Filter */
        .filter-toolbar {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
            background-color: #f8fafc;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .filter-toolbar input[type="text"],
        .filter-toolbar select {
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 0.85rem;
            outline: none;
        }

        .filter-toolbar input[type="text"] {
            flex: 1;
            min-width: 200px;
        }

        .badge-sks {
            display: inline-block;
            padding: 4px 8px;
            font-size: 0.75rem;
            font-weight: 600;
            background-color: #e0f2fe;
            color: #0369a1;
            border-radius: 4px;
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
                    <h2>📚 Data Mata Kuliah Fakultas Ilmu Komputer</h2>
                    <a href="mata_kuliah_tambah.php" class="btn btn-primary">+ Tambah Matkul</a>
                </div>

                <form method="GET" action="" class="filter-toolbar">
                    <input type="text" name="search" placeholder="Cari Kode atau Nama Mata Kuliah..." value="<?= htmlspecialchars($search); ?>">
                    
                    <select name="sks">
                        <option value="">-- Semua SKS --</option>
                        <option value="2" <?= $filter_sks == '2' ? 'selected' : ''; ?>>2 SKS</option>
                        <option value="3" <?= $filter_sks == '3' ? 'selected' : ''; ?>>3 SKS</option>
                        <option value="4" <?= $filter_sks == '4' ? 'selected' : ''; ?>>4 SKS</option>
                    </select>
                    
                    <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">Saring</button>
                    <?php if ($search != '' || $filter_sks != ''): ?>
                        <a href="mata_kuliah.php" class="btn-mhs-cancel" style="text-decoration: none; padding: 8px 15px; display: inline-flex; align-items: center; justify-content: center;">Reset</a>
                    <?php endif; ?>
                </form>

                <div class="table-responsive-wrapper">
                    <table class="crud-table-compact">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Kode MK</th>
                                <th width="50%">Nama Mata Kuliah</th>
                                <th width="15%">Bobot SKS</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            if ($query && mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><strong><?= htmlspecialchars($row['kodemk']); ?></strong></td>
                                <td><span style="font-weight: 500; color: #1e293b;"><?= htmlspecialchars($row['namamk']); ?></span></td>
                                <td><span class="badge-sks"><?= htmlspecialchars($row['sks']); ?> SKS</span></td>
                                <td>
                                    <a href="mata_kuliah_ubah.php?kodemk=<?= urlencode($row['kodemk']); ?>" class="btn-action btn-edit" style="padding: 5px 10px; font-size: 0.8rem;">
                                        Ubah
                                    </a>
                                    
                                    <a href="mata_kuliah_hapus.php?kodemk=<?= urlencode($row['kodemk']); ?>" 
                                       data-id="<?= htmlspecialchars($row['kodemk']); ?>"
                                       data-name="<?= htmlspecialchars($row['namamk']); ?>"
                                       class="btn-action btn-delete btn-hapus-matkul" 
                                       style="padding: 5px 10px; font-size: 0.8rem;">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                } 
                            } else {
                            ?>
                            <tr>
                                <td colspan="5" style="text-align:center; color: #64748b; padding: 20px;">
                                    Mata kuliah tidak ditemukan atau data database kosong.
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tombolHapus = document.querySelectorAll('.btn-hapus-matkul');
            
            tombolHapus.forEach(tombol => {
                tombol.addEventListener('click', function (event) {
                    // Blokir aksi redirect langsung bawaan tag <a>
                    event.preventDefault();
                    
                    const urlTarget = this.getAttribute('href');
                    const kodeMk = this.getAttribute('data-id');
                    const namaMk = this.getAttribute('data-name');
                    
                    Swal.fire({
                        title: 'Hapus Mata Kuliah?',
                        text: `Anda yakin ingin menghapus (${kodeMk}) ${namaMk}? Data yang terhapus tidak dapat dikembalikan.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        // Jika divalidasi oleh user, jalankan redirect menuju skrip php eksekutor
                        if (result.isConfirmed) {
                            window.location.href = urlTarget;
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>