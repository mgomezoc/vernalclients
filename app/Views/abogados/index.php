<section class="section">
    <div class="section-header">
        <h1 class="section-title"><i class="fa-solid fa-gavel"></i> Abogados</h1>
        <div>
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoAbogado">Añadir nuevo</button>
        </div>
    </div>

    <div class="card card-body">
        <div class="section-table">
            <div class="table-responsive">
                <table id="tablaAbogados" class="table table-striped table-sm table-linklaw">
                    <thead>
                        <tr>
                            <th data-field="usuario_nombre" data-sortable="true">Nombre</th>
                            <th data-field="usuario_apellido_paterno">Apellido</th>
                            <th data-field="correo_electronico">Correo</th>
                            <th data-field="sucursal_nombre" data-sortable="true">Sucursal</th>
                            <th data-field="telefono" data-sortable="true">Teléfono</th>
                            <th data-field="casos_count">Casos</th>
                            <th data-field="id" data-formatter="accionesTablaUsuarios" data-align="center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- ACCIONES TABLA -->
<template id="tplAccionesTabla">
    <button class="btnEliminarAbogado btn btn-sm btn-danger" data-id="{{abogado_id}}" title="Eliminar a {{usuario_nombre}} {{usuario_apellido_paterno}} {{usuario_apellido_materno}}">
        <i class="fa-solid fa-user-xmark"></i>
    </button>
</template>
<!-- MODAL NUEVO ABOGADO -->
<div class="modal fade" id="modalNuevoAbogado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir nuevo abogado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="frmAgregarAbogado" action="#" method="post" class="row g-5">
                        <div class="col-md-4">
                            <label for="nuevo_usuario" class="form-label">Usuario</label>
                            <div class="d-flex flex-column-reverse">
                                <select name="id_usuario" id="nuevo_usuario" class="select2 form-select" required>
                                    <option value="">Seleccionar Usuario</option>
                                    <?php foreach ($usuarios as $usuario) : ?>
                                        <option value="<?= esc($usuario['id']) ?>">
                                            <?= esc($usuario['nombre']) ?> <?= esc($usuario['apellido_paterno']) ?> <?= esc($usuario['apellido_materno']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="nuevo_sucursal" class="form-label">Sucursal</label>
                            <div class="d-flex flex-column-reverse">
                                <select name="id_sucursal" id="nuevo_sucursal" class="select2 form-select" required>
                                    <option value="">Seleccionar Sucursal</option>
                                    <?php foreach ($sucursales as $sucursal) : ?>
                                        <option value="<?= esc($sucursal['id']) ?>">
                                            <?= esc($sucursal['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="containerInfoUsuario" class="row g-5"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="nuevo_especialidad">Especialidad</label>
                            <select name="especialidad" id="nuevo_especialidad" class="select2 form-select">
                                <option value="">Seleccionar Especialidad</option>
                                <option value="Derecho de Inmigración">Derecho de Inmigración</option>
                                <option value="Visas y Ciudadanía">Visas y Ciudadanía</option>
                                <option value="Defensa de Deportación">Defensa de Deportación</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="nuevo_telefono">Teléfono</label>
                            <input type="text" id="nuevo_telefono" name="telefono" class="form-control" placeholder="Su teléfono" required>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button id="btnAgregarAbogado" type="button" class="btn btn-primary">Añadir nuevo abogado</button>
            </div>
        </div>
    </div>
</div>

<template id="tplInfoUsuario">
    <div class="col-md-4">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" id="name" name="nombre" value="{{nombre}}" class="form-control" placeholder="Su nombre" disabled>
    </div>
    <div class="col-md-4">
        <label for="lastname" class="form-label">Apellido Paterno</label>
        <input type="text" id="lastname" name="apellido_paterno" value="{{apellido_paterno}}" class="form-control" placeholder="Su apellido paterno" disabled>
    </div>
    <div class="col-md-4">
        <label for="mothers-lastname" class="form-label">Apellido Materno</label>
        <input type="text" id="mothers-lastname" name="apellido_materno" value="{{apellido_materno}}" class="form-control" placeholder="Su apellido materno" disabled>
    </div>
    <div class="col-md-4">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" id="email" name="correo_electronico" value="{{correo_electronico}}" class="form-control" placeholder="Su correo electrónico" disabled>
    </div>
</template>

<template id="tplEditarAbogado">
    <div class="card card-body p-5">
        <form action="#" method="post" class="frmEditarAbogado row g-5">
            <input type="hidden" name="abogado_id" value="{{abogado_id}}">
            <div class="col-md-4">
                <label class="form-label">Usuario</label>
                <select name="id_usuario" class="cbUsuarios form-select" data-selected="{{usuario_id}}" data-target="#containerInfoUsuario-{{abogado_id}}" required>
                    <option value="">Seleccionar Usuario</option>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <option value="<?= esc($usuario['id']) ?>">
                            <?= esc($usuario['nombre']) ?> <?= esc($usuario['apellido_paterno']) ?> <?= esc($usuario['apellido_materno']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Sucursal</label>
                <select name="id_sucursal" class="form-select" data-selected="{{sucursal_id}}" required>
                    <option value="">Seleccionar Sucursal</option>
                    <?php foreach ($sucursales as $sucursal) : ?>
                        <option value="<?= esc($sucursal['id']) ?>">
                            <?= esc($sucursal['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <div id="containerInfoUsuario-{{abogado_id}}" class="row g-5">
                    <div class="col-md-4">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" value="{{usuario_nombre}}" class="form-control" placeholder="Su nombre" disabled>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Apellido Paterno</label>
                        <input type="text" name="apellido_paterno" value="{{usuario_apellido_paterno}}" class="form-control" placeholder="Su apellido paterno" disabled>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Apellido Materno</label>
                        <input type="text" name="apellido_materno" value="{{usuario_apellido_materno}}" class="form-control" placeholder="Su apellido materno" disabled>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo_electronico" value="{{correo_electronico}}" class="form-control" placeholder="Su correo electrónico" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label for="nuevo_especialidad">Especialidad</label>
                <select name="especialidad" id="nuevo_especialidad" class="form-select" data-selected="{{especialidad}}">
                    <option value="">Seleccionar Especialidad</option>
                    <option value="Derecho de Inmigración">Derecho de Inmigración</option>
                    <option value="Visas y Ciudadanía">Visas y Ciudadanía</option>
                    <option value="Defensa de Deportación">Defensa de Deportación</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="nuevo_telefono">Teléfono</label>
                <input type="text" id="nuevo_telefono" name="telefono" class="form-control" placeholder="Su teléfono" value="{{telefono}}" required>
            </div>
            <div class="col-12 mt-5">
                <button type="submit" class="btn btn-primary">Actualizar información</button>
            </div>
        </form>
    </div>
</template>

<script>
    const Usuarios = <?= json_encode($usuarios) ?>;
</script>