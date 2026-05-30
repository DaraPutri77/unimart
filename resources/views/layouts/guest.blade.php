<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'UniMart') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
            color: #111827;
            background:
                radial-gradient(circle at top left, rgba(236, 72, 153, 0.18), transparent 28%),
                radial-gradient(circle at bottom right, rgba(17, 24, 39, 0.08), transparent 30%),
                linear-gradient(135deg, #fff8fc 0%, #ffffff 48%, #fff1f7 100%);
        }

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
        }

        .auth-card {
            width: 100%;
            max-width: 760px;
            min-height: 470px;
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            overflow: hidden;
            border-radius: 26px;
            background: #ffffff;
            border: 1px solid rgba(236, 72, 153, 0.12);
            box-shadow: 0 18px 48px rgba(17, 24, 39, 0.10);
        }

        .auth-left {
            position: relative;
            padding: 30px 28px;
            background:
                radial-gradient(circle at top right, rgba(17, 24, 39, 0.08), transparent 30%),
                linear-gradient(160deg, #fff0f7 0%, #ffd7ea 100%);
            display: flex;
            align-items: center;
        }

        .auth-left::before {
            content: "";
            position: absolute;
            right: -55px;
            top: -55px;
            width: 150px;
            height: 150px;
            border-radius: 999px;
            background: rgba(17, 24, 39, 0.06);
        }

        .auth-left::after {
            content: "";
            position: absolute;
            left: -45px;
            bottom: -45px;
            width: 135px;
            height: 135px;
            border-radius: 999px;
            background: rgba(236, 72, 153, 0.12);
        }

        .auth-left-content {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .auth-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.76);
            box-shadow: 0 10px 24px rgba(17, 24, 39, 0.08);
            margin-bottom: 22px;
        }

        .auth-brand-text h2 {
            margin: 0;
            font-size: 20px;
            line-height: 1.1;
            font-weight: 900;
            color: #111827;
        }

        .auth-brand-text p {
            margin: 3px 0 0;
            font-size: 12px;
            color: #6b7280;
            font-weight: 600;
        }

        .auth-badge {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(236, 72, 153, 0.20);
            color: #db2777;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .auth-title {
            margin: 0;
            max-width: 310px;
            font-size: 25px;
            line-height: 1.18;
            font-weight: 900;
            color: #111827;
            letter-spacing: -0.03em;
        }

        .auth-desc {
            max-width: 320px;
            margin-top: 14px;
            margin-bottom: 20px;
            color: #4b5563;
            font-size: 13.5px;
            line-height: 1.75;
            font-weight: 500;
        }

        .auth-list {
            display: grid;
            gap: 10px;
            max-width: 320px;
        }

        .auth-list-item {
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.80);
            border: 1px solid rgba(255, 255, 255, 0.85);
            box-shadow: 0 8px 18px rgba(17, 24, 39, 0.05);
            color: #1f2937;
            font-size: 12.8px;
            font-weight: 700;
        }

        .auth-right {
            padding: 32px 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }

        .auth-form-wrap {
            width: 100%;
            max-width: 350px;
        }

        .auth-mobile-brand {
            display: none;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .auth-kicker {
            margin: 0 0 8px;
            color: #ec4899;
            font-size: 11.5px;
            font-weight: 900;
            letter-spacing: 0.28em;
            text-transform: uppercase;
        }

        .auth-heading {
            margin: 0;
            font-size: 25px;
            line-height: 1.18;
            font-weight: 900;
            color: #111827;
            letter-spacing: -0.03em;
        }

        .auth-subheading {
            margin: 9px 0 0;
            color: #6b7280;
            font-size: 13.5px;
            line-height: 1.6;
            font-weight: 500;
        }

        .auth-form {
            margin-top: 22px;
            display: grid;
            gap: 13px;
        }

        .auth-label {
            display: block;
            margin-bottom: 7px;
            color: #1f2937;
            font-size: 13px;
            font-weight: 800;
        }

        .auth-input {
            width: 100%;
            border: 1px solid #e5e7eb;
            outline: none;
            border-radius: 14px;
            background: #ffffff;
            padding: 12px 14px;
            font-size: 14px;
            color: #111827;
            transition: 0.2s ease;
            box-shadow: 0 5px 14px rgba(17, 24, 39, 0.04);
        }

        .auth-input::placeholder {
            color: #9ca3af;
        }

        .auth-input:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.12);
        }

        .auth-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .auth-check {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 11px 13px;
            border-radius: 14px;
            background: #f9fafb;
            color: #4b5563;
            font-size: 13px;
            font-weight: 600;
        }

        .auth-link {
            color: #db2777;
            text-decoration: none;
            font-weight: 800;
            font-size: 13px;
        }

        .auth-link:hover {
            color: #be185d;
        }

        .auth-button {
            width: 100%;
            border: none;
            border-radius: 14px;
            padding: 13px 16px;
            cursor: pointer;
            background: linear-gradient(135deg, #111827 0%, #1f172a 45%, #ec4899 100%);
            color: white;
            font-size: 14.5px;
            font-weight: 900;
            box-shadow: 0 14px 28px rgba(236, 72, 153, 0.20);
            transition: 0.2s ease;
        }

        .auth-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(236, 72, 153, 0.26);
        }

        .auth-footer {
            margin-top: 17px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
            font-weight: 600;
        }

        .auth-two-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 11px;
        }

        @media (max-width: 850px) {
            .auth-card {
                max-width: 430px;
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .auth-left {
                display: none;
            }

            .auth-right {
                padding: 28px 22px;
            }

            .auth-mobile-brand {
                display: flex;
            }

            .auth-heading {
                font-size: 24px;
            }

            .auth-two-cols {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <main class="auth-page">
        {{ $slot }}
    </main>
</body>
</html>