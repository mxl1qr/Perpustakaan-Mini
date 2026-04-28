<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="PerpusMini — Sistem manajemen perpustakaan digital SMKN 40 Jakarta">

        <title>{{ config('app.name', 'PerpusMini') }} — Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            *, *::before, *::after { box-sizing: border-box; }

            :root {
                --slate-50: #f8fafc;
                --slate-100: #f1f5f9;
                --slate-200: #e2e8f0;
                --slate-300: #cbd5e1;
                --slate-400: #94a3b8;
                --slate-500: #64748b;
                --slate-600: #475569;
                --slate-700: #334155;
                --slate-800: #1e293b;
                --slate-900: #0f172a;
                --navy: #2d3a4a;
                --navy-dark: #1f2937;
                --navy-deeper: #1a2332;
            }

            body {
                font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
                margin: 0;
                padding: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #f3f3f3;
                color: var(--slate-800);
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            /* ─── Grid Background ─── */
            body::before {
                content: '';
                position: fixed;
                inset: 0;
                background-image:
                    linear-gradient(rgba(0, 0, 0, 0.12) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(0, 0, 0, 0.12) 1px, transparent 1px);
                background-size: 40px 40px;
                z-index: 0;
                pointer-events: none;
            }

            /* Radial soft glow */
            body::after {
                content: '';
                position: fixed;
                inset: 0;
                background: radial-gradient(ellipse at 30% 50%, rgba(99, 102, 241, 0.04) 0%, transparent 70%),
                            radial-gradient(ellipse at 70% 30%, rgba(59, 130, 246, 0.03) 0%, transparent 60%);
                z-index: 0;
                pointer-events: none;
            }

            /* ─── Main Card Container ─── */
            .login-card {
                position: relative;
                z-index: 1;
                display: flex;
                width: 100%;
                max-width: 960px;
                min-height: 560px;
                border-radius: 20px;
                overflow: hidden;
                background: #ffffff;
                box-shadow:
                    0 1px 3px rgba(0, 0, 0, 0.04),
                    0 6px 16px rgba(0, 0, 0, 0.06),
                    0 20px 40px rgba(0, 0, 0, 0.04);
                margin: 24px;
            }

            /* ─── Left Panel — Form ─── */
            .login-left {
                flex: 1;
                padding: 48px 44px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                position: relative;
            }

            .login-badge {
                font-family: 'Liberation Mono', monospace;
                font-size: 11px;
                font-weight: 500;
                letter-spacing: 2px;
                text-transform: uppercase;
                color: var(--slate-400);
                margin-bottom: 8px;
            }

            .login-title {
                font-size: 30px;
                font-weight: 800;
                color: var(--slate-900);
                margin: 0 0 4px 0;
                letter-spacing: -0.5px;
                line-height: 1.2;
            }

            .login-subtitle {
                font-size: 14px;
                font-weight: 400;
                color: var(--slate-400);
                margin: 0 0 36px 0;
            }

            /* ─── Form Styles ─── */
            .form-group {
                margin-bottom: 20px;
            }

            .form-label {
                display: block;
                font-family: 'Liberation Mono', monospace;
                font-size: 11px;
                font-weight: 500;
                letter-spacing: 1.5px;
                text-transform: uppercase;
                color: var(--slate-500);
                margin-bottom: 8px;
            }

            .form-input {
                width: 100%;
                padding: 12px 16px;
                font-family: 'Inter', sans-serif;
                font-size: 14px;
                color: var(--slate-800);
                background: #ffffff;
                border: 1.5px solid var(--slate-200);
                border-radius: 10px;
                outline: none;
                transition: all 0.2s ease;
            }

            .form-input::placeholder {
                color: var(--slate-300);
                font-weight: 300;
            }

            .form-input:hover {
                border-color: var(--slate-300);
            }

            .form-input:focus {
                border-color: var(--slate-800);
                box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.08);
            }

            .form-footer {
                display: flex;
                justify-content: flex-end;
                margin-top: -8px;
                margin-bottom: 8px;
            }

            .forgot-link {
                font-size: 12.5px;
                font-weight: 500;
                color: var(--slate-800);
                text-decoration: none;
                transition: color 0.2s ease;
            }

            .forgot-link:hover {
                color: var(--slate-600);
                text-decoration: underline;
            }

            /* ─── Submit Button ─── */
            .btn-login {
                width: 100%;
                padding: 14px 24px;
                background: var(--slate-800);
                color: #ffffff;
                font-family: 'Liberation Mono', monospace;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: 2px;
                text-transform: uppercase;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                transition: all 0.25s ease;
                margin-top: 8px;
                position: relative;
                overflow: hidden;
            }

            .btn-login::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, transparent 50%);
                opacity: 0;
                transition: opacity 0.25s ease;
            }

            .btn-login:hover {
                background: var(--slate-900);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(15, 23, 42, 0.3);
            }

            .btn-login:hover::before {
                opacity: 1;
            }

            .btn-login:active {
                transform: translateY(0);
                box-shadow: 0 2px 6px rgba(15, 23, 42, 0.2);
            }

            .btn-login svg {
                width: 16px;
                height: 16px;
                transition: transform 0.2s ease;
            }

            .btn-login:hover svg {
                transform: translateX(3px);
            }

            /* ─── Bottom Info ─── */
            .login-bottom {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-top: 32px;
                padding-top: 20px;
                border-top: 1px solid var(--slate-100);
            }

            .version-tag {
                font-family: 'Liberation Mono', monospace;
                font-size: 11px;
                color: var(--slate-300);
                font-weight: 400;
            }

            .register-text {
                font-size: 12.5px;
                color: var(--slate-400);
            }

            .register-link {
                font-weight: 600;
                color: var(--slate-800);
                text-decoration: none;
                transition: all 0.2s ease;
            }

            .register-link:hover {
                color: var(--slate-600);
                text-decoration: underline;
            }

            /* ─── Right Panel — Hero ─── */
            .login-right {
                flex: 1.15;
                background: linear-gradient(160deg, var(--navy) 0%, var(--navy-deeper) 100%);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 48px 40px;
                position: relative;
                overflow: hidden;
            }

            /* Radial glow on hero */
            .login-right::after {
                content: '';
                position: absolute;
                top: 20%;
                left: 50%;
                transform: translateX(-50%);
                width: 300px;
                height: 300px;
                background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%);
                pointer-events: none;
            }

            .hero-icon-wrapper {
                position: relative;
                z-index: 1;
                width: 96px;
                height: 96px;
                background: #ffffff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 28px;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
                animation: float 6s ease-in-out infinite;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-8px); }
            }

            .hero-icon-wrapper svg {
                width: 44px;
                height: 44px;
                color: var(--slate-800);
            }

            .hero-title {
                position: relative;
                z-index: 1;
                font-size: 26px;
                font-weight: 700;
                color: #ffffff;
                margin: 0 0 14px 0;
                text-align: center;
                letter-spacing: -0.3px;
                line-height: 1.3;
            }

            .hero-desc {
                position: relative;
                z-index: 1;
                font-size: 14px;
                font-weight: 300;
                color: rgba(255, 255, 255, 0.6);
                text-align: center;
                max-width: 360px;
                line-height: 1.7;
                margin: 0;
            }

            /* ─── Error Messages ─── */
            .form-error {
                font-size: 12px;
                color: #ef4444;
                margin-top: 6px;
                font-weight: 500;
            }

            .session-status {
                padding: 12px 16px;
                background: #ecfdf5;
                border: 1px solid #a7f3d0;
                border-radius: 10px;
                color: #065f46;
                font-size: 13px;
                font-weight: 500;
                margin-bottom: 20px;
            }

            /* ─── Responsive ─── */
            @media (max-width: 768px) {
                body {
                    align-items: flex-start;
                    padding: 0;
                }

                .login-card {
                    flex-direction: column;
                    max-width: 100%;
                    min-height: 100vh;
                    border-radius: 0;
                    margin: 0;
                    box-shadow: none;
                }

                .login-left {
                    padding: 36px 28px;
                    order: 1;
                }

                .login-right {
                    padding: 40px 28px;
                    min-height: 240px;
                    order: 0;
                }

                .hero-title {
                    font-size: 22px;
                }

                .hero-icon-wrapper svg {
                    width: 32px;
                    height: 32px;
                }

                .hero-icon-wrapper img {
                    width: 130%;
                    height: auto;
                    object-fit: contain;
                }

                .login-title {
                    font-size: 26px;
                }
            }

            /* ─── Decorative dots ─── */
            .dot-pattern {
                position: absolute;
                opacity: 0.04;
                pointer-events: none;
            }

            .dot-pattern-1 {
                top: -20px;
                right: -20px;
                width: 120px;
                height: 120px;
                background-image: radial-gradient(circle, var(--slate-800) 1.5px, transparent 1.5px);
                background-size: 12px 12px;
            }

            .dot-pattern-2 {
                bottom: -10px;
                left: -10px;
                width: 80px;
                height: 80px;
                background-image: radial-gradient(circle, var(--slate-800) 1.5px, transparent 1.5px);
                background-size: 12px 12px;
            }
        </style>
    </head>
    <body>
        <div class="login-card">
            <!-- Left Panel — Form -->
            <div class="login-left">
                <div class="dot-pattern dot-pattern-1"></div>
                <div class="dot-pattern dot-pattern-2"></div>
                {{ $slot }}
            </div>

            <!-- Right Panel — Hero -->
            <div class="login-right">
                <div class="hero-icon-wrapper">
                    <!-- Book Icon -->
                    <img src="{{ asset('img/Logo-perpus.webp') }}" alt="Logo Perpustakaan"> 
                </div>
                <h2 class="hero-title">Selamat Datang di<br>PerpusMini Library</h2>
                <p class="hero-desc">
                    Kelola data stok buku dengan mudah, cepat, dan transparan. Platform ini dirancang untuk memudahkan proses pendataan secara real-time dan terintegrasi.
                </p>
            </div>
        </div>
    </body>
</html>
