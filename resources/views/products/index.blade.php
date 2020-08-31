@extends('layouts.app')
@section('content')
<section class="row bg-white border rounded mb-2 py-2">
  @include('products.partials.search')
</section>
<section class="row ">
  <div class="col-12">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col" class="h3 col-md-6">Listado de Productos</th>
          <th colspan="3" />
        </tr>
      </thead>
      <tbody>
        @forelse($products as $product)
        <tr>
          <th scope="row">{{$product->name}}</th>
          <td>
            <a class="btn btn-info btn-block" href="{{route('products.units.index', $product->id)}}" role="button">Ver unidades</a>
          </td>
          <td>
            @can ('products.edit')
              <a class="btn btn-primary btn-block" href="{{ route('products.edit', $product->id) }}" role="button">Editar</a>
            @endcan

          </td>
          <td>
            @can ('products.destroy')
              <a class="btn btn-danger btn-block delete-row" href="{{route('products.destroy', $product->id)}}">Eliminar</a>
            @endcan
          </td>
        </tr>
        @empty
          <tr>
            <th colspan="4">No hay Productos registrados, o activos. Revise los inactivos</th>
          </tr>
        @endforelse
      </tbody>
    </table>
  {{ $products->render() }}
  </div>

  <div class="modal delete-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminando Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Esta seguro de Eliminar este Registro?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <form class="delete-form" method="post">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Si, Estoy Seguro</button>
        </form>
      </div>
    </div>
  </div>
</div>
</section>
@endsection
