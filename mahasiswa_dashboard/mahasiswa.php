<?php
session_start();

// 1. Proteksi Halaman: Jika belum login, tendang ke login.php
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Akses Ditolak!',
                text: 'Silakan login terlebih dahulu untuk mengakses data mahasiswa.',
                icon: 'warning',
                confirmButtonColor: '#e67e22',
                confirmButtonText: 'Login'
            }).then(() => { window.location.href = 'auth/login.php'; });
        });
    </script>
    <?php
    exit;
}

// 2. Ambil Koneksi Database
require_once '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - FILKOM</title>
    
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/crud.css">
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
                    <h2>🎓 Data Mahasiswa Fakultas Ilmu Komputer</h2>
                    <a href="mahasiswa_tambah.php" class="btn btn-primary">+ Tambah Mahasiswa</a>
                </div>

                <table class="crud-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">NIM</th>
                            <th width="45%">Nama Mahasiswa</th>
                            <th width="20%">No. Handphone</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Ambil data sesuai dengan nama tabel dan kolom di database kamu
                        $query = "SELECT * FROM tbl_mhs ORDER BY nim ASC";
                        $result = mysqli_query($link, $query);
                        
                        if (mysqli_num_rows($result) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['namamhs']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['handphone']) . "</td>";
                                echo "<td>
                                        <a href='mahasiswa_ubah.php?nim=" . $row['nim'] . "' class='btn-action btn-edit'>Ubah</a>
                                        <a href='mahasiswa_hapus.php?nim=" . $row['nim'] . "' class='btn-action btn-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Hapus</a>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align:center;'>Belum ada data mahasiswa.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <footer class="footer-site">
        <?php include "../layouts/bawah.php"; ?>
    </footer>
</body>
</html>