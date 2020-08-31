@extends('layouts.app')

@section('content')
<section class="card row">
  <div class="card-header bg-transparent "> <h1>{{$product->name}}: Crear Unidad</h1>
  </div>
  <div class="card-body">
    <form class="" action="{{route('products.units.store', $product->id)}}" method="post">
      @csrf
      @include('units.partials.form')
    </form>
  </div>
</section>

@endsection
