@extends('layouts.app')

@section('content')
<section class="card row">
  <div class="card-header bg-transparent "> <h1>Crear Producto</h1>
  </div>
  <div class="card-body">
    <form class="" action="{{route('products.store')}}" method="post">
      @csrf
      @include('products.partials.form')
    </form>
  </div>
</section>

@endsection
