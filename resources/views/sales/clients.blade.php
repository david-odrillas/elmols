@extends('layouts.app')

@section('content')
<div class="container">
  <section class="row">
    <h2 class="badge badge-warning text-wrap "> <b>Cliente: {{$client->name}}</b> </h2>
  </section>
  <section class="row">
    <div class="col-md-8" id="search">
      <div class="input-group">
        <input type="search" class="form-control" placeholder="Producto" name="name" autocomplete="off" id="search-product">
      </div>
      <div class="list-group position-absolute" style="z-index:2000; width:96%" id="list-product">
      </div>
    </div>
    <div class="col-md-4">
      <p class="h1">Total: <span id="total">0.00</span> </p>
    </div>
  </section>

  <form action="{{route('clients.sales.store', $client->id)}}" method="post">
    @csrf
    <div class="form-row">
      <div class="col-md-8">
        <table class="table" id="sales-detail">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col" class="col-md-6">Producto</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Sub Total</th>
            </tr>
          </thead>
          <tbody id="det-pro">
          </tbody>
        </table>
        @if(count($errors))
          <div class="row">
            <div class="alert alert-danger">
              <p class="h2"> Ocurrio un Error en la validacion, intente de nuevo.</p>
              <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="amount">Total a Pagar:</label>
          <input type="text" name="amount" id="amount" class="form-control-plaintext text-right" value="0"/>
        </div>
        <div class="form-group">
          <label for="payment">Paga con:</label>
          <input type="number" name="payment" id="payment" class="form-control"/>
        </div>
        <div class="form-group">
          <label for="change">Su cambio es:</label>
          <input type="text" name="change" id="change" class="form-control text-right" readonly/>
        </div>
        <button type="submit" class="btn btn-warning"> Realizar Venta</button>
      </div>
    </div>
  </form>
</div>
@endsection
