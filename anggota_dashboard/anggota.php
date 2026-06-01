<?php
// Koneksi langsung ke database agar aman
$koneksi = mysqli_connect("localhost", "root", "", "basisdata2026");

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota Kelompok 3 - FILKOM</title>

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/crud.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ───────── RE-STYLING GLOBAL & TABEL KONSISTEN ───────── */
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f8fafc;
        }

        .table-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01), 0 2px 4px -1px rgba(0,0,0,0.01);
            border: 1px solid #e2e8f0;
        }

        .table-header h2 {
            color: #1e293b;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .crud-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .crud-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: 600;
            font-size: 14px;
            padding: 14px 16px;
            border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .crud-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 14px;
            vertical-align: middle;
        }

        .crud-table tbody tr {
            transition: background-color 0.2s ease;
        }
        .crud-table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* ───────── STYLING TOMBOL AKSI KONSISTEN ───────── */
        .btn-tambah-premium {
            background-color: #1d6fa5;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
            transition: background-color 0.2s;
        }
        .btn-tambah-premium:hover {
            background-color: #15527a;
        }

        .btn-ubah-premium {
            background-color: #fef3c7;
            color: #d97706;
            padding: 6px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            display: inline-block;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-ubah-premium:hover {
            background-color: #fde68a;
            transform: translateY(-1px);
        }

        .btn-hapus-premium {
            background-color: #fee2e2;
            color: #dc2626;
            padding: 6px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            display: inline-block;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .btn-hapus-premium:hover {
            background-color: #fecaca;
            transform: translateY(-1px);
        }

        /* ───────── SWEETALERT2 STYLES ───────── */
        .swal2-professional-popup {
            border-radius: 16px !important;
            padding: 2.5rem 2rem 2rem 2rem !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1) !important;
        }
        .swal2-professional-title {
            font-size: 1.35rem !important;
            font-weight: 600 !important;
            color: #1e293b !important;
        }
        .swal2-professional-html {
            font-size: 0.95rem !important;
            color: #64748b !important;
            line-height: 1.6 !important;
        }
        .swal2-professional-confirm-btn {
            background-color: #ef4444 !important;
            color: white !important;
            font-size: 0.9rem !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            padding: 10px 24px !important;
        }
        .swal2-professional-cancel-btn {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
            font-size: 0.9rem !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            padding: 10px 24px !important;
        }
        
        /* Tombol konfirmasi khusus alert sukses */
        .swal2-professional-success-btn {
            background-color: #1d6fa5 !important;
            color: white !important;
            font-size: 0.9rem !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            padding: 10px 24px !important;
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
            <div class="table-container">
                <div class="table-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>🎓 Data Anggota Kelompok 3 Fakultas Ilmu Komputer</h2>
                    <a href="anggota_tambah.php" class="btn-tambah-premium">+ Tambah Anggota</a>
                </div>

                <table class="crud-table">
                    <thead>
                        <tr>
                            <th width="8%" style="text-align: center;">No</th>
                            <th width="25%" style="text-align: center;">NIM</th>
                            <th width="47%">Nama Mahasiswa</th>
                            <th width="20%" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1; 
                        $query = mysqli_query($koneksi, "SELECT * FROM tbl_anggota ORDER BY nim DESC");

                        if (mysqli_num_rows($query) == 0) {
                            echo "<tr><td colspan='4' style='text-align:center; color:#64748b; padding: 30px; font-weight: 500;'>Belum ada data anggota kelompok.</td></tr>";
                        } else {
                            while ($row = mysqli_fetch_array($query)) {
                                $nim_mhs = $row['nim'];
                                $nama_mhs = strtoupper($row['nama']);
                                
                                echo "<tr>";
                                echo "<td style='text-align:center; color: #94a3b8;'>$no</td>";
                                echo "<td style='text-align:center; font-weight:600; color: #1e293b;'>$nim_mhs</td>";
                                echo "<td style='padding-left: 15px; font-weight: 500;'>$nama_mhs</td>";
                                echo "<td style='text-align:center; display: flex; justify-content: center; gap: 8px;'>
                                        <a href='anggota_ubah.php?nim=$nim_mhs' class='btn-ubah-premium'>Ubah</a>
                                        <button onclick=\"konfirmasiHapus('$nim_mhs', '$nama_mhs')\" class='btn-hapus-premium'>Hapus</button>
                                      </td>";
                                echo "</tr>";
                                $no++; 
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <footer class="footer-site">
        <?php include "../layouts/bawah.php"; ?>
    </footer>

    <script>
    // 1. Pemicu Alert Konfirmasi Sebelum Hapus Data
    function konfirmasiHapus(nim, nama) {
        Swal.fire({
            title: 'Konfirmasi Penghapusan',
            html: `Apakah Anda yakin ingin menghapus anggota kelompok:<br><span style="font-weight:600; color:#ef4444; display:inline-block; margin-top:5px;">${nama}</span><br><small style="color:#94a3b8;">NIM: ${nim}</small>`,
            icon: 'warning',
            iconColor: '#f59e0b',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Data',
            cancelButtonText: 'Batalkan',
            reverseButtons: true, 
            customClass: {
                popup: 'swal2-professional-popup',
                title: 'swal2-professional-title',
                htmlContainer: 'swal2-professional-html',
                confirmButton: 'swal2-professional-confirm-btn',
                cancelButton: 'swal2-professional-cancel-btn'
            },
            showClass: { popup: 'animate__animated animate__zoomIn animate__faster' },
            hideClass: { popup: 'animate__animated animate__fadeOut animate__faster' }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `anggota_hapus.php?nim=${nim}`;
            }
        })
    }
    </script>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'success_delete'): ?>
        <script>
            Swal.fire({
                title: 'Berhasil Dihapus!',
                text: 'Data anggota tersebut telah permanen dikeluarkan dari sistem.',
                icon: 'success',
                iconColor: '#10b981',
                confirmButtonText: 'Selesai',
                customClass: {
                    popup: 'swal2-professional-popup',
                    title: 'swal2-professional-title',
                    htmlContainer: 'swal2-professional-html',
                    confirmButton: 'swal2-professional-success-btn'
                }
            }).then(() => {
                // Bersihkan parameter status di URL agar tidak memicu alert berulang saat refresh
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        </script>
    <?php elseif (isset($_GET['status']) && $_GET['status'] === 'failed_delete'): ?>
        <script>
            Swal.fire({
                title: 'Gagal Menghapus!',
                text: 'Terjadi kendala teknis internal pada sistem basis data.',
                icon: 'error',
                iconColor: '#ef4444',
                confirmButtonText: 'Kembali',
                customClass: {
                    popup: 'swal2-professional-popup',
                    title: 'swal2-professional-title',
                    htmlContainer: 'swal2-professional-html',
                    confirmButton: 'swal2-professional-cancel-btn'
                }
            }).then(() => {
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        </script>
    <?php endif; ?>
</body>

</html>