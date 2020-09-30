<div class="form-group row">
    <label for="volumen" class="col-md-2 col-form-label text-md-right">{{ __('Cantidad') }}</label>

    <div class="col-md-8">
        <input id="volumen" type="text" class="form-control @error('volumen') is-invalid @enderror" name="volumen" value="{{ old('volumen', $unit->volumen) }}" required autocomplete="volumen" autofocus>

        @error('volumen')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="price" class="col-md-2 col-form-label text-md-right">{{ __('Precio') }}</label>

    <div class="col-md-8">
        <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $unit->price) }}" required autocomplete="price">

        @error('price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="quantity" class="col-md-2 col-form-label text-md-right">{{ __('Libras') }}</label>

    <div class="col-md-8">
        <input id="quantity" type="text" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $unit->quantity) }}" required>

        @error('quantity')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="sponsor" class="col-md-2 col-form-label text-md-right">{{ __('Patrocinador') }}</label>

    <div class="col-md-8">
        <input id="sponsor" type="text" class="form-control @error('sponsor') is-invalid @enderror" name="sponsor" value="{{ old('sponsor', $unit->sponsor) }}" required autocomplete="sponsor" autofocus>

        @error('sponsor')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="supsponsor" class="col-md-2 col-form-label text-md-right">{{ __('Abuelo') }}</label>

    <div class="col-md-8">
        <input id="supsponsor" type="text" class="form-control @error('supsponsor') is-invalid @enderror" name="supsponsor" value="{{ old('supsponsor', $unit->supsponsor) }}" required autocomplete="supsponsor" autofocus>

        @error('supsponsor')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-2">
        <button type="submit" class="btn btn-warning btn-lg">
            {{ __('Guardar') }}
        </button>
    </div>
</div>
