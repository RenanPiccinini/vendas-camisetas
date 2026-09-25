@extends('layouts.store')

@section('content')
<main data-page="store-home">
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
                <article class="product-card reveal" data-reveal data-category="{{ $product->featured ? 'featured' : (str_contains(strtolower($product->team), 'retr') ? 'retrô' : 'all') }}">
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

    <section class="story-section section-shell" id="nossa-historia">
        <div class="story-intro reveal">
            <span class="eyebrow">A CULTURA DO MANTO</span>
            <h2>Não é só uma camisa.<br><em>É um pedaço do jogo.</em></h2>
            <p>Um manto acompanha fases, jogadores, títulos e histórias que a gente conta de novo. Por isso, cada peça da nossa curadoria é escolhida para vestir a paixão dentro e fora do estádio.</p>
            <a class="text-link" href="#colecao">Explorar a curadoria <span>↗</span></a>
        </div>
        <div class="story-facts">
            <article class="story-fact" data-reveal><strong>{{ str_pad($products->count(), 2, '0', STR_PAD_LEFT) }}</strong><span>clubes na coleção</span><p>Uma seleção enxuta para quem prefere escolher um manto com história.</p></article>
            <article class="story-fact" data-reveal><strong>01</strong><span>conversa para comprar</span><p>Você escolhe a peça, confirma os detalhes e fala diretamente com nossa equipe.</p></article>
            <article class="story-fact" data-reveal><strong>100%</strong><span>olhar de torcedor</span><p>Atendimento próximo, sem complicação e com atenção ao tamanho certo.</p></article>
        </div>
    </section>

    <section class="how-section section-shell" id="como-comprar">
        <div class="section-heading reveal"><div><span class="eyebrow">DO PRIMEIRO CLIQUE À ENTREGA</span><h2>Comprar seu manto<br><em>é simples.</em></h2></div><p>Monte sua seleção com calma. Quando estiver tudo certo, nossa equipe continua o atendimento pelo WhatsApp.</p></div>
        <div class="steps-grid">
            <article class="step-card" data-reveal><span class="step-number">01</span><div class="step-icon">◌</div><h3>Escolha o clube</h3><p>Conheça os modelos disponíveis, veja as fotos e abra os detalhes da camisa que chamou sua atenção.</p><a href="#colecao">Ver coleção <span>↗</span></a></article>
            <article class="step-card step-card-highlight" data-reveal><span class="step-number">02</span><div class="step-icon">＋</div><h3>Defina o tamanho</h3><p>Selecione P, M, G ou GG na página do produto e adicione a quantidade desejada ao carrinho.</p><a href="#tamanhos">Consultar tamanhos <span>↓</span></a></article>
            <article class="step-card" data-reveal><span class="step-number">03</span><div class="step-icon">↗</div><h3>Finalize no WhatsApp</h3><p>Confira seu pedido, clique em finalizar e receba nossa orientação sobre pagamento e entrega.</p><a href="https://wa.me/5535998135255" target="_blank" rel="noopener">Falar com a equipe <span>↗</span></a></article>
        </div>
    </section>

    <section class="size-care-section section-shell" id="tamanhos">
        <div class="size-guide reveal">
            <span class="eyebrow">PARA O MANTO CAIR BEM</span>
            <h2>Escolha seu<br><em>tamanho.</em></h2>
            <p>Se você já conhece a modelagem que usa, escolha o mesmo tamanho. Na dúvida, fale com a equipe antes de finalizar: ajudamos você a encontrar o caimento ideal.</p>
            <div class="size-table" role="list" aria-label="Tamanhos disponíveis"><span role="listitem">P <small>menor</small></span><span role="listitem">M <small>regular</small></span><span role="listitem">G <small>amplo</small></span><span role="listitem">GG <small>extra</small></span></div>
        </div>
        <div class="care-guide" data-reveal>
            <span class="eyebrow">LONGEVIDADE DO MANTO</span>
            <h3>Cuide da sua camisa como uma peça de coleção.</h3>
            <ul><li><b>01</b><span>Lave do avesso e prefira água fria.</span></li><li><b>02</b><span>Evite alvejante e secadora em alta temperatura.</span></li><li><b>03</b><span>Seque à sombra para preservar cores e detalhes.</span></li></ul>
            <a class="gold-button" href="https://wa.me/5535998135255" target="_blank" rel="noopener">Tirar uma dúvida <span>↗</span></a>
        </div>
    </section>

    <section class="service-section section-shell" data-reveal-group><div class="service-item" data-reveal><span>01</span><h3>Curadoria real</h3><p>Peças escolhidas com olhar de torcedor.</p></div><div class="service-item" data-reveal><span>02</span><h3>Atendimento próximo</h3><p>Fale direto com quem entende de manto.</p></div><div class="service-item" data-reveal><span>03</span><h3>Compra simples</h3><p>Escolha, mande no WhatsApp e pronto.</p></div></section>
</main>
<footer class="site-footer"><div class="footer-brand"><img src="{{ asset('images/logo.jpg') }}" alt="Paraíso dos Mantos"><span>Paraíso dos Mantos</span></div><p>Futebol para vestir. Histórias para guardar.</p><small>© {{ date('Y') }} Paraíso dos Mantos</small></footer>
@endsection
