<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi FILKOM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset & Base Styles */
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f4f7f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Layout Wrapper (Split Screen) */
        .login-wrapper {
            display: flex;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            width: 100%;
            max-width: 960px;
            min-height: 560px;
        }

        /* Sisi Kiri: Branding & Visual */
        .login-branding {
            flex: 1;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
        }

        .branding-content {
            max-width: 340px;
        }

        .brand-logo {
            width: 90px;
            height: auto;
            margin-bottom: 24px;
            background-color: rgba(255, 255, 255, 0.15);
            padding: 10px;
            border-radius: 50%;
        }

        .branding-content h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .branding-content p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
        }

        /* Sisi Kanan: Form Container */
        .login-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px;
            background-color: #ffffff;
        }

        .login-box {
            width: 100%;
            max-width: 360px;
        }

        /* Form Header */
        .login-header {
            margin-bottom: 32px;
        }

        .login-header h2 {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .login-header p {
            font-size: 13px;
            color: #64748b;
        }

        /* Form Controls */
        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 6px;
            color: #475569;
            font-size: 13px;
            font-weight: 500;
        }

        .password-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .input-wrapper-inner input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: #334155;
            outline: none;
            transition: all 0.2s ease;
        }

        .input-wrapper-inner input::placeholder {
            color: #cbd5e1;
        }

        .input-wrapper-inner input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
        }

        /* Button Submit */
        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        /* Responsive Breakpoints (Mobile Friendly) */
        @media (max-width: 768px) {
            .login-wrapper {
                max-width: 450px;
                min-height: auto;
            }

            .login-branding {
                display: none; /* Menyembunyikan visual kiri di HP */
            }

            .login-container {
                padding: 40px 30px;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-branding">
            <div class="branding-content">
                <img src="../images/logo.png" alt="Logo FILKOM" class="brand-logo">
                <h1>Selamat Datang</h1>
                <p>Akses Portal Utama Akademik dan Kemahasiswaan Fakultas Ilmu Komputer.</p>
            </div>
        </div>

        <div class="login-container">
            <div class="login-box">
                <div class="login-header">
                    <h2>Silahkan Login</h2>
                    <p>Gunakan akun SIAM atau kredensial resmi Anda</p>
                </div>

                <form action="proses_login.php" method="POST" class="login-form">
                    <div class="input-group">
                        <label for="username">NIM / Username</label>
                        <div class="input-wrapper-inner">
                            <input type="text" id="username" name="username" required autocomplete="username"
                                placeholder="Masukkan NIM atau Username">
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="password-label-row">
                            <label for="password">Password</label>
                        </div>
                        <div class="input-wrapper-inner">
                            <input type="password" id="password" name="password" required autocomplete="current-password"
                                placeholder="Masukkan password Anda">
                        </div>
                    </div>
                    <button type="submit" class="btn-login">Masuk ke Sistem</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>