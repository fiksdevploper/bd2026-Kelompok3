<?php
session_start();

// 1. Proteksi Halaman: Pastikan user sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

// 2. Panggil Koneksi Database
require_once '../koneksi.php';

// 3. Cek apakah ada parameter NIM yang dikirim lewat URL
if (isset($_GET['nim'])) {
    $nim = mysqli_real_escape_string($link, $_GET['nim']);

    // 4. Jalankan Query Delete
    $query = "DELETE FROM tbl_mhs WHERE nim = '$nim'";
    $exec = mysqli_query($link, $query);

    // 5. Berikan feedback menggunakan SweetAlert2 sebelum redirect
    ?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>Memproses Hapus Data...</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f4f6f9;
            }

            /* Custom CSS untuk mempercantik elemen internal SweetAlert2 */
            .custom-popup {
                border-radius: 20px !important;
                padding: 2rem !important;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
            }

            .custom-title {
                font-weight: 600 !important;
                color: #2d3748 !important;
                font-size: 24px !important;
            }

            .custom-html {
                color: #718096 !important;
                font-size: 15px !important;
            }

            .custom-confirm-btn {
                padding: 12px 30px !important;
                font-weight: 500 !important;
                font-size: 15px !important;
                border-radius: 10px !important;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
                transition: all 0.3s ease !important;
            }

            .custom-confirm-btn:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 7px 20px rgba(0, 0, 0, 0.15) !important;
            }
        </style>
    </head>

    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                <?php if ($exec): ?>
                    // Desain UI untuk Berhasil Hapus
                    Swal.fire({
                        title: 'Berhasil Dihapus!',
                        html: 'Data mahasiswa dengan NIM <b style="color: #e53e3e;"><?php echo $nim; ?></b> telah dihapus dari sistem.',
                        icon: 'success',
                        iconColor: '#38a169',
                        background: '#ffffff',
                        confirmButtonText: 'Selesai',
                        confirmButtonColor: '#38a169',
                        customClass: {
                            popup: 'custom-popup',
                            title: 'custom-title',
                            htmlContainer: 'custom-html',
                            confirmButton: 'custom-confirm-btn'
                        },
                        showClass: {
                            popup: 'animate__animated animate__fadeInUp animate__faster'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutDown animate__faster'
                        }
                    }).then(() => {
                        window.location.href = 'mahasiswa.php';
                    });
                <?php else: ?>
                    // Desain UI untuk Gagal Hapus
                    Swal.fire({
                        title: 'Gagal Menghapus!',
                        html: 'Terjadi gangguan pada server.<br><small style="color: #a0aec0;">Detail: <?php echo mysqli_real_escape_string($link, mysqli_error($link)); ?></small>',
                        icon: 'error',
                        iconColor: '#e53e3e',
                        background: '#ffffff',
                        confirmButtonText: 'Kembali',
                        confirmButtonColor: '#4a5568',
                        customClass: {
                            popup: 'custom-popup',
                            title: 'custom-title',
                            htmlContainer: 'custom-html',
                            confirmButton: 'custom-confirm-btn'
                        },
                        showClass: {
                            popup: 'animate__animated animate__shakeX animate__faster'
                        }
                    }).then(() => {
                        window.location.href = 'mahasiswa.php';
                    });
                <?php endif; ?>
            });
        </script>
    </body>

    </html>
    <?php
} else {
    header("Location: mahasiswa.php");
    exit;
}
?>