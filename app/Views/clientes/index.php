<section class="section">
    <div class="section-header">
        <h1 class="section-title">
            <i class="fa-solid fa-user-friends me-2"></i>
            <span>Clientes</span>
        </h1>
        <div>
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">Añadir nuevo</button>
        </div>
    </div>

    <div class="card card-body">
        <form id="filtrosClientes" class="row g-3 mb-3 animate__animated animate__fadeIn">
            <div class="col-md-3 position-relative">
                <label for="filtroPeriodo" class="form-label">Periodo</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="filtroPeriodo" name="periodo" class="form-control" placeholder="Seleccionar periodo">
                </div>
            </div>
            <div class="col-md-3">
                <label for="filtroTipo" class="form-label">Tipo de Consulta</label>
                <select id="filtroTipo" name="tipo" class="form-select select2">
                    <option value="">Seleccionar tipo</option>
                    <option value="presencial">Presencial</option>
                    <option value="online">En Línea</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="filtroSucursal" class="form-label">Sucursal</label>
                <select id="filtroSucursal" name="sucursal" class="form-select select2">
                    <option value="">Seleccionar sucursal</option>
                    <?php foreach ($sucursales as $sucursal) : ?>
                        <option value="<?= esc($sucursal['id']) ?>">
                            <?= esc($sucursal['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="filtroEstatus" class="form-label">Estatus</label>
                <select id="filtroEstatus" name="estatus" class="form-select select2">
                    <option value="">Seleccionar estatus</option>
                    <?php foreach ($estatus as $estado) : ?>
                        <option value="<?= esc($estado['id_cliente_estatus']) ?>">
                            <?= esc($estado['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-azul animate__animated animate__fadeIn">
                    <i class="fa fa-search me-2"></i>Aplicar filtros
                </button>
                <button type="button" id="resetFiltros" class="btn btn-secondary ms-2 animate__animated animate__fadeIn">
                    <i class="fa fa-redo me-2"></i>Limpiar
                </button>
            </div>
        </form>


        <div class="section-table">
            <div class="table-responsive">
                <table id="tablaClientes" class="table table-striped table-sm table-linklaw">
                    <thead>
                        <tr>
                            <th data-field="id_cliente">ID</th>
                            <th data-field="nombre" data-formatter="formatoNombre" data-sortable="true">Nombre</th>
                            <th data-field="tipo_consulta">Tipo</th>
                            <th data-field="nombre_sucursal">Sucursal</th>
                            <th data-field="telefono" data-sortable="true">Teléfono</th>
                            <th data-field="nombre_estatus" data-formatter="columnaEstatus" data-align="center">Estatus</th>
                            <th data-field="nombre_usuario_asignado">Asignado</th>
                            <th data-field="fecha_ultima_actualizacion">Última Actualización</th>
                            <th data-field="fecha_creado" data-sortable="true" data-visible="false">Creado</th>
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
            {{#if puedeAsignar}}
                <li>
                    <a href="#modalAsignarAbogado" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalAsignarAbogado" data-id="{{id_cliente}}" title="Asignar a un abogado">
                        <i class="fa-duotone fa-user-tie me-1"></i>
                        <span>Asignar</span>
                    </a>
                </li>
            {{/if}}
        </ul>
    </div>
</template>

<!-- Modal Asignar Abogado -->
<div class="modal fade" id="modalAsignarAbogado" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Asignar Abogado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="frmAsignarAbogado" action="#" method="post" class="row g-3">
                        <input type="hidden" name="id_cliente" id="idClienteAsignarAbogado">
                        <div class="col-md-12">
                            <label for="abogados" class="form-label">Abogado a asignar:</label>
                            <div class="d-flex flex-column-reverse">
                                <select name="id_abogado" id="abogados" class="select2 form-select" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <optgroup label="Abogados">
                                        <?php foreach ($abogados as $abogado) : ?>
                                            <option value="<?= esc($abogado['usuario_id']) ?>">
                                                <?= esc($abogado['usuario_nombre'] . " " . $abogado['usuario_apellido_paterno']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <optgroup label="Paralegal">
                                        <?php foreach ($paralegales as $paralegal) : ?>
                                            <option value="<?= esc($paralegal['id']) ?>">
                                                <?= esc($paralegal['nombre'] . " " . $paralegal['apellido_paterno']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button id="btnAsignarAbogado" type="button" class="btn btn-primary">Asignar</button>
            </div>
        </div>
    </div>
</div>

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
        <input type="hidden" name="tipo_consulta" value="{{tipo_consulta}}">
        <fieldset>
            <legend><small class="text-muted">{{nombre}}</small></legend>
            <div class="mb-3">
                <label for="cbEstatus" class="form-label">Estatus</label>
                <select name="estatus" id="cbEstatus" class="form-control select2" aria-describedby="ayudaEstatus">
                    <option value="">Selecciona un estatus</option>
                    <?php foreach ($estatus as $estado) : ?>
                        <option value="<?= esc($estado['id_cliente_estatus']) ?>">
                            <?= esc($estado['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div id="ayudaEstatus" class="form-text">Estatus actual: {{nombre_estatus}}</div>
            </div>
            <div id="descripcionEstatus" class="mb-3">
                <!-- Aquí se cargará la descripción dinámica del estatus -->
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
                        <div class="col-md-4">
                            <label for="nuevo_tipo_consulta" class="form-label">Tipo de Consulta</label>
                            <div class="d-flex flex-column-reverse">
                                <select name="tipo_consulta" id="nuevo_tipo_consulta" class="select2 form-select" required>
                                    <option value="">Seleccionar Tipo de Consulta</option>
                                    <option value="presencial" selected>Presencial</option>
                                    <option value="online">En Línea</option>
                                </select>
                            </div>
                        </div>
                        <div id="containerURLGoogleMeet" class="col-md-4 hide">
                            <label for="" class="form-label">URL de Google Meet</label>
                            <input type="text" name="meet_url" class="form-control">
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
        <div class="mb-3">Esta es la URL del formulario de admisión <a href="<?= base_url("/") ?>intake/{{this}}" id="linkSlug" target="_blank"><?= base_url("/") ?>intake/{{this}} <i class="fa-duotone fa-arrow-up-right-from-square"></i></a></div>
        <div>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="btnCopiarSlug">
                <i class="fa-duotone fa-copy"></i>
                <span>¡Copiar!</span>
            </button>
        </div>
    </div>
</template>

<!-- FORMULARIO NUEVO CASO -->
<template id="tplNuevoCaso">
    {{#if puedeCrearCaso}}
        <div class="card card-body p-4">
            <h3>Nuevo Caso</h3>
            <div class="row">
                <div class="col-md-8">
                    <form id="frmNuevoCaso-{{id_cliente}}" class="frmNuevoCaso" action="/" method="post" autocomplete="none">
                        <input type="hidden" name="id_cliente" value="{{id_cliente}}">
                        <input type="hidden" name="id_usuario" value="<?= $usuario['id'] ?>">
                        <input type="hidden" name="clientID" value="{{clientID}}">
                        <input type="hidden" name="sucursal" value="{{sucursal}}">

                        <div class="mb-3">
                            <label for="textarea-{{id_cliente}}" class="form-label">
                                <span>Antecedente</span>
                                <b class="text-danger ms-1">*</b>
                            </label>
                            <textarea name="comentarios" class="form-control" id="textarea-{{id_cliente}}" cols="30" rows="10" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="cbTiposCaso-{{id_cliente}}" class="form-label">
                                <span>Proceso principal del caso</span>
                                <b class="text-danger ms-1">*</b>
                            </label>
                            <div class="d-flex flex-column-reverse">
                                <select name="id_tipo_caso" id="cbTiposCaso-{{id_cliente}}" class="cbTiposCaso form-control select2" data-target="#costo-{{id_cliente}}" required>
                                    {{#each ProcesosCasos}}
                                        <option value="{{processID}}" data-costo="0">{{name}}</option>
                                    {{/each}}
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cbTiposCasoAdicionales-{{id_cliente}}" class="form-label">Procesos adicionales</label>
                            <div class="d-flex flex-column-reverse">
                                <select name="procesos_adicionales" id="cbTiposCasoAdicionales-{{id_cliente}}" class="cbTiposCaso form-control select2" data-target="#costo-{{id_cliente}}" multiple>
                                    {{#each ProcesosCasos}}
                                        <option value="{{processID}}" data-costo="0">{{name}}</option>
                                    {{/each}}
                                </select>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label for="costo-{{id_cliente}}" class="form-label">Costo</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    <input type="text" class="form-control" name="costo" id="costo-{{id_cliente}}" value="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_corte-{{id_cliente}}" class="form-label">Fecha de corte</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa-duotone fa-calendar-lines-pen"></i>
                                    </span>
                                    <input type="text" name="fecha_corte" id="fecha_corte-{{id_cliente}}" class="flatpickr form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button class="btnNuevoCaso btn btn-success" data-tipo="4" data-target="#frmNuevoCaso-{{id_cliente}}">
                                <i class="fa-solid fa-check-to-slot me-1"></i>
                                <span>Elegible</span>
                            </button>
                            <button class="btnNuevoCaso btn btn-danger" data-tipo="5" data-target="#frmNuevoCaso-{{id_cliente}}">
                                <i class="fa-sharp fa-light fa-xmark-to-slot me-1"></i>
                                <span>No Elegible</span>
                            </button>
                        </div>
                    </form>
                </div>
                {{#if consultaOnline}}
                    <div class="col-md-4">
                        <div class="card consulta-online-card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Consulta en línea</h5>
                                <p class="card-text"><strong>Meet URL:</strong></p>
                                <p class="card-text text-break"><a href="{{meet_url}}" target="_blank">{{meet_url}}</a></p>
                                <div class="text-center">
                                    <img src="<?= base_url('img/google-meet.png') ?>" alt="google meet" class="img-fluid google-meet-img">
                                </div>
                            </div>
                        </div>
                    </div>
                {{/if}}
            </div>
        </div>
    {{else}}
        <div class="alert alert-warning" role="alert">
            No se pueden crear casos para este cliente porque su estatus actual no lo permite. Solo los clientes en estatus "Intake", "Asignado" o "Por Asignar" pueden tener casos creados.
        </div>
    {{/if}}
</template>