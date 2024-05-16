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
                            <th data-field="nombre_estatus" data-formatter="columnaEstatus">Estatus</th>
                            <th data-field="fecha_ultima_actualizacion">Ultima Actualización</th>
                            <th data-field="fecha_creado" data-sortable="true">Creado</th>
                            <th data-field="slug" data-formatter="accionesTablaUsuarios" data-align="center"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- ACCIONES TABLA -->
<template id="tplAccionesTabla">
    <div class="dropdown">
        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-light fa-square-list"></i>
        </button>
        <ul class="dropdown-menu">
            {{#if estaInactivo}}
                <li>
                    <a href="" class="dropdown-item btnReactivar" data-id="{{id_cliente}}">
                        <i class="fa-duotone fa-power-off me-1"></i>
                        <span>Reactivar</span>
                    </a>
                </li>
            {{/if}}
            {{#if esProspecto}}
                <li>
                    <a href="<?= base_url("intake") ?>/{{slug}}" class="dropdown-item" target="_blank" title="Formulario de Admisión">
                        <i class="fa-duotone fa-arrow-up-right-from-square me-2"></i>
                        <span>Intake</span>
                    </a>
                </li>
            {{/if}}
            {{#if esIntake}}
                <li>
                    <a href="<?= base_url("intake") ?>/{{slug}}" class="dropdown-item" target="_blank" title="Formulario de Admisión">
                        <i class="fa-duotone fa-arrow-up-right-from-square me-2"></i>
                        <span>Intake</span>
                    </a>
                </li>
            {{/if}}
            <li>
                <a href="{{baseUrl}}clientes/{{id_cliente}}" class="dropdown-item">
                    <i class="fa-duotone fa-eye me-1"></i>
                    <span>Ver</span>
                </a>
            </li>
            <li>
                <a href="#modalEstatus" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEstatus" data-id="{{id_cliente}}">
                    <i class="fa-solid fa-gears me-1"></i>
                    <span>Estatus</span>
                </a>
            </li>
        </ul>
    </div>
</template>

<!-- MODAL CAMBIO ESTATUS -->
<div class="modal fade" id="modalEstatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cambio de estatus</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="containerFormCambioEstatus"></div>
            </div>
        </div>
    </div>
</div>

<template id="tplModalEstatus">
    <form action="" id="frmCambioEstatus-{{id_cliente}}" class="frmCambioEstatus" method="post" autocomplete="off">
        <input type="hidden" name="id_cliente" value="{{id_cliente}}">
        <fieldset>
            <legend><small class="text-muted">{{nombre}}</small></legend>
            <div class="mb-3">
                <label for="cbEstatus" class="form-label">Estatus</label>
                <select name="estatus" id="cbEstatus" class="form-control select2" aria-describedby="ayudaEstatus">
                    <option value="">Selecciona un estatus</option>
                    <?php foreach ($estatus as $estado) : ?>
                        <option value="<?= $estado['id_cliente_estatus'] ?>"><?= $estado['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div id="ayudaEstatus" class="form-text">Estatus actual: {{nombre_estatus}}</div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Cambiar estatus</button>
            </div>
        </fieldset>
    </form>
</template>

<!-- MODAL NUEVO CLIENTE -->
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
                            <label class="form-label">Nombre Completo</label>
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