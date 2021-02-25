@extends('layouts.app')

@section('content')
<section class="card row">
  <div class="card-header bg-transparent ">
    <h1>Editar Cliente</h1>
  </div>
  <div class="card-body">
    <form class="" action="{{route('clients.update', $client->id)}}" method="post">
      @csrf
      @method('PUT')
      <div class="form-group row">
          <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Nombre') }}</label>

          <div class="col-md-8">
              <input id="name" type="text" class="form-control-plaintext" name="name" value="{{ old('name', $client->name) }}">

          </div>
      </div>
      <div class="form-group row">
          <label for="cell" class="col-md-2 col-form-label text-md-right">{{ __('Telefono') }}</label>

          <div class="col-md-8">
              <input id="cell" type="text" class="form-control @error('cell') is-invalid @enderror" name="cell" value="{{ old('cell', $client->cell) }}" required autocomplete="cell" autofocus>

              @error('cell')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
      </div>
      <div class="form-group row">
          <label for="address" class="col-md-2 col-form-label text-md-right">{{ __('Direccion') }}</label>

          <div class="col-md-8">
              <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $client->address) }}" required autocomplete="address" autofocus>

              @error('address')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
      </div>
      <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-2">
              <button type="submit" class="btn btn-warning btn-lg">
                  {{ __('Actualizar') }}
              </button>
          </div>
      </div>
    </form>
  </div>
</section>

@endsection
