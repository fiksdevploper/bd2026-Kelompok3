<?php
session_start();

// Proteksi halaman dashboard
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

// Memanggil koneksi database dari folder luar
require_once '../koneksi.php';
include "../switch.php"; 

global $link;

$pesan_sukses = false;
$pesan_gagal = false;

// 1. Ambil data mata kuliah yang mau diedit berdasarkan kodemk di URL
$kodemk_awal = isset($_GET['kodemk']) ? mysqli_real_escape_string($link, $_GET['kodemk']) : '';

if (!empty($kodemk_awal)) {
    $ambil_data = mysqli_query($link, "SELECT * FROM tbl_matakuliah WHERE kodemk = '$kodemk_awal'");
    $data = mysqli_fetch_assoc($ambil_data);
    
    // Jika data tidak ditemukan di database, kembalikan ke halaman utama mata kuliah
    if (!$data && !isset($_POST['ubah'])) {
        header("Location: mata_kuliah.php");
        exit;
    }
} else {
    header("Location: mata_kuliah.php");
    exit;
}

// 2. Proses simpan perubahan data ketika tombol ubah ditekan
if (isset($_POST['ubah'])) {
    $kodemk_post = mysqli_real_escape_string($link, $_POST['kodemk_hidden']);
    $namamk      = mysqli_real_escape_string($link, trim($_POST['namamk']));
    $sks         = (int)$_POST['sks'];

    // Query update data berbasis Kode MK yang divalidasi dari POST hidden
    $query = "UPDATE tbl_matakuliah SET namamk = '$namamk', sks = '$sks' WHERE kodemk = '$kodemk_post'";
    
    if (mysqli_query($link, $query)) {
        $pesan_sukses = true;
    } else {
        $pesan_gagal = "Gagal memperbarui data mata kuliah: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Kuliah - FILKOM</title>
    
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
                    <h2>📝 Kelola Mata Kuliah / <span style="color: #64748b; font-weight: 400;">Ubah Data</span></h2>
                </div>

                <div class="form-box-full">
                    <form action="" method="POST">
                        
                        <input type="hidden" name="kodemk_hidden" value="<?= htmlspecialchars($data['kodemk'] ?? $kodemk_awal); ?>">

                        <div class="form-group">
                            <label>Kode Mata Kuliah</label>
                            <input type="text" value="<?= htmlspecialchars($data['kodemk'] ?? ''); ?>" readonly style="background-color: #e9ecef; color: #495057; cursor: not-allowed; font-weight: 600; text-transform: uppercase;">
                            <small style="color: #64748b; font-size: 0.75rem; margin-top: 4px; display: block;">*Kode mata kuliah tidak dapat diubah karena merupakan kunci utama data.</small>
                        </div>

                        <div class="form-group">
                            <label for="namamk">Nama Mata Kuliah</label>
                            <input type="text" id="namamk" name="namamk" value="<?= htmlspecialchars($data['namamk'] ?? ''); ?>" placeholder="Masukkan nama mata kuliah baru..." required>
                        </div>

                        <div class="form-group">
                            <label for="sks">Bobot SKS</label>
                            <select name="sks" id="sks" required>
                                <option value="">-- Pilih Jumlah SKS --</option>
                                <option value="1" <?= (isset($data['sks']) && $data['sks'] == 1) ? 'selected' : ''; ?>>1 SKS</option>
                                <option value="2" <?= (isset($data['sks']) && $data['sks'] == 2) ? 'selected' : ''; ?>>2 SKS</option>
                                <option value="3" <?= (isset($data['sks']) && $data['sks'] == 3) ? 'selected' : ''; ?>>3 SKS</option>
                                <option value="4" <?= (isset($data['sks']) && $data['sks'] == 4) ? 'selected' : ''; ?>>4 SKS</option>
                                <option value="6" <?= (isset($data['sks']) && $data['sks'] == 6) ? 'selected' : ''; ?>>6 SKS</option>
                            </select>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="ubah" class="btn-mhs btn-mhs-submit">Simpan Perubahan</button>
                            <a href="mata_kuliah.php" class="btn-mhs btn-mhs-cancel">Batal</a>
                        </div>
                        
                    </form>
                </div>
            </div>
        </main>
    </div>

    <?php if ($pesan_sukses): ?>
        <script>
            Swal.fire({
                title: 'Berhasil Berubah!',
                text: 'Data mata kuliah berhasil diperbarui di database!',
                icon: 'success',
                confirmButtonColor: '#005b7f'
            }).then(() => { window.location.href = 'mata_kuliah.php'; });
        </script>
    <?php endif; ?>

    <?php if ($pesan_gagal): ?>
        <script>
            Swal.fire({
                title: 'Gagal Mengubah!',
                text: '<?php echo $pesan_gagal; ?>',
                icon: 'error',
                confirmButtonColor: '#d33'
            });
        </script>
    <?php endif; ?>
</body>
</html>