@extends('layouts.app')
@section('content')
<section class="row ">
  <div class="col-12">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th scope="col" class="h3 col-md-6">{{$client->name}} <span class="text-muted">(referidos)</span> </th>
          <th colspan="2" />
          <th>
            @can ('users.create')
              <a class="btn btn-warning float-right" href="{{ route('clients.refers.create', $client->id) }}" role="button">Agregar Referido</a>
            @endcan
          </th>
        </tr>
        <tr>
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">C. I.</th>
            <th scope="col">Telefono</th>
            <th>-</th>
          </tr>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr>
          <td scope="row">{{$user->name}}</td>
          <td>
            {{$user->ci}}
          </td>
          <td>
            {{$user->cell}}
          </td>
          <td>
            @can ('users.index')
              <a class="btn btn-primary btn-block" href="{{ route('clients.refers.index', $user->id) }}" role="button">Ver Referidos</a>
            @endcan
          </td>
        </tr>
      @empty
        <tr class="text-muted">
          <td colspan="5"><strong>{{$client->name}}</strong> , No tiene Referidos.</td>
        </tr>
      @endforelse
      </tbody>
    </table>
    {{ $users->render() }}
  </div>


</section>
@endsection
