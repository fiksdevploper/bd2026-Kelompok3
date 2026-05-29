<?php
session_start();

// Proteksi halaman dashboard
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

// Memanggil koneksi database dan dependensi sistem
require_once '../koneksi.php';
include "../switch.php"; 

global $link;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembagian Dosen Pembimbing - FILKOM</title>

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/crud.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* CSS Tambahan Khusus untuk Menangani Tabel Data Kompak & Responsif */
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
                    <h2>📋 Data Pembagian Dosen Pembimbing Fakultas Ilmu Komputer</h2>
                    <a href="dopem_tambah.php" class="btn btn-primary">+ Tambah Data Bimbingan</a>
                </div>

                <div class="table-responsive-wrapper">
                    <table class="crud-table-compact">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">NIM</th>
                                <th width="30%">Nama Mahasiswa</th>
                                <th width="15%">NID Dosen</th>
                                <th width="20%">Nama Dosen Pembimbing</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // Query Relasi 3 Tabel 
                            $query = "SELECT 
                                        tbl_mhs.nim, 
                                        tbl_mhs.namamhs AS nama_mahasiswa,
                                        tbl_dopem.nid AS nid_dosen,
                                        tbl_dosen.namados AS nama_dosen
                                    FROM tbl_dopem
                                    INNER JOIN tbl_mhs ON tbl_dopem.nim = tbl_mhs.nim
                                    INNER JOIN tbl_dosen ON tbl_dopem.nid = tbl_dosen.nid
                                    GROUP BY tbl_mhs.nim
                                    ORDER BY tbl_mhs.nim ASC";
                                    
                            $result = mysqli_query($link, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><center><?php echo $no++; ?></center></td>
                                <td><strong><?php echo htmlspecialchars($row['nim']); ?></strong></td>
                                <td><span style="font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars($row['nama_mahasiswa']); ?></span></td>
                                <td><?php echo htmlspecialchars($row['nid_dosen']); ?></td>
                                <td><span style="font-weight: 500; color: #334155;"><?php echo htmlspecialchars($row['nama_dosen']); ?></span></td>

                                <td>
                                    <a href="dopem_ubah.php?nim=<?php echo urlencode($row['nim']); ?>" class="btn-action btn-edit" style="padding: 5px 10px; font-size: 0.8rem;">
                                        Ubah
                                    </a>

                                    <a href="dopem_hapus.php?nim=<?php echo urlencode($row['nim']); ?>"
                                       data-nim="<?php echo htmlspecialchars($row['nim']); ?>"
                                       data-mhs="<?php echo htmlspecialchars($row['nama_mahasiswa']); ?>"
                                       class="btn-action btn-delete btn-hapus-dopem"
                                       style="padding: 5px 10px; font-size: 0.8rem;">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php
                                } // Akhir dari while
                            } else {
                            ?>
                            <tr>
                                <td colspan="6" style="text-align:center; color: #64748b; padding: 20px;">
                                    Belum ada data pembagian dosen pembimbing.
                                </td>
                            </tr>
                            <?php
                            } // Akhir dari if 
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
            // Menangkap seluruh elemen tombol hapus dopem
            const tombolHapus = document.querySelectorAll('.btn-hapus-dopem');
            
            tombolHapus.forEach(tombol => {
                tombol.addEventListener('click', function (event) {
                    // Menahan tautan href langsung ke file hapus bawaan
                    event.preventDefault();
                    
                    const urlTujuan = this.getAttribute('href');
                    const nimMhs = this.getAttribute('data-nim');
                    const namaMhs = this.getAttribute('data-mhs');
                    
                    // Trigger popup boks konfirmasi gaya modern
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Data bimbingan untuk mahasiswa ${namaMhs} (${nimMhs}) akan dihapus dari plot pembagian!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Hapus Plot!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        // Jika dikonfirmasi, teruskan instruksi menuju URL hapus target
                        if (result.isConfirmed) {
                            window.location.href = urlTujuan;
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>