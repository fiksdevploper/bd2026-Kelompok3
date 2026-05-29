<?php
include "../koneksi.php";

// Mengambil parameter nim dari URL tombol hapus
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Query hapus data nilai berdasarkan nim
    $query = "DELETE FROM tbl_nilai WHERE nim = '$nim'";
    
    if (mysqli_query($link, $query)) {
        echo "<script>alert('Data nilai berhasil dihapus!'); window.location='nilai.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='nilai.php';</script>";
    }
} else {
    header("Location: nilai.php");
}
?>