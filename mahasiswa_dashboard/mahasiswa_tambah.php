<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../koneksi.php';

$pesan_sukses = false;
$pesan_gagal = false;

// Proses ketika tombol simpan diklik
if (isset($_POST['simpan'])) {
    $nim = mysqli_real_escape_string($link, $_POST['nim']);
    $namamhs = mysqli_real_escape_string($link, $_POST['namamhs']);
    $handphone = mysqli_real_escape_string($link, $_POST['handphone']);

    // Cek apakah NIM sudah terdaftar sebelumnya
    $cek_nim = mysqli_query($link, "SELECT nim FROM tbl_mhs WHERE nim = '$nim'");
    if (mysqli_num_rows($cek_nim) > 0) {
        $pesan_gagal = "NIM sudah terdaftar dalam sistem!";
    } else {
        // Query Insert Data
        $query = "INSERT INTO tbl_mhs (nim, namamhs, handphone) VALUES ('$nim', '$namamhs', '$handphone')";
        if (mysqli_query($link, $query)) {
            $pesan_sukses = true;
        } else {
            $pesan_gagal = "Gagal menambahkan data: " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa - FILKOM</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/crud.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header class="header-site">
        <img src="../images/logo.png" alt="Logo BEM FILKOM" class="navbar-logo">
        <div class="header-content"><?php include "../layouts/atas.php"; ?></div>
    </header>

    <div class="main-container">
        <aside class="sidebar-site"><?php include "../layouts/menu_kiri.php"; ?></aside>

        <main class="content-site">
            <div class="table-container">
                <div class="table-header">
                    <h2>🎓 Kelola Mahasiswa / <span style="color: #64748b; font-weight: 400;">Tambah Data</span></h2>
                </div>

                <div class="form-box-full">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="nim">NIM (Nomor Induk Mahasiswa)</label>
                            <input type="text" id="nim" name="nim" required placeholder="Masukkan 4 digit NIM (Contoh: 1016)...">
                        </div>
                        
                        <div class="form-group">
                            <label for="namamhs">Nama Lengkap Mahasiswa</label>
                            <input type="text" id="namamhs" name="namamhs" required placeholder="Masukkan nama lengkap mahasiswa...">
                        </div>
                        
                        <div class="form-group">
                            <label for="handphone">Nomor Handphone Kontak</label>
                            <input type="text" id="handphone" name="handphone" required placeholder="Masukkan nomor handphone aktif (Contoh: 081234567xxx)...">
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="simpan" class="btn-mhs btn-mhs-submit">Simpan Mahasiswa</button>
                            <a href="mahasiswa.php" class="btn-mhs btn-mhs-cancel">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <?php if ($pesan_sukses): ?>
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data mahasiswa baru berhasil disimpan!',
                icon: 'success',
                confirmButtonColor: '#007bff'
            }).then(() => { window.location.href = 'mahasiswa.php'; });
        </script>
    <?php endif; ?>

    <?php if ($pesan_gagal): ?>
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: '<?php echo $pesan_gagal; ?>',
                icon: 'error',
                confirmButtonColor: '#d33'
            });
        </script>
    <?php endif; ?>
</body>
</html>