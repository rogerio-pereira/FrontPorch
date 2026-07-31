<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">
        <title>@yield('title') — {{ config('app.name', 'Front Porch Creative') }}</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <style>
            @font-face {
                font-family: 'Montserrat Alt';
                src: url('/fonts/MontserratAlt1-Thin.ttf') format('truetype');
                font-weight: 100 700;
                font-style: normal;
                font-display: swap;
            }

            @font-face {
                font-family: 'Montserrat';
                src: url('/fonts/Montserrat-SemiBold.ttf') format('truetype');
                font-weight: 600;
                font-style: normal;
                font-display: swap;
            }

            @font-face {
                font-family: 'Montserrat';
                src: url('/fonts/Montserrat-Light.ttf') format('truetype');
                font-weight: 300;
                font-style: normal;
                font-display: swap;
            }

            :root {
                --brand-bg: #192630;
                --brand-accent: #72887b;
                --brand-accent-hover: #5f7266;
                --text-on-dark: #f5f5f5;
                --text-muted: rgb(255 255 255 / 70%);
                --text-subtle: rgb(255 255 255 / 50%);
                --surface-raised: #1e2f3c;
                --border-default: rgb(114 136 123 / 35%);
            }

            *,
            *::before,
            *::after {
                box-sizing: border-box;
            }

            html,
            body {
                margin: 0;
                min-height: 100%;
            }

            body {
                font-family: Montserrat, ui-sans-serif, system-ui, sans-serif;
                font-weight: 300;
                background: var(--brand-bg);
                color: var(--text-on-dark);
                line-height: 1.65;
            }

            .page {
                position: relative;
                display: flex;
                min-height: 100vh;
                flex-direction: column;
                overflow: hidden;
            }

            .page::before {
                content: '';
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(ellipse 80% 50% at 50% -10%, rgb(114 136 123 / 18%), transparent 60%),
                    linear-gradient(135deg, rgb(114 136 123 / 10%) 0%, transparent 45%);
                pointer-events: none;
            }

            .grid {
                position: absolute;
                inset: 0;
                background-image:
                    linear-gradient(rgb(114 136 123 / 8%) 1px, transparent 1px),
                    linear-gradient(90deg, rgb(114 136 123 / 8%) 1px, transparent 1px);
                background-size: 48px 48px;
                mask-image: radial-gradient(circle at center, black, transparent 75%);
                pointer-events: none;
                opacity: 0.7;
            }

            .shell {
                position: relative;
                z-index: 1;
                display: flex;
                flex: 1;
                flex-direction: column;
                width: 100%;
                max-width: 80rem;
                margin: 0 auto;
                padding: 1.5rem 1rem 3rem;
            }

            @media (min-width: 640px) {
                .shell {
                    padding-inline: 1.5rem;
                }
            }

            @media (min-width: 1024px) {
                .shell {
                    padding-inline: 2rem;
                }
            }

            .brand {
                display: inline-flex;
                align-items: center;
            }

            .brand img {
                height: 2rem;
                width: auto;
            }

            .main {
                display: flex;
                flex: 1;
                align-items: center;
                justify-content: center;
                padding-block: 3rem;
            }

            .card {
                width: 100%;
                max-width: 36rem;
                padding: 2rem 1.5rem;
                border: 1px solid var(--border-default);
                border-radius: 12px;
                background: var(--surface-raised);
                box-shadow: 0 0 40px rgb(114 136 123 / 12%);
                text-align: center;
            }

            @media (min-width: 640px) {
                .card {
                    padding: 2.5rem 2rem;
                }
            }

            .overline {
                margin: 0 0 1rem;
                font-size: 0.75rem;
                font-weight: 600;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--brand-accent);
            }

            .code {
                margin: 0 0 0.75rem;
                font-family: 'Montserrat Alt', Montserrat, ui-sans-serif, system-ui, sans-serif;
                font-size: clamp(3rem, 8vw, 4.5rem);
                font-weight: 700;
                line-height: 1.05;
                letter-spacing: -0.02em;
                color: var(--text-on-dark);
            }

            .heading {
                margin: 0 0 0.75rem;
                font-family: 'Montserrat Alt', Montserrat, ui-sans-serif, system-ui, sans-serif;
                font-size: clamp(1.5rem, 3vw, 2rem);
                font-weight: 700;
                line-height: 1.2;
                letter-spacing: -0.01em;
            }

            .message {
                margin: 0 auto 1.75rem;
                max-width: 28rem;
                font-size: 1.0625rem;
                color: var(--text-muted);
            }

            .actions {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
            }

            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 2.75rem;
                padding: 0.625rem 1.25rem;
                border-radius: 6px;
                font-family: Montserrat, ui-sans-serif, system-ui, sans-serif;
                font-size: 0.875rem;
                font-weight: 600;
                text-decoration: none;
                transition:
                    background-color 200ms ease,
                    border-color 200ms ease,
                    color 200ms ease,
                    box-shadow 200ms ease,
                    transform 200ms ease;
            }

            .btn:focus-visible {
                outline: 3px solid rgb(114 136 123 / 50%);
                outline-offset: 2px;
            }

            .btn-primary {
                background: var(--brand-accent);
                color: var(--brand-bg);
            }

            .btn-primary:hover {
                background: var(--brand-accent-hover);
                box-shadow: 0 0 40px rgb(114 136 123 / 15%);
                transform: scale(1.02);
            }

            .btn-secondary {
                border: 1px solid var(--brand-accent);
                background: transparent;
                color: var(--brand-accent);
            }

            .btn-secondary:hover {
                background: rgb(114 136 123 / 10%);
            }

            @media (prefers-reduced-motion: reduce) {
                .btn-primary:hover {
                    transform: none;
                }
            }

            .footer-note {
                margin: 0;
                font-size: 0.875rem;
                color: var(--text-subtle);
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="page">
            <div class="grid" aria-hidden="true"></div>
            <div class="shell">
                <a href="{{ url('/') }}" class="brand" data-test="error-home-logo">
                    <img
                        src="/images/branding/logo-horizontal.png"
                        alt="{{ config('app.name', 'Front Porch Creative') }}"
                    >
                </a>

                <main class="main">
                    <div class="card" data-test="error-card">
                        <p class="overline" data-test="error-status">@yield('status')</p>
                        <p class="code" aria-hidden="true">@yield('code')</p>
                        <h1 class="heading" data-test="error-heading">@yield('heading')</h1>
                        <p class="message" data-test="error-message">@yield('message')</p>
                        <div class="actions">
                            @yield('actions')
                        </div>
                    </div>
                </main>

                <p class="footer-note">Front Porch Creative · Central Florida</p>
            </div>
        </div>
    </body>
</html>
