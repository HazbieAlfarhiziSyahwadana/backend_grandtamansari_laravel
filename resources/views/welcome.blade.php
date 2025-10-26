<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Grand Tamansari Residence') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            :root {
                color-scheme: light;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background: radial-gradient(circle at top left, #e9f7f1, #f7faf9 55%, #ffffff);
                color: #1f2937;
                min-height: 100vh;
                margin: 0;
                display: flex;
                flex-direction: column;
            }

            .hero {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 4rem;
                align-items: center;
                padding: 6rem 1.5rem;
                max-width: 1100px;
                margin: 0 auto;
                width: 100%;
            }

            .brand {
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                font-size: 1rem;
                font-weight: 600;
                color: #047857;
                background-color: rgba(4, 120, 87, 0.1);
                padding: 0.5rem 0.9rem;
                border-radius: 999px;
            }

            .title {
                font-size: clamp(2.25rem, 3.5vw + 1rem, 3.5rem);
                line-height: 1.1;
                font-weight: 700;
                margin-bottom: 1rem;
                color: #064e3b;
            }

            .title span {
                color: #10b981;
            }

            .subtitle {
                font-size: 1.05rem;
                line-height: 1.6;
                color: #4b5563;
                margin-bottom: 2rem;
            }

            .cta-button {
                display: inline-flex;
                align-items: center;
                gap: 0.6rem;
                background: linear-gradient(120deg, #047857, #10b981);
                color: #fff;
                padding: 0.85rem 1.8rem;
                border-radius: 999px;
                font-weight: 600;
                font-size: 1rem;
                text-decoration: none;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                box-shadow: 0 15px 30px -15px rgba(4, 120, 87, 0.6);
            }

            .cta-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 18px 35px -15px rgba(4, 120, 87, 0.75);
            }

            .cta-button svg {
                width: 1.2rem;
                height: 1.2rem;
            }

            .card-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1.5rem;
            }

            .info-card {
                background: #ffffff;
                border-radius: 1rem;
                padding: 1.5rem;
                box-shadow: 0 20px 45px -20px rgba(15, 118, 110, 0.25);
                border: 1px solid rgba(16, 185, 129, 0.12);
            }

            .info-card h3 {
                font-size: 1.1rem;
                font-weight: 600;
                color: #047857;
                margin-bottom: 0.5rem;
            }

            .info-card p {
                margin: 0;
                font-size: 0.95rem;
                color: #4b5563;
                line-height: 1.5;
            }

            .footer {
                margin-top: auto;
                padding: 2rem 1.5rem;
                text-align: center;
                font-size: 0.9rem;
                color: #6b7280;
            }

            .visual {
                position: relative;
                display: flex;
                justify-content: center;
            }

            .visual::before,
            .visual::after {
                content: '';
                position: absolute;
                border-radius: 999px;
                filter: blur(135px);
                z-index: 0;
            }

            .visual::before {
                width: 380px;
                height: 380px;
                background: rgba(16, 185, 129, 0.18);
                top: -150px;
                right: -120px;
            }

            .visual::after {
                width: 340px;
                height: 340px;
                background: rgba(6, 95, 70, 0.12);
                bottom: -120px;
                left: -100px;
            }

            .visual-card {
                position: relative;
                z-index: 1;
                background: linear-gradient(160deg, rgba(16, 185, 129, 0.9), rgba(5, 150, 105, 0.85));
                color: #fff;
                padding: 2.5rem 2rem;
                border-radius: 1.5rem;
                box-shadow: 0 25px 50px -25px rgba(6, 95, 70, 0.6);
                max-width: 360px;
                width: 100%;
            }

            .visual-card h4 {
                font-size: 1.4rem;
                margin-bottom: 1rem;
                font-weight: 600;
            }

            .visual-card ul {
                list-style: none;
                padding: 0;
                margin: 0;
                display: grid;
                gap: 0.75rem;
                font-size: 0.95rem;
            }

            .visual-card li {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .visual-card li svg {
                width: 1rem;
                height: 1rem;
            }

            @media (max-width: 768px) {
                .hero {
                    padding: 4rem 1.5rem;
                    text-align: center;
                }

                .brand {
                    margin: 0 auto;
                }

                .cta-button {
                    justify-content: center;
                }

                .visual {
                    margin-top: 1rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="hero">
            <section>
                <span class="brand">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M11.47 3.53a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 1 1-1.06 1.06L18 12.56v6.69a.75.75 0 0 1-.75.75h-3.5a.75.75 0 0 1-.75-.75v-3.25H11v3.25a.75.75 0 0 1-.75.75h-3.5A.75.75 0 0 1 6 19.25v-6.69l-1.97-.97a.75.75 0 0 1-.31-1.01.75.75 0 0 1 .31-.31l7.44-7.44Z" clip-rule="evenodd" />
                    </svg>
                    Grand Tamansari Residence Admin Portal
                </span>

                <h1 class="title">
                    Panel <span>Administrasi</span> untuk
                    Grand Tamansari Residence
                </h1>

                <p class="subtitle">
                    Kelola artikel, tipe unit, komersial, slideshow, dan seluruh konten digital Grand Tamansari Residence dalam satu dashboard modern yang responsif.
                </p>

                <a href="{{ route('login') }}" class="cta-button">
                    Login Admin Grand Tamansari Residence
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h9.19l-2.22-2.22a.75.75 0 0 1 1.06-1.06l3.5 3.5a.75.75 0 0 1 0 1.06l-3.5 3.5a.75.75 0 0 1-1.06-1.06l2.22-2.22H3.75A.75.75 0 0 1 3 10Zm13-6.25a.75.75 0 0 0-1.5 0v12.5a.75.75 0 0 0 1.5 0V3.75Z" clip-rule="evenodd" />
                    </svg>
                </a>

                <div class="card-grid" style="margin-top: 2.5rem;">
                    <div class="info-card">
                        <h3>Konten Terpadu</h3>
                        <p>Artikel, slideshow, SEO, dan profil bisa diperbarui kapan saja untuk menjaga tampilan website tetap segar.</p>
                    </div>
                    <div class="info-card">
                        <h3>Data Terhubung</h3>
                        <p>Tabel unit dan komersial menggunakan data MyISAM lama yang sudah dimigrasikan ke Laravel.</p>
                    </div>
                    <div class="info-card">
                        <h3>Hak Akses Aman</h3>
                        <p>Kelola peran super admin dan admin dengan kebijakan akses yang ketat.</p>
                    </div>
                </div>
            </section>

            <aside class="visual">
                <div class="visual-card">
                    <h4>Fokus Pengelolaan</h4>
                    <ul>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75" />
                            </svg>
                            Article & News Management
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                            </svg>
                            Unit & Commercial Showcase
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            SEO & Profil Perusahaan
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                            </svg>
                            Manajemen Pengguna Aman
                        </li>
                    </ul>
                </div>
            </aside>
        </div>

        <footer class="footer">
            &copy; {{ date('Y') }} Grand Tamansari Residence. Semua hak dilindungi.
        </footer>

        @livewireScripts
    </body>
</html>

