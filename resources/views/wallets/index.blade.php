@extends('layouts.app')
@section('content')
<section class="row ">
  <div class="col-12">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col" class="h3 col-md-6">Cliente: {{$client->name}} </th>
          <th colspan="1" />
          <th>
            @can ('sales.index')
              <a class="btn btn-warning float-right" href="{{ route('clients.sales.index', $client->id) }}" role="button">Ver Compras</a>
            @endcan
          </th>
        </tr>
        <tr>
          <th>Fecha</th>
          <th>Monto</th>
          <th>-</th>
        </tr>
      </thead>
      <tbody>
        @forelse($wallets as $wallet)
        <tr>
          <td>
            {{$wallet->created_at}}
          </td>
          <td>
            {{$wallet->amount}}
          </td>
          <td>
          @if($wallet->detail->sale)
            INGRESO VENTA Nro.{{$wallet->detail->sale->id}}
          @else
            RETIRO
          @endif
          </td>
        </tr>
        @empty
          <tr>
            <th colspan="4">El Cliente tiene la billetera vacia.</th>
          </tr>
        @endforelse
      </tbody>
    </table>
    <p class="h3 font-weight-bold">Total: {{$total}}</p>
  </div>
</section>
@endsection
