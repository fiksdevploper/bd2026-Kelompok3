<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen - FILKOM</title>

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
                    <h2>🎓 Data Dosen Fakultas Ilmu Komputer</h2>
                    <a href="dosen_tambah.php" class="btn btn-primary">+ Tambah Dosen</a>
                </div>

                <table class="crud-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">NID</th>
                            <th width="65%">Nama Dosen</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        require_once '../koneksi.php';

                        $query = "SELECT * FROM tbl_dosen ORDER BY nid ASC";
                        $result = mysqli_query($link, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nid']); ?></td>
                                    <td><?php echo htmlspecialchars($row['namados']); ?></td>

                                    <td>
                                        <a href="dosen_ubah.php?nid=<?php echo urlencode($row['nid']); ?>"
                                            class="btn-action btn-edit">
                                            Ubah
                                        </a>

                                        <a href="dosen_hapus.php?nid=<?php echo urlencode($row['nid']); ?>"
                                            class="btn-action btn-delete"
                                            onclick="return confirm('Yakin ingin menghapus data?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>

                            <?php
                            } // Akhir dari while
                        } else {
                            ?>

                            <tr>
                                <td colspan="4" style="text-align:center;">
                                    Belum ada data dosen
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