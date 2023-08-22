<div class="card card-body">
  <div class="section-header">
    <h1 class="section-title">Usuarios</h1>
    <div>
      <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">Añadir
        nuevo</button>
    </div>
  </div>
  <div class="section-table">
    <div class="table-responsive">
      <table id="tablaUsuarios" class="table table-striped table-sm table-linklaw">
        <thead>
          <tr>
            <th data-field="nombre" data-sortable="true">Nombre</th>
            <th data-field="apellido_paterno">Apellido</th>
            <th data-field="correo_electronico">Correo</th>
            <th data-field="perfil" data-sortable="true">Perfil</th>
            <th data-field="fecha_creacion" data-sortable="true">Creado</th>
            <th data-field="id" data-formatter="accionesTablaUsuarios">Acciones</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<template id="tplAccionesTabla">
  <button class="btnEliminarUsuario btn btn-sm btn-danger" data-id="{{id}}" title="Eliminar a {{nombre}} {{apellido_paterno}} {{apellido_materno}}">
    <i class="fa-solid fa-user-xmark"></i>
  </button>
</template>

<template id="tplEditarUsuario">
  <div class="p-5">
    <form method="post" class="frmEditarUsuario row g-3">
      <input type="hidden" name="id" value="{{id}}">
      <div class="col-md-4">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" id="name" name="nombre" value="{{nombre}}" class="form-control" placeholder="Su nombre" required>
      </div>
      <div class="col-md-4">
        <label for="lastname" class="form-label">Apellido Paterno</label>
        <input type="text" id="lastname" name="apellido_paterno" value="{{apellido_paterno}}" class="form-control" placeholder="Su apellido paterno" required>
      </div>
      <div class="col-md-4">
        <label for="mothers-lastname" class="form-label">Apellido Materno</label>
        <input type="text" id="mothers-lastname" name="apellido_materno" value="{{apellido_materno}}" class="form-control" placeholder="Su apellido materno">
      </div>
      <div class="col-md-4">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" id="email" name="correo_electronico" value="{{correo_electronico}}" class="form-control" placeholder="Su correo electrónico" required>
      </div>
      <div class="col-md-4">
        <label for="profile" class="form-label">Perfil</label>
        <select name="perfil" id="profile" class="cbPerfiles form-select" required>
          <option value="">Selecciona una opción</option>
          <option value="1">Administrador</option>
          <option value="2">Abogado</option>
          <option value="3">Recepción</option>
        </select>
      </div>
      <div class="col-12 mt-5">
        <button type="submit" class="btn btn-primary">Actualizar información</button>
      </div>
    </form>
  </div>
</template>

<!-- Modal -->
<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir nuevo usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form id="frmAgregarUsuario" action="#" method="post" class="row g-5">
            <div class="col-md-4">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" id="name" name="nombre" class="form-control" placeholder="Su nombre" required>
            </div>
            <div class="col-md-4">
              <label for="lastname" class="form-label">Apellido Paterno</label>
              <input type="text" id="lastname" name="apellido_paterno" class="form-control" placeholder="Su apellido paterno" required>
            </div>
            <div class="col-md-4">
              <label for="mothers-lastname" class="form-label">Apellido Materno</label>
              <input type="text" id="mothers-lastname" name="apellido_materno" class="form-control" placeholder="Su apellido materno">
            </div>
            <div class="col-md-4">
              <label for="email" class="form-label">Correo Electrónico</label>
              <input type="email" id="email" name="correo_electronico" class="form-control" placeholder="Su correo electrónico" required>
            </div>
            <div class="col-md-4">
              <label for="profile" class="form-label">Perfil</label>
              <select name="perfil" id="profile" class="form-select" required>
                <option value="">Selecciona una opción</option>
                <option value="1">Administrador</option>
                <option value="2">Abogado</option>
                <option value="3">Recepción</option>
              </select>
            </div>
            <div class="col-12">
              <div class="row g-5">
                <div class="col-md-4">
                  <label for="password" class="form-label">Contraseña</label>
                  <input type="password" id="password" name="contrasena" class="form-control" placeholder="Su contraseña" required>
                </div>
                <div class="col-md-4">
                  <label for="confirm-password" class="form-label">Confirmar Contraseña</label>
                  <input type="password" id="confirmarPassword" name="confirmarPassword" class="form-control" placeholder="Confirme su contraseña" required>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button id="btnAgregarUsuario" type="button" class="btn btn-primary">Añadir nuevo usuario</button>
      </div>
    </div>
  </div>
</div>

<script>
  const Usuarios = <?= json_encode($usuarios) ?>;
</script>