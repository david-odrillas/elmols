@extends('layouts.app')
@section('content')
<section class="col-sm-4 offset-sm-4 bg-white border rounded mb-2 py-2">
  <h4 class="py-2"> Cliente: {{$client->name}}</h4>
  <form class="form-inline justify-content-center" action="{{route('payments.search', $client->id)}}" method="post">

    @csrf
    <input type="date" name="date" class="form-control-lg mr-sm-2" required>
    <button type="submit" class="btn btn-warning btn-lg ">Consultar</button>
  </form>
  @isset($mensaje)
      <h6 class="text-danger">{{$mensaje}}</h6>
  @endisset
</section>

@endsection
