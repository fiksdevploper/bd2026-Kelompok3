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
                    <h2>🎓 Data Nilai Fakultas Ilmu Komputer</h2>
                    <a href="mahasiswa_tambah.php" class="btn btn-primary">+ Tambah Mahasiswa</a>
                </div>

                <table class="crud-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="12%">NIM</th>
                            <th width="25%">Nama / Tugas</th>
                            <th width="10%">UTS</th>
                            <th width="10%">UAS</th>
                            <th width="10%">Akhir</th>
                            <th width="8%">HM</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- data dan tombol crud -->
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