<?php
session_start();

// 1. Proteksi Halaman
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

// 2. Panggil Koneksi Database
require_once '../koneksi.php';

// 3. Ambil Data Mahasiswa (Sesuai dengan kolom tabel database Anda)
$query = "SELECT nim, namamhs, handphone FROM tbl_mhs ORDER BY nim ASC";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - FILKOM</title>

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/crud.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .custom-popup { border-radius: 20px !important; padding: 2rem !important; }
        .custom-title { font-weight: 600 !important; color: #2d3748 !important; }
        .custom-btn { padding: 12px 25px !important; font-weight: 500 !important; border-radius: 10px !important; }
    </style>
</head>

<body>
    <header class="header-site">
        <div class="header-content">
            <?php include "../layouts/atas.php"; ?>
        </div>
    </header>

    <div class="main-container">
        <aside class="sidebar-site">
            <?php include "../layouts/menu_kiri.php"; ?>
        </aside>

        <main class="content-site">
            <div class="table-container">
                <div class="table-header">
                    <h2>👨‍🎓 Data Mahasiswa Fakultas Ilmu Komputer</h2>
                    <a href="mahasiswa_tambah.php" class="btn btn-primary">+ Tambah Mahasiswa</a>
                </div>

                <table class="crud-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">NIM</th>
                            <th width="45%">Nama Mahasiswa</th>
                            <th width="20%">No. Handphone</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && mysqli_num_rows($result) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nim']); ?></td>
                                    <td><?php echo htmlspecialchars($row['namamhs']); ?></td>
                                    <td><?php echo htmlspecialchars($row['handphone']); ?></td>
                                    <td>
                                        <a href="mahasiswa_ubah.php?nim=<?php echo urlencode($row['nim']); ?>" class="btn-action btn-edit">
                                            Ubah
                                        </a>
                                        
                                        <a href="#" class="btn-action btn-delete btn-hapus-action" 
                                        data-nim="<?php echo htmlspecialchars($row['nim']); ?>" 
                                        data-nama="<?php echo htmlspecialchars($row['namamhs'], ENT_QUOTES, 'UTF-8'); ?>">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                        <?php 
                            }
                        } else { 
                        ?>
                            <tr>
                                <td colspan="5" style="text-align:center;">Belum ada data mahasiswa</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Menangkap aksi klik pada semua elemen tombol hapus
            document.querySelectorAll('.btn-hapus-action').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Menghentikan link '#' melompat ke atas halaman
                    
                    // Ekstrak data dari atribut HTML aman
                    const nim = this.getAttribute('data-nim');
                    const nama = this.getAttribute('data-nama');
                    
                    // Tampilkan SweetAlert2 Konfirmasi Modern
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Anda akan menghapus mahasiswa bernama <br><b style="color:#e53e3e;">${nama}</b> (${nim})`,
                        icon: 'warning',
                        iconColor: '#ecc94b',
                        showCancelButton: true,
                        confirmButtonColor: '#e53e3e',
                        cancelButtonColor: '#718096',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
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
                            // Alihkan ke file mahasiswa_hapus.php dengan aman bawa parameter NIM
                            window.location.href = `mahasiswa_hapus.php?nim=${nim}`;
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>