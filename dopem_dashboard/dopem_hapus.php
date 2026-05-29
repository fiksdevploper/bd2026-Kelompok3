<?php
include "../koneksi.php";
global $link;

// Ambil parameter NIM yang mau dihapus relasinya
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Hapus data plot bimbingan di tbl_dopem berdasarkan NIM mahasiswa
    $hapus = mysqli_query($link, "DELETE FROM tbl_dopem WHERE nim = '$nim'");

    if ($hapus) {
        echo "<script>alert('Data bimbingan berhasil dihapus!'); window.location='dopem.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data bimbingan!'); window.location='dopem.php';</script>";
    }
} else {
    header("Location: dopem.php");
}
?>