<?php
session_start();

// Jika user sudah mengonfirmasi untuk keluar, jalankan penghapusan session
if (isset($_GET['action']) && $_GET['action'] == 'confirm') {
    $_SESSION = [];
    session_unset();
    session_destroy();
    
    // Langsung arahkan ke halaman login setelah bersih
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Keluar - FILKOM</title>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f4f6f9;
        }
        .custom-popup { border-radius: 20px !important; padding: 2rem !important; }
        .custom-title { font-weight: 600 !important; color: #2d3748 !important; }
        .custom-btn { padding: 12px 25px !important; font-weight: 500 !important; border-radius: 10px !important; }
    </style>
</head>
<body>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda akan keluar dari sesi aplikasi saat ini.',
                icon: 'question',
                iconColor: '#3182ce',
                showCancelButton: true,
                confirmButtonColor: '#e53e3e',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                allowOutsideClick: false, // User wajib memilih, tidak bisa klik sembarang tempat
                customClass: {
                    popup: 'custom-popup',
                    title: 'custom-title',
                    confirmButton: 'custom-btn',
                    cancelButton: 'custom-btn'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInUp animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutDown animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika klik YA, reload halaman ini lagi sambil membawa perintah hapus session (?action=confirm)
                    window.location.href = 'logout.php?action=confirm';
                } else {
                    // Jika klik BATAL, kembalikan user ke halaman dashboard utama mahasiswa
                    window.location.href = '../mahasiswa_dashboard/mahasiswa.php'; // Sesuaikan jalur folder Anda jika berbeda
                }
            });
        });
    </script>

</body>
</html>