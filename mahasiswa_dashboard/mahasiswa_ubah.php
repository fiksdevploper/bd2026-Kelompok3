<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../koneksi.php';

// Cek apakah ada parameter NIM di URL
if (!isset($_GET['nim'])) {
    header("Location: mahasiswa.php");
    exit;
}

$nim_lama = mysqli_real_escape_string($link, $_GET['nim']);

// Ambil data lama berdasarkan NIM untuk ditampilkan di input form
$result = mysqli_query($link, "SELECT * FROM tbl_mhs WHERE nim = '$nim_lama'");
if (mysqli_num_rows($result) == 0) {
    header("Location: mahasiswa.php");
    exit;
}
$data = mysqli_fetch_assoc($result);

$pesan_sukses = false;
$pesan_gagal = false;

// Proses ketika tombol ubah diklik
if (isset($_POST['ubah'])) {
    $namamhs = mysqli_real_escape_string($link, $_POST['namamhs']);
    $handphone = mysqli_real_escape_string($link, $_POST['handphone']);

    // Query Update Data
    $query = "UPDATE tbl_mhs SET namamhs = '$namamhs', handphone = '$handphone' WHERE nim = '$nim_lama'";
    if (mysqli_query($link, $query)) {
        $pesan_sukses = true;
    } else {
        $pesan_gagal = "Gagal memperbarui data: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Mahasiswa - FILKOM</title>
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
                    <h2>🎓 Kelola Mahasiswa / <span style="color: #64748b; font-weight: 400;">Ubah Data</span></h2>
                </div>

                <div class="form-box-full">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>NIM (Kunci Utama - Tidak Dapat Diubah)</label>
                            <input type="text" value="<?php echo htmlspecialchars($data['nim']); ?>" disabled>
                        </div>
                        
                        <div class="form-group">
                            <label for="namamhs">Nama Lengkap Mahasiswa</label>
                            <input type="text" id="namamhs" name="namamhs" value="<?php echo htmlspecialchars($data['namamhs']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="handphone">Nomor Handphone Kontak</label>
                            <input type="text" id="handphone" name="handphone" value="<?php echo htmlspecialchars($data['handphone']); ?>" required>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="ubah" class="btn-mhs btn-mhs-submit" style="background-color: #e67e22;">Perbarui Data</button>
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
                text: 'Data mahasiswa berhasil diperbarui!',
                icon: 'success',
                confirmButtonColor: '#e67e22'
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