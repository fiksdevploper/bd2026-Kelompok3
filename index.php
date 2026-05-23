<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Fakultas Ilmu Komputer</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <header class="header-site">
        <img src="images/logo.png" alt="Logo BEM FILKOM" class="navbar-logo">
        
        <div class="header-content">
            <?php include "atas.php"; ?>
        </div>
    </header>

    <div class="main-container">
        
        <aside class="sidebar-site">
            <?php include "menu_kiri.php"; ?>
        </aside>

        <main class="content-site"></main>
    </div>

    <footer class="footer-site">
        <?php include "bawah.php"; ?>
    </footer>
</body>
</html>