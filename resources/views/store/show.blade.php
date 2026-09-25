@extends('layouts.store')

@section('content')
@php
    $cartProduct = [
        'id' => $product->id,
        'name' => $product->name,
        'team' => $product->team,
        'price' => (float) $product->price,
        'image' => $product->image_source ?: asset('images/logo.jpg'),
        'sizes' => $product->sizes ?: ['P', 'M', 'G', 'GG'],
    ];
@endphp
<main class="product-detail section-shell">
    <a class="back-link" href="{{ route('store.home') }}#colecao">← Voltar para a coleção</a>
    <div class="detail-grid">
        <div class="detail-image"><img src="{{ $product->image_source ?: asset('images/logo.jpg') }}" alt="{{ $product->name }}"></div>
        <div class="detail-copy"><span class="eyebrow">{{ $product->team }} @if($product->season) · {{ $product->season }} @endif</span><h1>{{ $product->name }}</h1><p class="detail-price">{{ $product->formatted_price }}</p><p class="detail-description">{{ $product->description }}</p><div class="size-picker"><span>Tamanho</span><div>@foreach(($product->sizes ?: ['P','M','G','GG']) as $size)<button type="button" class="size-button {{ $loop->first ? 'selected' : '' }}" data-size="{{ $size }}">{{ $size }}</button>@endforeach</div></div><button class="gold-button full" type="button" onclick='window.ParaísoCart.add(@json($cartProduct), document.querySelector(".size-button.selected")?.dataset.size)'>Adicionar ao carrinho <span>+</span></button><div class="detail-note">✓ Estoque disponível · Atendimento personalizado pelo WhatsApp</div></div>
    </div>
</main>
@endsection
