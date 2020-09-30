@extends('layouts.app')
@section('content')
<section class="bg-white border rounded mb-2 py-2">
  <h2 class="offset-sm-2"> Cliente: <span class="font-weight-bold"> {{$client->name}} </span> </h2>
  <h3 class="offset-sm-2"> Compras(lb): <span class="font-weight-bold">{{$quantity}}</span></h3>
  <h3 class="offset-sm-2"> Acumulado:<span class="font-weight-bold">{{$total}}</span> </h3>
  <h3 class="offset-sm-2"> Mes:<span class="font-weight-bold">{{$month->monthName}} - {{$month->year}}</span> </h3>
  {{-- @if($total>0&&$quantity>=24) --}}
  @if($total>0&&$quantity>=24&&$wallets[0]->deleted_at == Null)
    <form class="form-inline justify-content-center" action="{{route('payments.payments', $client->id)}}" method="post">

      @csrf
      <input type="hidden" name="date" value="{{$month}}">
      <button type="submit" class="btn btn-warning btn-lg offset-sm-2">Pagar</button>
    </form>
  @endif
</section>

<section class="row">
  <div class="col-12">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col" class="h3 col-md-6">Cliente: {{$client->name}} </th>
          <th colspan="1" />
          <th>
              <a class="btn btn-warning float-right" href="{{ route('payments.list', $client->id) }}" role="button">Detalles</a>
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
  </div>

</section>
@endsection
