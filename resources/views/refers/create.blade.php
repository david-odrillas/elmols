@extends('layouts.app')

@section('content')
<section class="card row">
  <div class="card-header bg-transparent "> <h1>Registrar Cliente</h1>
  </div>
  <div class="card-body">
    <form class="" action="{{route('clients.refers.store', $client->id)}}" method="post">
      @csrf
      @include('refers.partials.form')
    </form>
  </div>
</section>

@endsection
