<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Paraíso dos Mantos' }}</title>
    <meta name="description" content="Mantos de futebol selecionados para quem vive o jogo.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="store-body">
    <header class="site-header">
        <div class="announcement">ENVIO PARA TODO O BRASIL <span>•</span> ATENDIMENTO PELO WHATSAPP</div>
        <div class="nav-shell">
            <a href="{{ route('store.home') }}" class="brand" aria-label="Paraíso dos Mantos - início">
                <img src="{{ asset('images/logo.jpg') }}" alt="Paraíso dos Mantos">
                <span>PARAÍSO DOS <b>MANTOS</b></span>
            </a>
            <nav class="main-nav" aria-label="Navegação principal">
                <a href="{{ route('store.home') }}#colecao">Coleção</a>
                <a href="{{ route('store.home') }}#manifesto">Nossa essência</a>
                <a href="{{ route('store.home') }}#como-comprar">Como comprar</a>
                @auth
                    <a href="{{ route('admin.products.index') }}">Gerenciador</a>
                @else
                    <a href="{{ route('login') }}">Acesso admin</a>
                @endauth
            </nav>
            <button class="cart-trigger" type="button" onclick="window.ParaísoCart.open()" aria-label="Abrir carrinho">
                <span class="cart-icon">⌑</span><span>Carrinho</span><strong id="cart-count">0</strong>
            </button>
        </div>
    </header>

    {{ $slot ?? '' }}
    @yield('content')

    <a class="whatsapp-float" href="https://wa.me/5535998135255" target="_blank" rel="noopener" aria-label="Falar no WhatsApp">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.52 3.48A11.9 11.9 0 0 0 12.04 0C5.46 0 .1 5.36.1 11.95c0 2.1.55 4.15 1.6 5.96L.02 24l6.23-1.63a11.94 11.94 0 0 0 5.78 1.47h.01c6.58 0 11.94-5.36 11.94-11.95 0-3.19-1.24-6.19-3.46-8.41Zm-8.48 18.3h-.01a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.7.97.99-3.6-.23-.37a9.89 9.89 0 0 1-1.52-5.24C2.17 6.5 6.6 2.07 12.05 2.07a9.86 9.86 0 0 1 7.02 2.91 9.87 9.87 0 0 1 2.9 7.03c0 5.46-4.44 9.9-9.93 9.9Zm5.43-7.42c-.3-.15-1.77-.87-2.05-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.39-1.47-.88-.78-1.48-1.74-1.65-2.04-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.49s1.07 2.89 1.22 3.09c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.5 1.69.64.71.23 1.35.2 1.85.12.57-.08 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35Z"/></svg>
    </a>

    <aside class="cart-drawer" id="cart-drawer" aria-label="Carrinho de compras" aria-hidden="true">
        <div class="drawer-backdrop" onclick="window.ParaísoCart.close()"></div>
        <div class="drawer-panel">
            <div class="drawer-head"><div><span class="eyebrow">SUA SELEÇÃO</span><h2>Carrinho</h2></div><button type="button" onclick="window.ParaísoCart.close()" aria-label="Fechar carrinho">×</button></div>
            <div id="cart-items" class="cart-items"></div>
            <div class="cart-empty" id="cart-empty"><span>⌂</span><p>Seu carrinho ainda está vazio.</p><a href="#colecao" onclick="window.ParaísoCart.close()">Explorar a coleção</a></div>
            <div class="cart-footer" id="cart-footer"><div class="total-row"><span>Total</span><strong id="cart-total">R$ 0,00</strong></div><button class="gold-button full" onclick="window.ParaísoCart.checkout()">Finalizar pelo WhatsApp <span>↗</span></button><p class="secure-note">Você será redirecionado para uma conversa com nossa equipe.</p></div>
        </div>
    </aside>
</body>
</html>
