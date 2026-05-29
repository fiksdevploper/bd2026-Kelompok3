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

if (isset($_POST['simpan'])) {
    $nid     = mysqli_real_escape_string($link, $_POST['nid']);
    $namados = mysqli_real_escape_string($link, $_POST['namados']);

    // Cek duplikasi berdasarkan kolom nid
    $cek = mysqli_query($link, "SELECT nid FROM tbl_dosen WHERE nid='$nid'");

    if (mysqli_num_rows($cek) > 0) {
        $pesan_gagal = "NID (Nomor Induk Dosen) sudah terdaftar dalam sistem!";
    } else {
        $query = "INSERT INTO tbl_dosen (nid, namados) VALUES ('$nid', '$namados')";

        if (mysqli_query($link, $query)) {
            $pesan_sukses = true;
        } else {
            $pesan_gagal = "Gagal menyimpan data: " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dosen - FILKOM</title>
    
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
                    <h2>👨‍🏫 Kelola Dosen / <span style="color: #64748b; font-weight: 400;">Tambah Data</span></h2>
                </div>

                <div class="form-box-full">
                    <form action="" method="POST">
                        
                        <div class="form-group">
                            <label for="nid">NID (Nomor Induk Dosen)</label>
                            <input type="text" id="nid" name="nid" required placeholder="Masukkan Nomor Induk Dosen...">
                        </div>
                        
                        <div class="form-group">
                            <label for="namados">Nama Lengkap Dosen</label>
                            <input type="text" id="namados" name="namados" required placeholder="Masukkan nama lengkap dosen beserta gelar...">
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="simpan" class="btn-mhs btn-mhs-submit">Simpan Data Dosen</button>
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
                text: 'Data dosen baru berhasil disimpan ke sistem!',
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