@extends('layouts.admin')
@section('content')<div class="admin-title-row"><div><span class="eyebrow">NOVA PEÇA</span><h1>Adicionar camiseta</h1><p>Preencha os detalhes para publicar um novo manto.</p></div><a class="back-link" href="{{ route('admin.products.index') }}">← Voltar</a></div>@include('admin.products.form', ['action' => route('admin.products.store'), 'method' => 'POST'])@endsection
