@extends('layouts.app')
@section('content')
<section class="row ">
  <div class="col-12">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col" class="h3 col-md-6">Registro de Ventas</th>
          <th colspan="3" />
        </tr>
        <tr>
          <th>Fecha</th>
          <th>Valor</th>
          <th>cliente</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sales as $sale)
        <tr>
          <td scope="row">{{$sale->created_at}}</td>

          <td>
            {{$sale->amount}}
          </td>
          <td>
            {{$sale->user->name}}
          </td>
          <td>
            <a class="btn btn-info btn-block" href="{{route('sales.details.index', $sale->id)}}" role="button">Ver detalles</a>
          </td>
        </tr>
        @empty
          <tr>
            <th colspan="4">No hay Ventas Registradas.</th>
          </tr>
        @endforelse
      </tbody>
    </table>
  {{ $sales->render() }}
  </div>

</section>
@endsection
