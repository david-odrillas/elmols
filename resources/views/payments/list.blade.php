@extends('layouts.app')
@section('content')
<section class="row ">
  <div class="col-12">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col" class="h3 col-md-6">Cliente: {{$client->name}} </th>
          <th colspan="2" />
        </tr>
        <tr>
          <th>Mes</th>
          <th>Monto</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        @forelse($wallets as $wallet)
        <tr>
          <td>
            {{$wallet->months}}
          </td>
          <td>
            {{$wallet->total}}
          </td>
          <td class="font-weight-bold">
          @if($wallet->deleted_at)
            <span class="text-success">Pagado</span>
          @else
            <span class="text-danger">No pagado</span>
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
