@extends('layouts.app')
@section('content')
<section class="row ">
  <div class="col-12">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col" class="h3 col-md-6">Ventas por Producto</th>
          <th colspan="4" />
        </tr>
        <tr>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Volumen</th>
          <th>Nro Venta</th>
          <th>Total(lb)</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $product)
        <tr>
          <th scope="row">{{$product->name}}</th>
          <td>
            {{$product->quantity}}
          </td>
          <td>
            {{$product->volumen}}
          </td>
          <td>
            {{$product->sale_id}}
          </td>
          <td>
            {{$product->total}}
          </td>
        </tr>
        @empty
          <tr>
            <th colspan="4">No hay Productos vendidos en fecha indicada</th>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>
@endsection
