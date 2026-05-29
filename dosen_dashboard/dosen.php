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
    <title>Data Dosen - FILKOM</title>

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/crud.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* CSS Tambahan Khusus untuk Menangani Tabel Data Kompak */
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
                    <h2>🎓 Data Dosen Fakultas Ilmu Komputer</h2>
                    <a href="dosen_tambah.php" class="btn btn-primary">+ Tambah Dosen</a>
                </div>

                <div class="table-responsive-wrapper">
                    <table class="crud-table-compact">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">NID</th>
                                <th width="60%">Nama Dosen</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $query = "SELECT * FROM tbl_dosen ORDER BY nid ASC";
                            $result = mysqli_query($link, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><center><?php echo $no++; ?></center></td>
                                <td><strong><?php echo htmlspecialchars($row['nid']); ?></strong></td>
                                <td><span style="font-weight: 500; color: #1e293b;"><?php echo htmlspecialchars($row['namados']); ?></span></td>

                                <td>
                                    <a href="dosen_ubah.php?nid=<?php echo urlencode($row['nid']); ?>" class="btn-action btn-edit" style="padding: 5px 10px; font-size: 0.8rem;">
                                        Ubah
                                    </a>

                                    <a href="dosen_hapus.php?nid=<?php echo urlencode($row['nid']); ?>"
                                       data-nid="<?php echo htmlspecialchars($row['nid']); ?>"
                                       data-nama="<?php echo htmlspecialchars($row['namados']); ?>"
                                       class="btn-action btn-delete btn-hapus-dosen"
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
                                <td colspan="4" style="text-align:center; color: #64748b; padding: 20px;">
                                    Belum ada data dosen terdaftar.
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
            // Menangkap seluruh elemen tombol hapus dosen
            const tombolHapus = document.querySelectorAll('.btn-hapus-dosen');
            
            tombolHapus.forEach(tombol => {
                tombol.addEventListener('click', function (event) {
                    // Menahan tautan href langsung ke file hapus
                    event.preventDefault();
                    
                    const urlTujuan = this.getAttribute('href');
                    const nidDosen = this.getAttribute('data-nid');
                    const namaDosen = this.getAttribute('data-nama');
                    
                    // Trigger popup konfirmasi gaya profesional
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Data dosen bernama ${namaDosen} (${nidDosen}) akan dihapus permanen dari sistem!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        // Jika dikonfirmasi, teruskan instruksi menuju URL hapus
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