<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../koneksi.php';

// Ambil NID dari URL saat pertama kali halaman dimuat
$nid = isset($_GET['nid']) ? mysqli_real_escape_string($link, $_GET['nid']) : '';

// Mengambil data dosen yang akan diubah
$query = mysqli_query($link, "SELECT * FROM tbl_dosen WHERE nid='$nid'");
$data = mysqli_fetch_assoc($query);

// Jika menekan tombol ubah
if (isset($_POST['ubah'])) {
    // PERBAIKAN 1: Ambil NID dari input hidden POST, bukan dari GET
    $nid_post = mysqli_real_escape_string($link, $_POST['nid']);
    $namados  = mysqli_real_escape_string($link, $_POST['namados']);

    $update_query = "UPDATE tbl_dosen SET namados='$namados' WHERE nid='$nid_post'";
    
    if (mysqli_query($link, $update_query)) {
        header("Location: dosen.php");
        exit;
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($link);
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
    <title>Ubah Dosen</title>

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/crud.css">
</head>

<body>

<div class="table-container">

    <div class="table-header">
        <h2>Ubah Data Dosen</h2>
    </div>

    <form method="POST">

        <input type="hidden" name="nid" value="<?php echo htmlspecialchars($data['nid'] ?? $_POST['nid']); ?>">

        <div class="form-group">
            <label>NID</label> 
            <input type="text" name="nid" value="<?php echo htmlspecialchars($data['nid']); ?>" readonly>
        </div>

        <div class="form-group">
            <label>Nama Dosen</label>
            <input type="text" name="namados" value="<?php echo htmlspecialchars($data['namados'] ?? $_POST['namados']); ?>" required>
        </div>

        <br>

        <button type="submit" name="ubah" class="btn btn-primary">
            Ubah
        </button>
        <a href="dosen.php" class="btn btn-secondary" style="text-decoration: none; margin-left: 10px;">Batal</a>

    </form>

</div>

</body>
</html>