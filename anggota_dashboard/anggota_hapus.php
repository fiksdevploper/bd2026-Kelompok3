<?php
// Koneksi langsung mandiri ke database
$koneksi = mysqli_connect("localhost", "root", "", "basisdata2026");

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
    exit();
}

// Ambil parameter NIM dari URL secara aman
if (isset($_GET['nim'])) {
    $nim_hapus = mysqli_real_escape_string($koneksi, $_GET['nim']);

    // Jalankan query hapus data
    $hapus = mysqli_query($koneksi, "DELETE FROM tbl_anggota WHERE nim='$nim_hapus'");

    if ($hapus) {
        // Alihkan kembali ke halaman utama dengan melempar status sukses
        header("Location: anggota.php?status=success_delete");
        exit();
    } else {
        // Alihkan kembali dengan melempar status gagal
        header("Location: anggota.php?status=failed_delete");
        exit();
    }
} else {
    // Jika diakses ilegal tanpa parameter NIM
    header("Location: anggota.php");
    exit();
}
?>