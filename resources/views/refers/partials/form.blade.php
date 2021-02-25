<div class="form-group row">
  <label for="ci" class="col-md-4 col-form-label text-md-right">{{ __('CI:') }}</label>
  <div class="col-md-6">
      <input id="ci" type="text" class="form-control @error('ci') is-invalid @enderror" name="ci" value="{{ old('ci') }}" required autocomplete="off" autofocus>

      @error('ci')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
  </div>
</div>
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
    <div class="col-md-6">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="off" >

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
  <label for="cell" class="col-md-4 col-form-label text-md-right">{{ __('Celular:') }}</label>
  <div class="col-md-6">
      <input id="cell" type="text" class="form-control @error('cell') is-invalid @enderror" name="cell" value="{{ old('cell') }}" required autocomplete="off" >

      @error('cell')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
  </div>
</div>
<div class="form-group row">
  <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Direccion:') }}</label>
  <div class="col-md-6">
      <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="off" >

      @error('address')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
  </div>
</div>
<div class="form-group row">
  <label for="patrocinador" class="col-md-4 col-form-label text-md-right">{{ __('Patrocinador:') }}</label>
  <div class="col-md-6">
      <input id="patrocinador" type="text" readonly class="form-control-plaintext" name="patrocinador" value="{{$client->name}}">
  </div>
</div>

<div class="form-group row">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-warning">
            {{ __('Registrar') }}
        </button>
    </div>
</div>
