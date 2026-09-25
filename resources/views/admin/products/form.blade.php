@php
    $availableSizes = ['PP', 'P', 'M', 'G', 'GG', 'XG'];
    $selectedSizes = old('sizes', $product->sizes ?: ['P', 'M', 'G', 'GG']);
    $selectedSizes = is_array($selectedSizes) ? $selectedSizes : preg_split('/[\s,]+/', (string) $selectedSizes, -1, PREG_SPLIT_NO_EMPTY);
@endphp
<form method="POST" action="{{ $action }}" class="admin-form" enctype="multipart/form-data">
    @csrf
    @if($method !== 'POST') @method($method) @endif
    @if($errors->any())
        <div class="form-errors"><strong>Confira os campos:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <div class="form-grid">
        <label>Nome da camiseta<input name="name" value="{{ old('name', $product->name) }}" required></label>
        <label>Time / coleção<input name="team" value="{{ old('team', $product->team) }}" required></label>
        <label>Temporada<input name="season" value="{{ old('season', $product->season) }}"></label>
        <label>URL da imagem <small>usada quando não houver upload</small><input type="url" name="image_url" value="{{ old('image_url', $product->image_path ? '' : $product->image_url) }}" placeholder="https://..."></label>
        <label>Enviar imagem <small>JPG, PNG ou WebP · até 5 MB</small><input type="file" name="image_file" accept="image/jpeg,image/png,image/webp"></label>
        <label>Preço <small>digite o valor em reais</small><input type="text" name="price" data-money-input inputmode="decimal" value="{{ old('price', $product->price) }}" placeholder="R$ 0,00" required></label>
        <label>Preço anterior <small>opcional</small><input type="text" name="compare_price" data-money-input inputmode="decimal" value="{{ old('compare_price', $product->compare_price) }}" placeholder="R$ 0,00"></label>
        <label>Estoque<input type="number" name="stock" min="0" value="{{ old('stock', $product->stock ?? 0) }}" required></label>
    </div>
    <fieldset class="size-fieldset">
        <legend>Tamanhos disponíveis <small>selecione os tamanhos em estoque</small></legend>
        <div class="size-options">
            @foreach($availableSizes as $size)
                <label class="size-option">
                    <input type="checkbox" name="sizes[]" value="{{ $size }}" @checked(in_array($size, $selectedSizes, true))>
                    <span>{{ $size }}</span>
                </label>
            @endforeach
        </div>
    </fieldset>
    @if($product->image_source)
        <div class="current-image"><span>Imagem atual</span><img src="{{ $product->image_source }}" alt="{{ $product->name ?: 'Imagem atual' }}"><small>Envie outra imagem ou informe uma nova URL para substituir.</small></div>
    @endif
    <label class="full-label">Descrição<textarea name="description" rows="4">{{ old('description', $product->description) }}</textarea></label>
    <div class="check-row">
        <label><input type="checkbox" name="featured" value="1" @checked(old('featured', $product->featured))> Exibir em destaque</label>
        <label><input type="checkbox" name="active" value="1" @checked(old('active', $product->exists ? $product->active : true))> Publicar na loja</label>
    </div>
    <div class="form-footer"><a class="back-link" href="{{ route('admin.products.index') }}">Cancelar</a><button class="gold-button" type="submit">Salvar camiseta <span>✓</span></button></div>
</form>
