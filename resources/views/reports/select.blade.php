@extends('layouts.app')
@section('content')
  <section class="col-sm-8 offset-sm-2 bg-white border rounded mb-2 py-2">
    <form class="form-inline justify-content-center " action="{{route('reports.today')}}" method="post">
      @csrf
      <select class="form-control-lg mr-sm-2" name="product">
        @foreach ($products as $product)
          <option value="{{$product->id}}">{{$product->name}}</option>
        @endforeach
      </select>
      <button type="submit" class="btn btn-warning btn-lg ">Reporte Hoy</button>
    </form>
    <hr>
    <form class="form-inline justify-content-center" action="{{route('reports.day')}}" method="post">
      @csrf
      <select class="form-control-lg mr-sm-2" name="product">
        @foreach ($products as $product)
          <option value="{{$product->id}}">{{$product->name}}</option>
        @endforeach
      </select>
      <input type="date" name="date" class="form-control-lg mr-sm-2" required>
      <button type="submit" class="btn btn-warning btn-lg ">Reporte dia</button>
    </form>
    <hr>
    <form class="form-inline justify-content-center" action="{{route('reports.month')}}" method="post">
      @csrf
      <select class="form-control-lg mr-sm-2" name="product">
        @foreach ($products as $product)
          <option value="{{$product->id}}">{{$product->name}}</option>
        @endforeach
      </select>
      <input type="date" name="date" class="form-control-lg mr-sm-2" required>
      <button type="submit" class="btn btn-warning btn-lg ">Reporte Mes</button>
    </form>
    <hr>
    <form class="form-inline justify-content-center" action="{{route('reports.range')}}" method="post">
      @csrf
      <select class="form-control-lg mr-sm-2" name="product">
        @foreach ($products as $product)
          <option value="{{$product->id}}">{{$product->name}}</option>
        @endforeach
      </select>
      de: <input type="date" name="star" class="form-control-lg mr-sm-2" required>
      al :<input type="date" name="end" class="form-control-lg mr-sm-2" required>
      <button type="submit" class="btn btn-warning btn-lg ">ver Reporte</button>
    </form>
  </section>

@endsection
