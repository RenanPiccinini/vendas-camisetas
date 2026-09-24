@extends('layouts.admin')
@section('content')<div class="admin-title-row"><div><span class="eyebrow">EDITAR PEÇA</span><h1>{{ $product->name }}</h1><p>Atualize os detalhes desta camiseta.</p></div><a class="back-link" href="{{ route('admin.products.index') }}">← Voltar</a></div>@include('admin.products.form', ['action' => route('admin.products.update', $product), 'method' => 'PUT'])@endsection
