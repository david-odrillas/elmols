@extends('layouts.app')

@section('content')
<section class="card row">
  <div class="card-header bg-transparent ">
    <h1>{{$product->name}}: Modificar Unidad</h1>
  </div>
  <div class="card-body">
    <form class="" action="{{route('products.units.update', [$product->id, $unit->id])}}" method="post">
      @csrf
      @method('PUT')
      @include('units.partials.form')
    </form>
  </div>
</section>

@endsection
