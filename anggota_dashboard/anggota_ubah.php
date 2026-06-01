<?php
// Koneksi langsung ke database agar aman
$koneksi = mysqli_connect("localhost", "root", "", "basisdata2026");

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

// Inisialisasi variabel untuk status SweetAlert2
$alert_status = '';

// 1. AMBIL DATA LAMA UNTUK DITAMPILKAN DI FORM
if (isset($_GET['nim'])) {
    $nim_edit = mysqli_real_escape_string($koneksi, $_GET['nim']);
    $ambil = mysqli_query($koneksi, "SELECT * FROM tbl_anggota WHERE nim='$nim_edit'");
    $data = mysqli_fetch_array($ambil);
    
    if (!$data) {
        header("Location: anggota.php");
        exit;
    }
} else {
    header("Location: anggota.php");
    exit;
}

// 2. PROSES UPDATE SAAT TOMBOL PERBARUI DATA DIKLIK
if (isset($_POST['btn_update'])) {
    $nim = mysqli_real_escape_string($koneksi, $_POST['nim']); 
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);

    // Jalankan query update untuk mengubah nama berdasarkan NIM tersebut
    $update = mysqli_query($koneksi, "UPDATE tbl_anggota SET nama='$nama' WHERE nim='$nim'");
    
    if ($update) {
        $alert_status = 'success';
    } else {
        $alert_status = 'failed';
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Anggota - FILKOM</title>

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/crud.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }

        /* Style Kustom SweetAlert2 Profesional agar Seragam Seluruh Sistem */
        .swal2-professional-popup {
            border-radius: 16px !important;
            padding: 2rem !important;
        }
        .swal2-professional-title {
            font-size: 1.3rem !important;
            font-weight: 600 !important;
            color: #1e293b !important;
        }
        .swal2-professional-html {
            font-size: 0.95rem !important;
            color: #64748b !important;
        }
        .swal2-professional-btn {
            padding: 10px 28px !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            font-size: 0.9rem !important;
        }
    </style>
</head>

<body>
    <header class="header-site">
        <img src="../images/logo.png" alt="Logo BEM FILKOM" class="navbar-logo">
        <div class="header-content">
            <?php include "../layouts/atas.php"; ?>
        </div>
    </header>

    <div class="main-container">
        <aside class="sidebar-site">
            <?php include "../layouts/menu_kiri.php"; ?>
        </aside>

        <main class="content-site">
            <div class="crud-breadcrumb" style="font-size: 20px; font-weight: bold; margin-bottom: 25px; color: #1e293b;">
                🎓 Kelola Anggota / <span style="color: #64748b; font-weight: normal;">Ubah Data</span>
            </div>

            <div class="form-container" style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01), 0 2px 4px -1px rgba(0,0,0,0.01); border: 1px solid #e2e8f0;">
                <form action="anggota_ubah.php?nim=<?php echo urlencode($data['nim']); ?>" method="POST">
                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 500; margin-bottom: 8px; color: #334155; font-size: 14px;">NIM (Kunci Utama - Tidak Dapat Diubah)</label>
                        <input type="text" name="nim" value="<?php echo htmlspecialchars($data['nim']); ?>" readonly 
                               style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 14px; background-color: #f1f5f9; color: #64748b; cursor: not-allowed; font-weight: 500;">
                    </div>

                    <div class="form-group" style="margin-bottom: 25px;">
                        <label style="display: block; font-weight: 500; margin-bottom: 8px; color: #334155; font-size: 14px;">Nama Lengkap Anggota</label>
                        <input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required 
                               style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 14px; background-color: #ffffff; color: #1e293b; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='#1d6fa5'" onblur="this.style.borderColor='#cbd5e1'">
                    </div>

                    <div class="btn-group" style="display: flex; align-items: center; gap: 15px;">
                        <button type="submit" name="btn_update" class="btn" 
                                style="background-color: #1d6fa5; color: white; padding: 11px 24px; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; font-size: 14px; transition: background 0.2s;"
                                onmouseover="this.style.backgroundColor='#15527a'" onmouseout="this.style.backgroundColor='#1d6fa5'">
                            Perbarui Data
                        </button>
                        <a href="anggota.php" class="btn-batal" 
                           style="color: #64748b; text-decoration: none; font-size: 14px; font-weight: 500; padding: 10px 15px; border-radius: 8px; background-color: #f8fafc; border: 1px solid #e2e8f0; text-align: center; transition: all 0.2s;"
                           onmouseover="this.style.backgroundColor='#f1f5f9'; this.style.color='#334155'" onmouseout="this.style.backgroundColor='#f8fafc'; this.style.color='#64748b'">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </main>
    </div>

    <footer class="footer-site">
        <?php include "../layouts/bawah.php"; ?>
    </footer>

    <?php if ($alert_status === 'success'): ?>
        <script>
            Swal.fire({
                title: 'Berhasil Diperbarui!',
                text: 'Data nama anggota kelompok telah aman disimpan.',
                icon: 'success',
                iconColor: '#10b981',
                confirmButtonText: 'Selesai',
                confirmButtonColor: '#1d6fa5',
                customClass: {
                    popup: 'swal2-professional-popup',
                    title: 'swal2-professional-title',
                    htmlContainer: 'swal2-professional-html',
                    confirmButton: 'swal2-professional-btn'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInUp animate__faster'
                }
            }).then(() => {
                window.location = 'anggota.php';
            });
        </script>
    <?php elseif ($alert_status === 'failed'): ?>
        <script>
            Swal.fire({
                title: 'Gagal Memperbarui!',
                text: 'Terjadi kendala sistem saat berkomunikasi dengan basis data.',
                icon: 'error',
                iconColor: '#ef4444',
                confirmButtonText: 'Coba Lagi',
                confirmButtonColor: '#64748b',
                customClass: {
                    popup: 'swal2-professional-popup',
                    title: 'swal2-professional-title',
                    htmlContainer: 'swal2-professional-html',
                    confirmButton: 'swal2-professional-btn'
                }
            });
        </script>
    <?php endif; ?>
</body>

</html>