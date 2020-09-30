@extends('layouts.app')
@section('content')
<section class="row ">
  <div class="col-12">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col" class="h3 col-md-6">Registro de Venta: {{$sale->id}}</th>
          <th colspan="4" />
        </tr>
        <tr>
          <th>Producto</th>
          <th>Unidad</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Sub Total</th>
        </tr>
      </thead>
      <tbody>
        @forelse($details as $detail)
        <tr>
          <td scope="row"> {{$detail->name}}</td>
          <td>{{$detail->volumen}}</td>

          <td>
            {{$detail->quantity}}
          </td>
          <td>
            {{$detail->price}}
          </td>
          <td>
            {{$detail->total}}
          </td>
        </tr>
        @empty
          <tr>
            <th colspan="4">No hay Venta Registradas.</th>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</section>
@endsection
