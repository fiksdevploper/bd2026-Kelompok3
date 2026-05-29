<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../koneksi.php';
include "../switch.php"; 

global $link;

$pesan_sukses = false;
$pesan_gagal = false;

// Ambil parameter NIM dari URL secara aman
$id_nim = mysqli_real_escape_string($link, $_GET['nim']);

// Ambil data lama bimbingan si mahasiswa tersebut
$get_data = mysqli_query($link, "SELECT * FROM tbl_dopem WHERE nim = '$id_nim'");
$data_lama = mysqli_fetch_array($get_data);

if (isset($_POST['update'])) {
    $nid_baru = mysqli_real_escape_string($link, $_POST['nid']);

    $update = mysqli_query($link, "UPDATE tbl_dopem SET nid = '$nid_baru' WHERE nim = '$id_nim'");
    if ($update) {
        $pesan_sukses = true;
    } else {
        $pesan_gagal = "Gagal mengubah data bimbingan: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Pembagian Bimbingan - FILKOM</title>
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
                    <h2>📋 Kelola Pembagian Dosen Pembimbing / <span style="color: #64748b; font-weight: 400;">Ubah Data</span></h2>
                </div>

                <div class="form-box-full">
                    <form action="" method="POST">
                        
                        <div class="form-group">
                            <label for="nim">NIM Mahasiswa</label>
                            <input type="text" id="nim" value="<?php echo htmlspecialchars($data_lama['nim']); ?>" readonly style="background-color: #e9ecef; color: #495057; cursor: not-allowed;">
                        </div>

                        <div class="form-group">
                            <label for="nid">Ubah Dosen Pembimbing</label>
                            <select name="nid" id="nid" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit;">
                                <?php
                                // PERBAIKAN: Mengubah namamhs menjadi namados pada SELECT
                                $dsn_query = mysqli_query($link, "SELECT nid, namados FROM tbl_dosen ORDER BY nid ASC");
                                while ($dsn = mysqli_fetch_array($dsn_query)) {
                                    // Otomatis menyeleksi dosen yang saat ini terdaftar
                                    $selected = ($dsn['nid'] == $data_lama['nid']) ? "selected" : "";
                                    
                                    // PERBAIKAN: Mengubah $dsn['namamhs'] menjadi $dsn['namados'] pada cetakan option
                                    echo "<option value='".$dsn['nid']."' $selected>".$dsn['nid']." - ".$dsn['namados']."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="update" class="btn-mhs btn-mhs-submit">Update Data</button>
                            <a href="dopem.php" class="btn-mhs btn-mhs-cancel">Batal</a>
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
                text: 'Data pembagian bimbingan berhasil diperbarui!',
                icon: 'success',
                confirmButtonColor: '#007bff'
            }).then(() => { window.location.href = 'dopem.php'; });
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