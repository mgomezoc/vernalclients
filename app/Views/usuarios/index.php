<div class="card card-body">
  <div class="section-header">
    <h1 class="section-title">Usuarios</h1>
    <div>
      <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Añadir
        nuevo</button>
    </div>
  </div>
  <div class="section-table">
    <div class="table-responsive">
      <table id="table" class="table table-striped table-sm table-linklaw">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Perfil</th>
            <th>Acciones</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir nuevo usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="post" class="row g-3">
          <div class="col-md-4">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" id="name" class="form-control" placeholder="Su nombre">
          </div>
          <div class="col-md-4">
            <label for="lastname" class="form-label">Apellido Paterno</label>
            <input type="text" id="lastname" class="form-control" placeholder="Su apellido paterno">
          </div>
          <div class="col-md-4">
            <label for="mothers-lastname" class="form-label">Apellido Materno</label>
            <input type="text" id="mothers-lastname" class="form-control" placeholder="Su apellido materno">
          </div>
          <div class="col-md-4">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" id="email" class="form-control" placeholder="Su correo electrónico">
          </div>
          <div class="col-md-4">
            <label for="profile" class="form-label">Perfil</label>
            <select name="profile" id="profile" class="form-select">
              <option value="">Selecciona una opción</option>
              <option value="1">Admin</option>
              <option value="2">Usuario</option>
            </select>
          </div>
          <div class="col-12">
            <div class="row g-3">
              <div class="col-md-4">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" id="password" class="form-control" placeholder="Su contraseña">
              </div>
              <div class="col-md-4">
                <label for="confirm-password" class="form-label">Confirmar Contraseña</label>
                <input type="password" id="confirm-password" class="form-control" placeholder="Confirme su contraseña">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Añadir nuevo usuario</button>
      </div>
    </div>
  </div>
</div>

<script>
  const Usuarios = <?= json_encode($usuarios) ?>;
</script>