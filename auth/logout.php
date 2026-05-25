<?php
session_start();

// Hapus semua data session yang menempel
$_SESSION = [];
session_unset();
session_destroy();

// Tampilkan pesan dan kembalikan ke halaman login
echo "<script>
        alert('Anda telah berhasil keluar dari sistem.');
        window.location.href = 'login.php';
      </script>";
exit;
?>