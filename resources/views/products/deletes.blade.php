@extends('layouts.app')
@section('content')
<section class="row">
  <div class="col-12">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col" class="h3 col-md-6">Listado de Productos Inactivos</th>
          <th colspan="3" />
        </tr>
      </thead>
      <tbody>
        @forelse($products as $product)
        <tr>
          <th scope="row">{{$product->name}}</th>
          <td>
            <form class="" action="{{route('products.restore', $product->id)}}" method="post">
              @csrf
              @method('PUT')
              <button type="submit" class="btn btn-success btn-block">Activar</button>
            </form>
          </td>
        </tr>
        @empty
          <tr>
            <th colspan="4">No hay Productos Activos.</th>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>
@endsection
