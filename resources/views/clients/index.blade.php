@extends('layouts.app')
@section('content')
<section class="row bg-white border rounded mb-2 py-2">
  @include('clients.partials.search')
</section>
<section class="row ">
  <div class="col-12">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col" class="h3 col-md-6">Listado de Clientes</th>
          <th colspan="5" />
        </tr>
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">C. I.</th>
          <th scope="col">Telefono</th>
          <th scope="col">Codigo</th>
          <th>-</th>
          <th>-</th>
          <th>-</th>
          <th>-</th>
          <th>-</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr>
          <td scope="row">{{$user->name}} <small class="font-weight-lighter">{{$user->address}}</small>
          </td>
          <td>
            {{$user->ci}}
          </td>
          <td>
            {{$user->cell}}
          </td>
          <td>{{$user->id}}</td>
          <td>
            @can ('users.index')
              <a class="btn btn-primary btn-block" href="{{ route('clients.edit', $user->id) }}" role="button">Editar</a>
            @endcan
          </td>
          <td>
            @can ('users.index')
              <a class="btn btn-primary btn-block" href="{{ route('clients.refers.index', $user->id) }}" role="button">Referidos</a>
            @endcan
          </td>
          <td>
            @can ('users.index')
              <a class="btn btn-info btn-block" href="{{ route('clients.wallets.index', $user->id) }}" role="button">Billetera</a>
            @endcan
          </td>
          <td>
            @can ('sales.index')
              <a class="btn btn-success btn-block" href="{{ route('clients.payments', $user->id) }}" role="button">Pagos</a>
            @endcan
          </td>
          <td>
            @can ('sales.index')
              <a class="btn btn-warning btn-block" href="{{ route('clients.sales.create', $user->id) }}" role="button">Nueva Compra</a>
            @endcan
          </td>
        </tr>
      @empty
        <tr>
          <th colspan="5">No Hay Clientes, que coincidan con la busqueda</th>
        </tr>
      @endforelse
      </tbody>
    </table>
  {{ $users->render() }}
  </div>

</section>
@endsection
