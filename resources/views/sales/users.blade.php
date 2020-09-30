@extends('layouts.app')
@section('content')
<section class="row ">
  <div class="col-12">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col" class="h3 col-md-6">Compras: {{$client->name}}</th>
          <th colspan="4" />
        </tr>
        <tr>
          <th>Fecha</th>
          <th>Nro</th>
          <th>Valor</th>
          <th>-</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sales as $sale)
        <tr>
          <td scope="row"> {{$sale->created_at}}</td>
          <td>{{$sale->id}}</td>

          <td>
            {{$sale->amount}}
          </td>
          <td>
            <a class="btn btn-info btn-block" href="{{route('sales.details.index', $sale->id)}}" role="button">Ver detalles</a>
          </td>
        </tr>
        @empty
          <tr>
            <th colspan="4">El cliente no tiene compras registradas.</th>
          </tr>
        @endforelse
      </tbody>
    </table>
  {{ $sales->render() }}
  </div>

</section>
@endsection
