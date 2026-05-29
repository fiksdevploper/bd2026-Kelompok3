<?php
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

                <table class="crud-table">
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
                        // Query Relasi 3 Tabel (Sudah diperbaiki ke kolom tbl_dosen.namados)
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
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nim']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_mahasiswa']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nid_dosen']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_dosen']); ?></td>

                                    <td>
                                        <a href="dopem_ubah.php?nim=<?php echo urlencode($row['nim']); ?>"
                                            class="btn-action btn-edit">
                                            Ubah
                                        </a>

                                        <a href="dopem_hapus.php?nim=<?php echo urlencode($row['nim']); ?>"
                                            class="btn-action btn-delete"
                                            onclick="return confirm('Yakin ingin menghapus data bimbingan ini?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>

                            <?php
                            } // Akhir dari while
                        } else {
                            ?>

                            <tr>
                                <td colspan="6" style="text-align:center;">
                                    Belum ada data pembagian dosen pembimbing
                                </td>
                            </tr>

                        <?php
                        } // Akhir dari if 
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