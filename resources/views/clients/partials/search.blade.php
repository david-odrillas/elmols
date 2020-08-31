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
<section class="col-sm-4 mb-1">
  @can ('users.create')
    <a class="btn btn-warning float-right" href="{{ route('clients.create') }}" role="button">Registrar Nuevo</a>
  @endcan
</section>
