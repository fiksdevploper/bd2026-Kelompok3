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

// 1. Ambil data nilai yang mau diedit berdasarkan NIM di URL saat halaman dimuat
$nim_awal = isset($_GET['nim']) ? mysqli_real_escape_string($link, $_GET['nim']) : '';

if (!empty($nim_awal)) {
    $ambil_data = mysqli_query($link, "SELECT tbl_nilai.*, tbl_mhs.namamhs FROM tbl_nilai JOIN tbl_mhs ON tbl_nilai.nim = tbl_mhs.nim WHERE tbl_nilai.nim='$nim_awal'");
    $data = mysqli_fetch_assoc($ambil_data);
    
    // Jika data tidak ditemukan di database, langsung kembalikan ke halaman utama
    if (!$data && !isset($_POST['ubah'])) {
        header("Location: nilai.php");
        exit;
    }
} else {
    header("Location: nilai.php");
    exit;
}

// 2. Proses simpan perubahan data ketika tombol ubah ditekan
if (isset($_POST['ubah'])) {
    $nim_post = mysqli_real_escape_string($link, $_POST['nim_hidden']);
    $tugas    = floatval($_POST['tugas']);
    $uts      = floatval($_POST['uts']);
    $uas      = floatval($_POST['uas']);

    // Hitung ulang Nilai Akhir (Tugas 20%, UTS 30%, UAS 50%)
    $akhir = ($tugas * 0.2) + ($uts * 0.3) + ($uas * 0.5);

    // Tentukan Huruf Mutu (HM) dan Status Kelulusan
    if ($akhir >= 80) { 
        $hm = 'A'; 
        $status = 'Lulus Sangat Memuaskan'; 
    } elseif ($akhir >= 70) { 
        $hm = 'B'; 
        $status = 'Lulus Memuaskan'; 
    } elseif ($akhir >= 60) { 
        $hm = 'C'; 
        $status = 'Lulus'; 
    } else { 
        $hm = 'E'; 
        $status = 'Tidak Lulus'; 
    }

    // Query update data berbasis NIM yang divalidasi dari POST hidden
    $query = "UPDATE tbl_nilai SET tugas='$tugas', uts='$uts', uas='$uas', akhir='$akhir', hm='$hm', status='$status' WHERE nim='$nim_post'";
    
    if (mysqli_query($link, $query)) {
        $pesan_sukses = true;
    } else {
        $pesan_gagal = "Gagal memperbarui data nilai: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai - FILKOM</title>
    
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
                    <h2>📝 Kelola Nilai / <span style="color: #64748b; font-weight: 400;">Ubah Nilai Mahasiswa</span></h2>
                </div>

                <div class="form-box-full">
                    <form action="" method="POST">
                        
                        <input type="hidden" name="nim_hidden" value="<?= htmlspecialchars($data['nim'] ?? $nim_awal); ?>">

                        <div class="form-group">
                            <label>Identitas Mahasiswa</label>
                            <input type="text" value="<?= htmlspecialchars(($data['nim'] ?? '') . ' - ' . ($data['namamhs'] ?? '')); ?>" readonly style="background-color: #e9ecef; color: #495057; cursor: not-allowed; font-weight: 500;">
                        </div>

                        <div class="form-group">
                            <label for="tugas">Nilai Tugas (Bobot 20%)</label>
                            <input type="number" id="tugas" name="tugas" value="<?= htmlspecialchars($data['tugas'] ?? '0'); ?>" min="0" max="100" step="0.01" placeholder="Masukkan nilai tugas..." required>
                        </div>

                        <div class="form-group">
                            <label for="uts">Nilai UTS (Bobot 30%)</label>
                            <input type="number" id="uts" name="uts" value="<?= htmlspecialchars($data['uts'] ?? '0'); ?>" min="0" max="100" step="0.01" placeholder="Masukkan nilai UTS..." required>
                        </div>

                        <div class="form-group">
                            <label for="uas">Nilai UAS (Bobot 50%)</label>
                            <input type="number" id="uas" name="uas" value="<?= htmlspecialchars($data['uas'] ?? '0'); ?>" min="0" max="100" step="0.01" placeholder="Masukkan nilai UAS..." required>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="ubah" class="btn-mhs btn-mhs-submit">Simpan Perubahan</button>
                            <a href="nilai.php" class="btn-mhs btn-mhs-cancel">Batal</a>
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
                text: 'Perubahan data nilai mahasiswa berhasil diperbarui!',
                icon: 'success',
                confirmButtonColor: '#005b7f'
            }).then(() => { window.location.href = 'nilai.php'; });
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