<?php
session_start();

// Validasi login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../koneksi.php';

// Pastikan parameter 'nid' ada di URL sebelum dieksekusi
if (isset($_GET['nid'])) {
    
    // PERBAIKAN: Mengubah nim menjadi nid & mengamankan variabel dari SQL Injection
    $nid = mysqli_real_escape_string($link, $_GET['nid']);

    // PERBAIKAN: Mengubah nama kolom di query dari nim menjadi nid
    $query = "DELETE FROM tbl_dosen WHERE nid='$nid'";
    
    if (mysqli_query($link, $query)) {
        // Jika sukses, alihkan kembali ke halaman utama dosen
        header("Location: dosen.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($link);
    }
} else {
    // Jika tidak ada parameter nid di URL, langsung kembalikan ke halaman dosen
    header("Location: dosen.php");
    exit;
}
?>