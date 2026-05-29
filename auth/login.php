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
            --gold-soft: rgba(201, 168, 76, 0.12);
            --white: #FFFFFF;
            --off-white: #F7F8FA;
            --text-main: #111827;
            --text-muted: #6B7280;
            --border: #E5E7EB;
            --blue-focus: rgba(37, 99, 235, 0.18);
            --input-bg: #FAFAFA;
        }

        html,
        body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: var(--off-white);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }

        /* ───────── LAYOUT ───────── */
        .page {
            display: grid;
            grid-template-columns: 440px 1fr;
            min-height: 100vh;
        }

        /* ───────── LEFT PANEL ───────── */
        .panel-left {
            background: var(--navy);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 44px;
            position: relative;
            overflow: hidden;
        }

        /* subtle geometric texture */
        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(ellipse 500px 400px at 120% -10%, rgba(201, 168, 76, 0.08) 0%, transparent 70%),
                radial-gradient(ellipse 300px 400px at -20% 110%, rgba(37, 99, 235, 0.10) 0%, transparent 60%);
            pointer-events: none;
        }

        .panel-left::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -80px;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        .logo-mark {
            width: 42px;
            height: 42px;
            background: var(--gold);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-mark svg {
            display: block;
        }

        .logo-text {
            font-family: 'Sora', sans-serif;
        }

        .logo-text .org {
            font-size: 11px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .logo-text .name {
            font-size: 15px;
            font-weight: 600;
            color: var(--white);
            letter-spacing: -0.01em;
            margin-top: 1px;
        }

        .panel-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            z-index: 1;
            padding: 48px 0 32px;
        }

        .panel-eyebrow {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 16px;
        }

        .panel-headline {
            font-family: 'Sora', sans-serif;
            font-size: 30px;
            font-weight: 600;
            color: var(--white);
            line-height: 1.3;
            letter-spacing: -0.03em;
            margin-bottom: 18px;
        }

        .panel-desc {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.55);
            line-height: 1.7;
            max-width: 300px;
        }

        .divider-line {
            width: 36px;
            height: 2px;
            background: var(--gold);
            margin: 28px 0;
            border-radius: 2px;
        }

        .feature-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .feature-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.5;
        }

        .feat-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            flex-shrink: 0;
            margin-top: 5px;
        }

        .panel-footer {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.25);
            position: relative;
            z-index: 1;
        }

        /* ───────── RIGHT PANEL ───────── */
        .panel-right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            background: var(--white);
        }

        .form-shell {
            width: 100%;
            max-width: 400px;
        }

        .form-top {
            margin-bottom: 36px;
        }

        .form-top .chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--gold-soft);
            color: #7A5C12;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 100px;
            margin-bottom: 20px;
            border: 1px solid rgba(201, 168, 76, 0.25);
        }

        .form-top h2 {
            font-family: 'Sora', sans-serif;
            font-size: 26px;
            font-weight: 600;
            color: var(--text-main);
            letter-spacing: -0.03em;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .form-top p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ───────── FORM ELEMENTS ───────── */
        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 7px;
        }

        .field-inner {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            display: flex;
            pointer-events: none;
        }

        .field-icon svg {
            width: 17px;
            height: 17px;
        }

        .field-inner input {
            width: 100%;
            height: 46px;
            padding: 0 14px 0 42px;
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--text-main);
            transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
            outline: none;
        }

        .field-inner input::placeholder {
            color: #C0C7D0;
        }

        .field-inner input:hover {
            border-color: #D1D5DB;
        }

        .field-inner input:focus {
            border-color: #2563EB;
            background: var(--white);
            box-shadow: 0 0 0 4px var(--blue-focus);
        }

        /* ───────── SUBMIT BUTTON ───────── */
        .btn-submit {
            width: 100%;
            height: 48px;
            background: var(--navy);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 28px;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, transparent 60%);
        }

        .btn-submit:hover {
            background: var(--navy-light);
        }

        .btn-submit:active {
            transform: scale(0.985);
        }

        .btn-submit svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        /* ───────── DIVIDER ───────── */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
        }

        .divider hr {
            flex: 1;
            border: none;
            border-top: 1px solid var(--border);
        }

        .divider span {
            font-size: 12px;
            color: #9CA3AF;
            white-space: nowrap;
        }

        /* ───────── NOTICE ───────── */
        .notice {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: #F0F4FF;
            border: 1px solid #DBEAFE;
            border-radius: 10px;
            padding: 14px;
        }

        .notice svg {
            width: 16px;
            height: 16px;
            color: #2563EB;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .notice p {
            font-size: 12.5px;
            color: #3B5BBD;
            line-height: 1.55;
        }

        .notice strong {
            font-weight: 500;
        }

        /* ───────── RESPONSIVE ───────── */
        @media (max-width: 860px) {
            .page {
                grid-template-columns: 1fr;
            }

            .panel-left {
                display: none;
            }

            .panel-right {
                padding: 40px 24px;
                background: var(--off-white);
            }

            .form-shell {
                max-width: 440px;
                background: var(--white);
                padding: 36px 32px;
                border-radius: 16px;
                border: 1px solid var(--border);
            }
        }

        @media (max-width: 480px) {
            .form-shell {
                padding: 28px 20px;
            }

            .form-top h2 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- ── LEFT PANEL ── -->
        <aside class="panel-left">
            <div class="logo-area">
                <div class="logo-mark">
                    <!-- Simple geometric mark -->
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2" y="2" width="8" height="8" rx="2" fill="#0C1F3F" />
                        <rect x="12" y="2" width="8" height="8" rx="2" fill="#0C1F3F" opacity="0.6" />
                        <rect x="2" y="12" width="8" height="8" rx="2" fill="#0C1F3F" opacity="0.6" />
                        <rect x="12" y="12" width="8" height="8" rx="2" fill="#0C1F3F" />
                    </svg>
                </div>
                <div class="logo-text">
                    <div class="org">Universitas Djuanda</div>
                    <div class="name">FILKOM Portal</div>
                </div>
            </div>

            <div class="panel-body">
                <p class="panel-eyebrow">Academic Portal</p>
                <h1 class="panel-headline">Sistem Informasi<br>Akademik &amp; Kemahasiswaan</h1>
                <p class="panel-desc">Akses terpadu untuk layanan akademik, jadwal perkuliahan, nilai, dan administrasi
                    kemahasiswaan Fakultas Ilmu Komputer.</p>
                <div class="divider-line"></div>
                <ul class="feature-list">
                    <li><span class="feat-dot"></span>Informasi KRS &amp; jadwal kuliah</li>
                    <li><span class="feat-dot"></span>Riwayat nilai &amp; transkrip akademik</li>
                    <li><span class="feat-dot"></span>Pengumuman &amp; notifikasi resmi</li>
                    <li><span class="feat-dot"></span>Administrasi &amp; layanan kemahasiswaan</li>
                </ul>
            </div>

            <p class="panel-footer">© 2025 Fakultas Ilmu Komputer — UNIDA Bogor</p>
        </aside>

        <!-- ── RIGHT PANEL ── -->
        <main class="panel-right">
            <div class="form-shell">
                <div class="form-top">
                    <h2>Masuk Sebagai Admin</h2>
                    <p>Gunakan username resmi beserta password Anda.</p>
                </div>

                <form action="proses_login.php" method="POST">

                    <div class="field">
                        <label for="username">NIM / Username</label>
                        <div class="field-inner">
                            <span class="field-icon" aria-hidden="true">
                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="10" cy="6.5" r="3.5" />
                                    <path d="M2.5 17c0-4.142 3.358-7.5 7.5-7.5s7.5 3.358 7.5 7.5" />
                                </svg>
                            </span>
                            <input type="text" id="username" name="username" required autocomplete="username"
                                placeholder="cth. 0220101234 atau nim@unida.ac.id">
                        </div>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <div class="field-inner">
                            <span class="field-icon" aria-hidden="true">
                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6"
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
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 10h12M11 5l5 5-5 5" />
                        </svg>
                    </button>

                </form>
            </div>
        </main>
    </div>
</body>
</html>