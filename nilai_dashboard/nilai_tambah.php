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
    $nim   = mysqli_real_escape_string($link, $_POST['nim']);
    $tugas = floatval($_POST['tugas']);
    $uts   = floatval($_POST['uts']);
    $uas   = floatval($_POST['uas']);

    // Hitung Nilai Akhir (Tugas 20%, UTS 30%, UAS 50%)
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

    // Cek dulu apakah mahasiswa tersebut sudah memiliki rekaman nilai agar tidak duplikat
    $cek_duplikat = mysqli_query($link, "SELECT nim FROM tbl_nilai WHERE nim='$nim'");
    
    if (mysqli_num_rows($cek_duplikat) > 0) {
        $pesan_gagal = "Mahasiswa dengan NIM tersebut sudah memiliki rekaman nilai!";
    } else {
        // Query Input data ke tbl_nilai
        $query = "INSERT INTO tbl_nilai (nim, tugas, uts, uas, akhir, hm, status) 
                  VALUES ('$nim', '$tugas', '$uts', '$uas', '$akhir', '$hm', '$status')";
        
        if (mysqli_query($link, $query)) {
            $pesan_sukses = true;
        } else {
            $pesan_gagal = "Gagal menambahkan data nilai: " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Nilai - FILKOM</title>
    
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
                    <h2>🎓 Kelola Nilai / <span style="color: #64748b; font-weight: 400;">Tambah Nilai Mahasiswa</span></h2>
                </div>

                <div class="form-box-full">
                    <form action="" method="POST">
                        
                        <div class="form-group">
                            <label for="nim">Pilih Mahasiswa</label>
                            <select name="nim" id="nim" required>
                                <option value="">-- Pilih Mahasiswa --</option>
                                <?php
                                $mhs_query = mysqli_query($link, "SELECT * FROM tbl_mhs ORDER BY nim ASC");
                                while ($mhs = mysqli_fetch_assoc($mhs_query)) {
                                    echo "<option value='".htmlspecialchars($mhs['nim'])."'>".htmlspecialchars($mhs['nim'])." - ".htmlspecialchars($mhs['namamhs'])."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tugas">Nilai Tugas (Bobot 20%)</label>
                            <input type="number" id="tugas" name="tugas" min="0" max="100" step="0.01" placeholder="Masukkan nilai tugas (0 - 100)..." required>
                        </div>

                        <div class="form-group">
                            <label for="uts">Nilai UTS (Bobot 30%)</label>
                            <input type="number" id="uts" name="uts" min="0" max="100" step="0.01" placeholder="Masukkan nilai UTS (0 - 100)..." required>
                        </div>

                        <div class="form-group">
                            <label for="uas">Nilai UAS (Bobot 50%)</label>
                            <input type="number" id="uas" name="uas" min="0" max="100" step="0.01" placeholder="Masukkan nilai UAS (0 - 100)..." required>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="simpan" class="btn-mhs btn-mhs-submit">Simpan Nilai</button>
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
                text: 'Data nilai mahasiswa berhasil dikalkulasi dan disimpan!',
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