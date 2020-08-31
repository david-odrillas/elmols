@extends('layouts.app')

@section('content')
<section class="card row">
  <div class="card-header bg-transparent ">
    <h1>Modificar Producto</h1>
  </div>
  <div class="card-body">
    <form class="" action="{{route('products.update', $product->id)}}" method="post">
      @csrf
      @method('PUT')
      @include('products.partials.form')
    </form>
  </div>
</section>

@endsection
