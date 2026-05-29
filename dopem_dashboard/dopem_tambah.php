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

// Proses simpan data saat tombol Tambah diklik
if (isset($_POST['simpan'])) {
    $nim = mysqli_real_escape_string($link, $_POST['nim']);
    $nid = mysqli_real_escape_string($link, $_POST['nid']);

    if (!empty($nim) && !empty($nid)) {
        // Cek dulu apakah NIM ini udah di-plot bimbingan apa belum biar ga dobel di tbl_dopem
        $cek = mysqli_query($link, "SELECT * FROM tbl_dopem WHERE nim = '$nim'");
        if (mysqli_num_rows($cek) > 0) {
            $pesan_gagal = "Mahasiswa dengan NIM tersebut sudah memiliki dosen pembimbing!";
        } else {
            $query = "INSERT INTO tbl_dopem (nim, nid) VALUES ('$nim', '$nid')";
            if (mysqli_query($link, $query)) {
                $pesan_sukses = true;
            } else {
                $pesan_gagal = "Gagal menambahkan data bimbingan: " . mysqli_error($link);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pembagian Bimbingan - FILKOM</title>
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
                    <h2>📋 Kelola Pembagian Dosen Pembimbing / <span style="color: #64748b; font-weight: 400;">Tambah Data</span></h2>
                </div>

                <div class="form-box-full">
                    <form action="" method="POST">
                        
                        <div class="form-group">
                            <label for="nim">Pilih Mahasiswa Bimbingan</label>
                            <select name="nim" id="nim" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit;">
                                <option value="">-- Pilih Mahasiswa --</option>
                                <?php
                                $mhs_query = mysqli_query($link, "SELECT nim, namamhs FROM tbl_mhs ORDER BY nim ASC");
                                while ($mhs = mysqli_fetch_array($mhs_query)) {
                                    echo "<option value='" . $mhs['nim'] . "'>" . $mhs['nim'] . " - " . $mhs['namamhs'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="nid">Pilih Dosen Pembimbing</label>
                            <select name="nid" id="nid" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit;">
                                <option value="">-- Pilih Dosen --</option>
                                <?php
                                $dsn_query = mysqli_query($link, "SELECT nid, namados FROM tbl_dosen ORDER BY nid ASC");
                                while ($dsn = mysqli_fetch_array($dsn_query)) {
                                    echo "<option value='" . $dsn['nid'] . "'>" . $dsn['nid'] . " - " . $dsn['namados'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="simpan" class="btn-mhs btn-mhs-submit">Simpan Data</button>
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
                text: 'Data pembagian bimbingan baru berhasil disimpan!',
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