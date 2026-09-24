<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>{{ $title ?? 'Gerenciador · Paraíso dos Mantos' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin.css') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="admin-body">
<header class="admin-header"><a href="{{ route('store.home') }}" class="admin-brand"><img src="{{ asset('images/logo.jpg') }}" alt="Logo"><span>PARAÍSO DOS <b>MANTOS</b></span></a><div class="admin-actions"><a href="{{ route('store.home') }}">Ver loja ↗</a><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Sair</button></form></div></header>
<main class="admin-main">@if(session('success'))<div class="flash-success">{{ session('success') }}</div>@endif @yield('content')</main>
</body>
</html>
