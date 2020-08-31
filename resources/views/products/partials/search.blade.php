<section class="col-sm-8 mb-1">
  <form method="get" autocomplete="off">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Buscar" name="name" required>
      <div class="input-group-append">
        <button class="btn btn-outline-primary" type="submit">Buscar</button>
      </div>
    </div>
  </form>
</section>
<section class="col-sm-3 mb-1">
  @can ('products.create')
    <a class="btn btn-warning float-right" href="{{ route('products.create') }}" role="button">Agregar Producto</a>
  @endcan

</section>
<section class="col-sm-1">
  <a class="btn btn-secondary float-right" href="{{ route('products.deletes') }}">Inactivos</a>
</section>
