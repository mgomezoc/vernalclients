<section class="section">
    <div class="section-header">
        <h1 class="section-title">
            <i class="fa-solid fa-people-simple"></i>
            <span>Clientes</span>
        </h1>
        <div>
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">Añadir
                nuevo</button>
        </div>
    </div>

    <div class="card card-body">
        <div class="section-table">
            <div class="table-responsive">
                <table id="tablaClientes" class="table table-striped table-sm table-linklaw">
                    <thead>
                        <tr>
                            <th data-field="id_cliente">ID</th>
                            <th data-field="nombre" data-formatter="formatoNombre" data-sortable="true">Nombre</th>
                            <th data-field="nombre_sucursal">Sucursal</th>
                            <th data-field="telefono" data-sortable="true">Teléfono</th>
                            <th data-field="nombre_estatus">Estatus</th>
                            <th data-field="fecha_ultima_actualizacion">Ultima Actualización</th>
                            <th data-field="fecha_creado" data-sortable="true">Creado</th>
                            <th data-field="slug" data-formatter="accionesTablaUsuarios" data-align="center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- ACCIONES TABLA -->
<template id="tplAccionesTabla">
    <a href="<?= base_url("intake") ?>/{{slug}}" class="btn btn-sm btn-outline-light text-dark" target="_blank">
        <i class="fa-duotone fa-arrow-up-right-from-square me-2"></i>
        <span>intake</span>
    </a>
    <button class="btnEliminarAbogado btn btn-sm btn-danger" data-id="{{abogado_id}}" title="Eliminar a {{usuario_nombre}} {{usuario_apellido_paterno}} {{apellido_materno}}">
        <i class="fa-solid fa-user-xmark"></i>
    </button>
</template>

<!-- Modal -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir nuevo cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="frmNuevoCliente" action="#" method="post" class="row g-5">
                        <div class="col-md-4">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Teléfono</label>
                            <input type="number" name="telefono" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="nuevo_sucursal" class="form-label">Sucursal</label>
                            <div class="d-flex flex-column-reverse">
                                <select name="sucursal" id="nuevo_sucursal" class="select2 form-select" required>
                                    <option value="">Seleccionar Sucursal</option>
                                    <?php foreach ($sucursales as $sucursal) : ?>
                                        <option value="<?= esc($sucursal['id']) ?>">
                                            <?= esc($sucursal['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="clienteSlug"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button id="btnAgregarCliente" type="button" class="btn btn-primary">Añadir nuevo cliente</button>
            </div>
        </div>
    </div>
</div>

<template id="tplClienteSlug">
    <div class="p-3 text-center">
        <div class="mb-3">Esta es la url del formulario de admisión <a href="<?= base_url("/") ?>intake/{{this}}" id="linkSlug" target="_blank"><?= base_url("/") ?>intake/{{this}} <i class="fa-duotone fa-arrow-up-right-from-square"></i></a></div>
        <div>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="btnCopiarSlug">
                <i class="fa-duotone fa-copy"></i>
                <span>copiar!</span>
            </button>
        </div>
    </div>
</template>