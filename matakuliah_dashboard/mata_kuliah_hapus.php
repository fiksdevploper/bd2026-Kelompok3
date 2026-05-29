<?php
session_start();

// Proteksi halaman dashboard
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

// Memanggil koneksi database dari folder luar
require_once '../koneksi.php';
global $link;

$pesan_gagal = false;

if (isset($_GET['kodemk'])) {
    $kodemk = mysqli_real_escape_string($link, $_GET['kodemk']);
    
    // Mengaktifkan mode pengecualian manual agar error Foreign Key bisa ditangkap dengan try-catch
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    try {
        // Eksekusi query hapus data pada tbl_matakuliah
        $query = "DELETE FROM tbl_matakuliah WHERE kodemk = '$kodemk'";
        $execute = mysqli_query($link, $query);
        
        // Jika berhasil tanpa hambatan, langsung lempar kembali ke halaman utama dengan tanda sukses
        if ($execute) {
            echo "<!DOCTYPE html>
            <html lang='id'>
            <head>
                <meta charset='UTF-8'>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        title: 'Berhasil Dihapus!',
                        text: 'Mata kuliah dengan kode $kodemk telah dihapus dari sistem.',
                        icon: 'success',
                        confirmButtonColor: '#005b7f'
                    }).then(() => { window.location.href = 'mata_kuliah.php'; });
                </script>
            </body>
            </html>";
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        // Menangkap error nomor 1451 (Cannot delete or update a parent row: a foreign key constraint fails)
        if ($e->getCode() == 1451) {
            $pesan_gagal = "Mata kuliah tidak bisa dihapus karena masih digunakan dalam data nilai mahasiswa! Silakan hapus data nilai terkait terlebih dahulu.";
        } else {
            $pesan_gagal = "Gagal menghapus data: " . $e->getMessage();
        }
    }
} else {
    header("Location: mata_kuliah.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Proses Hapus Mata Kuliah</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php if ($pesan_gagal): ?>
        <script>
            Swal.fire({
                title: 'Gagal Menghapus!',
                text: '<?php echo $pesan_gagal; ?>',
                icon: 'error',
                confirmButtonColor: '#d33'
            }).then(() => { window.location.href = 'mata_kuliah.php'; });
        </script>
    <?php endif; ?>
</body>
</html>