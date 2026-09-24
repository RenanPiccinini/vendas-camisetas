@extends('layouts.store')

@section('content')
<main>
    <section class="hero-section">
        <div class="hero-glow"></div>
        <div class="hero-copy reveal">
            <span class="eyebrow">DESDE 2026 · FUTEBOL COM IDENTIDADE</span>
            <h1>Vista a paixão.<br><em>Viva o jogo.</em></h1>
            <p>Mantos escolhidos para quem sabe que futebol não é só noventa minutos. É memória, pertencimento e estilo.</p>
            <a class="gold-button" href="#colecao">Descobrir a coleção <span>↓</span></a>
        </div>
        <div class="hero-art" data-parallax>
            <div class="orbit orbit-one"></div><div class="orbit orbit-two"></div>
            <div class="hero-logo"><img src="{{ asset('images/logo.jpg') }}" alt="Logo Paraíso dos Mantos"></div>
            <div class="hero-stamp">MANTOS<br><span>COM ALMA</span></div>
        </div>
        <div class="hero-scroll">ROLE PARA EXPLORAR <span>↓</span></div>
    </section>

    <section class="marquee-strip"><div>CAMISAS QUE CONTAM HISTÓRIAS <span>✦</span> EDIÇÕES SELECIONADAS <span>✦</span> FUTEBOL PARA VESTIR <span>✦</span> CAMISAS QUE CONTAM HISTÓRIAS <span>✦</span></div></section>

    <section class="collection-section section-shell" id="colecao">
        <div class="section-heading reveal"><div><span class="eyebrow">A CURADORIA</span><h2>Escolha seu <em>manto.</em></h2></div><p>Peças que carregam a energia das arquibancadas e a qualidade para acompanhar você em qualquer lugar.</p></div>
        <div class="filter-row"><button class="filter active" data-filter="all">Todos</button><button class="filter" data-filter="featured">Em destaque</button><button class="filter" data-filter="retrô">Retrô</button><span class="product-count">{{ $products->count() }} peças disponíveis</span></div>
        <div class="product-grid" id="product-grid">
            @forelse($products as $product)
                <article class="product-card reveal" data-category="{{ $product->featured ? 'featured' : (str_contains(strtolower($product->team), 'retr') ? 'retrô' : 'all') }}">
                    <a class="product-visual" href="{{ route('store.show', $product) }}">
                        @if($product->compare_price)<span class="product-badge">Edição especial</span>@endif
                        <img src="{{ $product->image_url ?: asset('images/logo.jpg') }}" alt="{{ $product->name }}" loading="lazy">
                        <span class="view-product">Ver detalhes <b>↗</b></span>
                    </a>
                    <div class="product-info"><div><span class="product-team">{{ $product->team }} @if($product->season) · {{ $product->season }} @endif</span><h3>{{ $product->name }}</h3></div><div class="price-block"><strong>{{ $product->formatted_price }}</strong>@if($product->compare_price)<del>R$ {{ number_format((float)$product->compare_price, 2, ',', '.') }}</del>@endif</div></div>
                    @php
                        $cartProduct = [
                            'id' => $product->id,
                            'name' => $product->name,
                            'team' => $product->team,
                            'price' => (float) $product->price,
                            'image' => $product->image_url ?: asset('images/logo.jpg'),
                            'sizes' => $product->sizes ?: ['P', 'M', 'G', 'GG'],
                        ];
                    @endphp
                    <button class="add-button" type="button" onclick='window.ParaísoCart.add(@json($cartProduct))'>Adicionar ao carrinho <span>+</span></button>
                </article>
            @empty
                <div class="empty-products"><h3>Estamos preparando os próximos mantos.</h3><p>Volte em breve para conhecer a coleção.</p></div>
            @endforelse
        </div>
    </section>

    @php($featuredMantos = $products->take(5))
    <section class="manifesto-section" id="manifesto">
        <div class="mantos-stage reveal" data-mantos-stage>
            <div class="stage-lines"></div>
            <div class="stage-score"><span>PARAÍSO FC</span><strong>11 <b>:</b> 01</strong><small>COLEÇÃO EM CAMPO</small></div>
            <div class="stage-marker marker-one">★<span>CURADORIA</span></div>
            <div class="stage-marker marker-two">01<span>MANTO</span></div>
            <div class="mantos-display" data-mantos-display>
                <span class="display-tag">EM DESTAQUE</span>
                <div class="display-glow"></div>
                <img class="mantos-main-image" data-mantos-image src="{{ optional($featuredMantos->first())->image_url ?: asset('images/logo.jpg') }}" alt="{{ optional($featuredMantos->first())->name ?: 'Manto em destaque' }}">
                <div class="display-caption"><span data-mantos-team>{{ optional($featuredMantos->first())->team ?: 'Paraíso dos Mantos' }}</span><strong data-mantos-name>{{ optional($featuredMantos->first())->name ?: 'Escolha seu manto' }}</strong></div>
                <span class="size-chip">P · M · G · GG</span>
            </div>
            <div class="mantos-selector" role="tablist" aria-label="Selecionar manto">
                @foreach($featuredMantos as $mantosProduct)
                    <button class="mantos-thumb {{ $loop->first ? 'active' : '' }}" type="button" role="tab" aria-selected="{{ $loop->first ? 'true' : 'false' }}" data-mantos-thumb data-image="{{ $mantosProduct->image_url ?: asset('images/logo.jpg') }}" data-name="{{ $mantosProduct->name }}" data-team="{{ $mantosProduct->team }}" data-price="{{ $mantosProduct->formatted_price }}">
                        <img src="{{ $mantosProduct->image_url ?: asset('images/logo.jpg') }}" alt="{{ $mantosProduct->name }}">
                        <span>{{ $mantosProduct->team }}</span>
                    </button>
                @endforeach
            </div>
        </div>
        <div class="manifesto-copy reveal"><span class="eyebrow">MAIS QUE UMA CAMISA</span><h2>O futebol mora<br><em>na gente.</em></h2><p>Em cada escudo, uma história. Explore os mantos selecionados, escolha seu tamanho e leve para casa a camisa que representa você.</p><div class="manifesto-meta"><span><b data-mantos-price>{{ optional($featuredMantos->first())->formatted_price ?: '—' }}</b><small>preço do manto</small></span><span><b>05</b><small>clubes na curadoria</small></span></div><a class="text-link" href="#colecao">Conheça os mantos <span>↗</span></a></div>
    </section>

    <section class="service-section section-shell"><div class="service-item"><span>01</span><h3>Curadoria real</h3><p>Peças escolhidas com olhar de torcedor.</p></div><div class="service-item"><span>02</span><h3>Atendimento próximo</h3><p>Fale direto com quem entende de manto.</p></div><div class="service-item"><span>03</span><h3>Compra simples</h3><p>Escolha, mande no WhatsApp e pronto.</p></div></section>
</main>
<footer class="site-footer"><div class="footer-brand"><img src="{{ asset('images/logo.jpg') }}" alt="Paraíso dos Mantos"><span>Paraíso dos Mantos</span></div><p>Futebol para vestir. Histórias para guardar.</p><small>© {{ date('Y') }} Paraíso dos Mantos</small></footer>
@endsection
