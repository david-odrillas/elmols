@extends('layouts.app')
@section('content')
<section class="row ">
  <div class="col-12">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col" class="h3 col-md-6">Producto: {{$product->name}} </th>
          <th colspan="4" />
          <th>
            @can ('products.create')
              <a class="btn btn-warning float-right" href="{{ route('products.units.create', $product->id) }}" role="button">Agregar Unidad</a>
            @endcan
          </th>
        </tr>
        <tr>
          <th>CANTIDAD</th>
          <th>PRECIO</th>
          <th>PATROCINADOR</th>
          <th>ABUELO</th>
          <th>-</th>
          <th>-</th>
        </tr>
      </thead>
      <tbody>
        @forelse($units as $unit)
        <tr>
          <td scope="row">{{$unit->volumen}}</td>
          <td>
            {{$unit->price}}
          </td>
          <td>
            {{$unit->sponsor}}
          </td>
          <td>
            {{$unit->supsponsor}}
          </td>
          <td>
            @can ('products.edit')
              <a class="btn btn-primary btn-block" href="{{ route('products.units.edit', [$product->id, $unit->id]) }}" role="button">Editar</a>
            @endcan

          </td>
          <td>
            @can ('products.destroy')
              <a class="btn btn-danger btn-block delete-row" href="{{route('products.units.destroy', [$product->id, $unit->id])}}">Eliminar</a>
            @endcan
          </td>
        </tr>
        @empty
          <tr>
            <th colspan="4">El producto no tiene Unidades registradas.</th>
          </tr>
        @endforelse
      </tbody>
    </table>
  {{-- {{ $products->render() }} --}}
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
