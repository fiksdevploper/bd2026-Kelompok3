<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../koneksi.php';

if (isset($_POST['simpan'])) {

    // PERBAIKAN: Mengubah variabel dari nim menjadi nid sesuai database
    $nid     = mysqli_real_escape_string($link, $_POST['nid']);
    $namados = mysqli_real_escape_string($link, $_POST['namados']);

    // PERBAIKAN: Cek duplikasi berdasarkan kolom nid
    $cek = mysqli_query($link, "SELECT nid FROM tbl_dosen WHERE nid='$nid'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
        alert('NID sudah terdaftar!');
        window.location='dosen_tambah.php';
        </script>";
    } else {
        // PERBAIKAN: Menggunakan nama kolom 'nid' bukan 'nim'
        $query = "INSERT INTO tbl_dosen (nid, namados) VALUES ('$nid', '$namados')";

        if (mysqli_query($link, $query)) {
            header("Location: dosen.php");
            exit;
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Dosen</title>

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/crud.css">
</head>

<body>

<div class="table-container">

    <div class="table-header">
        <h2>Tambah Data Dosen</h2>
    </div>

    <form method="POST">

        <div class="form-group">
            <label>NID</label>
            <input type="text" name="nid" placeholder="Masukkan NID..." required>
        </div>

        <div class="form-group">
            <label>Nama Dosen</label>
            <input type="text" name="namados" placeholder="Masukkan Nama Lengkap..." required>
        </div>

        <br>

        <button type="submit" name="simpan" class="btn btn-primary">
            Simpan
        </button>

        <a href="dosen.php" class="btn btn-delete" style="text-decoration: none; display: inline-block; text-align: center;">
            Kembali
        </a>

    </form>

</div>

</body>
</html>