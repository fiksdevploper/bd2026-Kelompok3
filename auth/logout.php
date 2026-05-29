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
            background-color: #f1f5f9; /* Menyamakan background dashboard */
        }
        
        /* Kustomisasi Wrapper Utama SweetAlert2 */
        .custom-popup { 
            border-radius: 16px !important; 
            padding: 2rem !important;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1) !important;
        }
        
        /* Kustomisasi Teks Judul */
        .custom-title { 
            font-size: 1.4rem !important;
            font-weight: 600 !important; 
            color: #1e293b !important; 
            padding-top: 10px !important;
        }

        /* Kustomisasi Teks Deskripsi */
        .custom-html-content {
            color: #64748b !important;
            font-size: 0.95rem !important;
            margin-top: 8px !important;
        }
        
        /* Overriding style tombol bawaan agar serasi dengan crud.css */
        .custom-confirm-btn {
            padding: 10px 24px !important;
            font-weight: 500 !important;
            font-size: 0.9rem !important;
            border-radius: 8px !important;
            box-shadow: none !important;
            transition: all 0.2s ease;
        }
        
        .custom-cancel-btn {
            padding: 10px 24px !important;
            font-weight: 500 !important;
            font-size: 0.9rem !important;
            border-radius: 8px !important;
            box-shadow: none !important;
            transition: all 0.2s ease;
        }

        .custom-confirm-btn:hover {
            opacity: 0.9;
        }

        .custom-cancel-btn:hover {
            background-color: #475569 !important; /* Efek hover abu-abu lebih gelap */
        }
    </style>
</head>
<body>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Konfirmasi Keluar Sesi',
                html: 'Apakah Anda yakin ingin meninggalkan aplikasi? <br><span style="font-size: 0.85rem; color: #94a3b8;">Anda harus login kembali untuk mengakses dasbor.</span>',
                icon: 'warning', /* Mengubah ikon ke warning (segitiga eksklamasi) karena sifatnya memutus sesi */
                iconColor: '#f59e0b', /* Warna amber/oranye hangat yang lebih profesional daripada biru default */
                showCancelButton: true,
                confirmButtonColor: '#ef4444', /* Merah modern (Tailwind Red 500) */
                cancelButtonColor: '#64748b',  /* Abu-abu slate yang seimbang (Tailwind Slate 500) */
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                allowOutsideClick: false, // User wajib berinteraksi dengan tombol
                customClass: {
                    popup: 'custom-popup',
                    title: 'custom-title',
                    htmlContainer: 'custom-html-content',
                    confirmButton: 'custom-confirm-btn',
                    cancelButton: 'custom-cancel-btn'
                },
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster' /* Efek zoom-in yang ringkas dan responsif */
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika klik YA, reload halaman ini kembali dengan parameter konfirmasi
                    window.location.href = 'logout.php?action=confirm';
                } else {
                    // Jika klik BATAL, kembalikan user ke halaman dashboard utama mahasiswa
                    window.location.href = '../mahasiswa_dashboard/mahasiswa.php';
                }
            });
        });
    </script>

</body>
</html>