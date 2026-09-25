<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Paraíso dos Mantos') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="guest-body">
        <main class="guest-shell">
            <div class="guest-orbit guest-orbit-one" aria-hidden="true"></div>
            <div class="guest-orbit guest-orbit-two" aria-hidden="true"></div>
            <section class="guest-brand-panel" aria-label="Paraíso dos Mantos">
                <a class="guest-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Paraíso dos Mantos">
                    <span>PARAÍSO <b>DOS MANTOS</b></span>
                </a>
                <div class="guest-brand-copy">
                    <span class="guest-kicker">ÁREA EXCLUSIVA</span>
                    <h1>O futebol<br><em>começa aqui.</em></h1>
                    <p>Entre para cuidar da sua coleção e manter cada manto em campo.</p>
                </div>
                <span class="guest-brand-mark" aria-hidden="true">✦</span>
            </section>
            <section class="guest-card" aria-label="Autenticação">
                <div class="guest-card-heading">
                    <span class="guest-kicker">BEM-VINDO DE VOLTA</span>
                    <h2>{{ $heading ?? 'Acesse o gerenciador' }}</h2>
                    <p>{{ $subheading ?? 'Entre para administrar sua coleção.' }}</p>
                </div>
                {{ $slot }}
            </section>
        </main>
    </body>
</html>
