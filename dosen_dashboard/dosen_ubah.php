<?php
session_start();

// Jika tidak ada session login atau nilainya bukan true, kunci halamannya
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../koneksi.php';
include "../switch.php"; 

global $link;

$pesan_sukses = false;
$pesan_gagal = false;

// Ambil NID dari URL saat pertama kali halaman dimuat
$nid = isset($_GET['nid']) ? mysqli_real_escape_string($link, $_GET['nid']) : '';

// Mengambil data dosen yang akan diubah
$query = mysqli_query($link, "SELECT * FROM tbl_dosen WHERE nid='$nid'");
$data = mysqli_fetch_assoc($query);

// Jika menekan tombol ubah
if (isset($_POST['ubah'])) {
    $nid_post = mysqli_real_escape_string($link, $_POST['nid']);
    $namados  = mysqli_real_escape_string($link, $_POST['namados']);

    $update_query = "UPDATE tbl_dosen SET namados='$namados' WHERE nid='$nid_post'";
    
    if (mysqli_query($link, $update_query)) {
        $pesan_sukses = true;
    } else {
        $pesan_gagal = "Gagal mengupdate data: " . mysqli_error($link);
    }
}

// Jika data dosen tidak ditemukan (dan tidak sedang menekan tombol ubah), kembalikan
if (!$data && !isset($_POST['ubah'])) {
    header("Location: dosen.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Dosen - FILKOM</title>
    
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/crud.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <h2>👨‍🏫 Kelola Dosen / <span style="color: #64748b; font-weight: 400;">Ubah Data</span></h2>
                </div>

                <div class="form-box-full">
                    <form action="" method="POST">
                        
                        <input type="hidden" name="nid" value="<?php echo htmlspecialchars($data['nid'] ?? $_POST['nid']); ?>">

                        <div class="form-group">
                            <label for="nid_view">NID (Nomor Induk Dosen)</label> 
                            <input type="text" id="nid_view" value="<?php echo htmlspecialchars($data['nid'] ?? ''); ?>" readonly style="background-color: #e9ecef; color: #495057; cursor: not-allowed;">
                        </div>

                        <div class="form-group">
                            <label for="namados">Nama Lengkap Dosen</label>
                            <input type="text" id="namados" name="namados" value="<?php echo htmlspecialchars($data['namados'] ?? $_POST['namados'] ?? ''); ?>" required placeholder="Masukkan nama lengkap dosen...">
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="ubah" class="btn-mhs btn-mhs-submit">Update Data Dosen</button>
                            <a href="dosen.php" class="btn-mhs btn-mhs-cancel">Batal</a>
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
                text: 'Data dosen berhasil diperbarui!',
                icon: 'success',
                confirmButtonColor: '#007bff'
            }).then(() => { window.location.href = 'dosen.php'; });
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