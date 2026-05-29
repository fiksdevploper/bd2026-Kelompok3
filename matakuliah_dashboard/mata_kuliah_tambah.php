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

// Proses simpan data ketika tombol Simpan diklik
if (isset($_POST['simpan'])) {
    // Mengamankan input teks dan memaksa huruf besar (uppercase) untuk Kode MK agar rapi
    $kodemk = strtoupper(mysqli_real_escape_string($link, trim($_POST['kodemk'])));
    $namamk = mysqli_real_escape_string($link, trim($_POST['namamk']));
    $sks    = (int)$_POST['sks'];

    // 1. Cek terlebih dahulu apakah Kode MK sudah terdaftar agar tidak duplikat (Primary Key)
    $cek_duplikat = mysqli_query($link, "SELECT kodemk FROM tbl_matakuliah WHERE kodemk = '$kodemk'");

    if (mysqli_num_rows($cek_duplikat) > 0) {
        $pesan_gagal = "Kode Mata Kuliah '$kodemk' sudah terdaftar di sistem!";
    } else {
        // 2. Jika aman, eksekusi query INSERT ke tabel tbl_matakuliah
        $query = "INSERT INTO tbl_matakuliah (kodemk, namamk, sks) VALUES ('$kodemk', '$namamk', '$sks')";
        
        if (mysqli_query($link, $query)) {
            $pesan_sukses = true;
        } else {
            $pesan_gagal = "Gagal menambahkan data mata kuliah: " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Kuliah - FILKOM</title>
    
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
                    <h2>📚 Kelola Mata Kuliah / <span style="color: #64748b; font-weight: 400;">Tambah Data</span></h2>
                </div>

                <div class="form-box-full">
                    <form action="" method="POST">
                        
                        <div class="form-group">
                            <label for="kodemk">Kode Mata Kuliah</label>
                            <input type="text" id="kodemk" name="kodemk" placeholder="Contoh: BDAT2, PROG1..." required style="text-transform: uppercase;">
                            <small style="color: #64748b; font-size: 0.75rem; margin-top: 4px; display: block;">*Maksimal 10 karakter tanpa spasi.</small>
                        </div>

                        <div class="form-group">
                            <label for="namamk">Nama Mata Kuliah</label>
                            <input type="text" id="namamk" name="namamk" placeholder="Masukkan nama mata kuliah lengkap..." required>
                        </div>

                        <div class="form-group">
                            <label for="sks">Bobot SKS</label>
                            <select name="sks" id="sks" required>
                                <option value="">-- Pilih Jumlah SKS --</option>
                                <option value="1">1 SKS</option>
                                <option value="2">2 SKS</option>
                                <option value="3">3 SKS</option>
                                <option value="4">4 SKS</option>
                                <option value="6">6 SKS</option>
                            </select>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="simpan" class="btn-mhs btn-mhs-submit">Simpan Mata Kuliah</button>
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
                title: 'Berhasil!',
                text: 'Data mata kuliah baru berhasil ditambahkan ke sistem!',
                icon: 'success',
                confirmButtonColor: '#005b7f'
            }).then(() => { window.location.href = 'mata_kuliah.php'; });
        </script>
    <?php endif; ?>

    <?php if ($pesan_gagal): ?>
        <script>
            Swal.fire({
                title: 'Gagal Menyimpan!',
                text: '<?php echo $pesan_gagal; ?>',
                icon: 'error',
                confirmButtonColor: '#d33'
            });
        </script>
    <?php endif; ?>
</body>
</html>