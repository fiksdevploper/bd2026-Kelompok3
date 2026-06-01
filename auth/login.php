<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistem Informasi FILKOM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600&family=DM+Sans:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --navy: #0C1F3F;
            --navy-mid: #132848;
            --navy-light: #1B3560;
            --gold: #C9A84C;
            --white: #FFFFFF;
            --off-white: #F1F5F9;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border: #E2E8F0;
            --blue-focus: rgba(37, 99, 235, 0.15);
            --input-bg: #F8FAFC;
        }

        html,
        body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: var(--off-white);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
            
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        /* Background grid pattern halus agar tidak sepi */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(to right, rgba(15, 23, 42, 0.02) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(15, 23, 42, 0.02) 1px, transparent 1px);
            background-size: 24px 24px;
            z-index: 0;
        }

        /* ───────── LOGIN CONTAINER ───────── */
        .login-card {
            width: 100%;
            max-width: 480px; 
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 
                        0 10px 10px -5px rgba(15, 23, 42, 0.04);
            border: 1px solid var(--border);
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        /* Header dengan struktur visual yang tegas */
        .brand-header {
            background: linear-gradient(to bottom right, var(--navy), var(--navy-mid));
            padding: 40px 40px 32px 40px;
            text-align: center;
            position: relative;
        }

        /* Efek kilau emas halus di header */
        .brand-header::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 150px; height: 150px;
            background: radial-gradient(circle, rgba(201, 168, 76, 0.08) 0%, transparent 70%);
        }

        /* MODIFIKASI: Wrapper khusus untuk Logo Bulat Institusi */
        .brand-logo-wrapper {
            display: inline-flex;
            padding: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin-bottom: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .brand-logo-img {
            width: 80px;  /* Ukuran logo dioptimalkan agar detail tulisan melingkar tetap terbaca */
            height: 80px;
            object-fit: contain;
            display: block;
            border-radius: 50%;
            background: var(--white); /* Memberi kontras bersih pada logo bulat */
            padding: 2px;
        }

        .brand-header h1 {
            font-family: 'Sora', sans-serif;
            font-size: 24px;
            font-weight: 600;
            color: var(--white);
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .brand-header p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.5;
        }

        /* Form Area dengan Padding Luas */
        .form-body {
            padding: 40px 40px 32px 40px;
        }

        /* ───────── FORM ELEMENTS ───────── */
        .field {
            margin-bottom: 24px;
        }

        .field label {
            display: block;
            font-size: 13.5px;
            font-weight: 500;
            color: #334155;
            margin-bottom: 8px;
        }

        .field-inner {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            display: flex;
            pointer-events: none;
        }

        .field-icon svg {
            width: 19px;
            height: 19px;
        }

        .field-inner input {
            width: 100%;
            height: 52px; 
            padding: 0 16px 0 48px;
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14.5px;
            color: var(--text-main);
            transition: all 0.2s ease;
            outline: none;
        }

        .field-inner input::placeholder {
            color: #94A3B8;
        }

        .field-inner input:hover {
            border-color: #CBD5E1;
            background: #F1F5F9;
        }

        .field-inner input:focus {
            border-color: #2563EB;
            background: var(--white);
            box-shadow: 0 0 0 4px var(--blue-focus);
        }

        /* ───────── TOMBOL LOGIN ───────── */
        .btn-submit {
            width: 100%;
            height: 52px;
            background: var(--navy);
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-family: 'Sora', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 32px;
            box-shadow: 0 4px 12px rgba(12, 31, 63, 0.15);
        }

        .btn-submit:hover {
            background: var(--navy-light);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(12, 31, 63, 0.2);
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        .btn-submit svg {
            width: 18px;
            height: 18px;
            transition: transform 0.2s ease;
        }

        .btn-submit:hover svg {
            transform: translateX(3px);
        }

        /* ───────── FOOTER NOTE ───────── */
        .card-footer {
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 16px;
        }

        /* ───────── RESPONSIVE ───────── */
        @media (max-width: 540px) {
            .login-card {
                border-radius: 20px;
            }
            .brand-header, .form-body {
                padding: 32px 24px;
            }
            .field-inner input, .btn-submit {
                height: 48px;
            }
            .brand-logo-img {
                width: 70px;
                height: 70px;
            }
        }
    </style>
</head>

<body>

    <main class="login-card">
        <!-- Bagian Header Bertema Navy dengan Logo Resmi -->
        <div class="brand-header">
            <div class="brand-logo-wrapper">
                <!-- Memanggil file gambar logo resmi Anda -->
                <img src="../images/logo.png" alt="Logo BEM FILKOM" class="brand-logo-img">
            </div>
            <h1>Portal Admin FILKOM</h1>
            <p>Sistem Informasi Manajemen Dosen Pembimbing</p>
        </div>

        <!-- Bagian Form Input -->
        <div class="form-body">
            <form action="proses_login.php" method="POST">

                <div class="field">
                    <label for="username">Username / NIM</label>
                    <div class="field-inner">
                        <span class="field-icon" aria-hidden="true">
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="10" cy="6.5" r="3.5" />
                                <path d="M2.5 17c0-4.142 3.358-7.5 7.5-7.5s7.5 3.358 7.5 7.5" />
                            </svg>
                        </span>
                        <input type="text" id="username" name="username" required autocomplete="username"
                            placeholder="Masukkan username resmi Anda">
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="field-inner">
                        <span class="field-icon" aria-hidden="true">
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="8.5" width="12" height="9" rx="2" />
                                <path d="M7 8.5V6a3 3 0 016 0v2.5" />
                            </svg>
                        </span>
                        <input type="password" id="password" name="password" required
                            autocomplete="current-password" placeholder="Masukkan password Anda">
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <span>Masuk ke Sistem</span>
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 10h12M11 5l5 5-5 5" />
                    </svg>
                </button>

            </form>

            <footer class="card-footer">
                © 2026 Fakultas Ilmu Komputer — UNIDA
            </footer>
        </div>
    </main>

</body>
</html>