<div class="form-group">
  <label for="product">Nombre del Producto</label>
  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="product"
    value="{{ old('name', $product->name)  }}" required autofocus>
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<button type="submit" class="btn btn-warning btn-lg">Guardar</button>
