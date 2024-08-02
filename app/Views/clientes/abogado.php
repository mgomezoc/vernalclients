<section class="section">
    <div class="section-header">
        <h1 class="section-title">
            <i class="fa-solid fa-briefcase me-2"></i>
            <span>Prospectos</span>
        </h1>
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
                            <th data-field="tipo_consulta">Tipo</th>
                            <th data-field="telefono" data-sortable="true">Teléfono</th>
                            <th data-field="nombre_estatus" data-formatter="columnaEstatus" data-align="center">Estatus</th>
                            <th data-field="fecha_ultima_actualizacion">Última Actualización</th>
                            <th data-field="fecha_creado" data-sortable="true">Creado</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- ACCIONES TABLA -->
<template id="tplAccionesTabla">
    <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalAsignarAbogado" data-id="{{id_cliente}}" title="Asignar a un abogado">
        <i class="fa-duotone fa-user-tie"></i>
        <span>Asignar</span>
    </button>
</template>

<!-- MODAL ASIGNAR ABOGADO -->
<div class="modal fade" id="modalAsignarAbogado" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Asignar Abogado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="frmAsignarAbogado" action="#" method="post" class="row g-5">
                        <input type="hidden" name="id_cliente" id="idClienteAsignarAbogado">
                        <div class="col-md-12">
                            <label for="abogados" class="form-label">Abogado a Asignar:</label>
                            <div class="d-flex flex-column-reverse">
                                <select name="id_abogado" id="abogados" class="select2 form-select" required>
                                    <option value="">Seleccionar Abogado</option>
                                    <?php foreach ($abogados as $abogado) : ?>
                                        <option value="<?= esc($abogado['usuario_id']) ?>">
                                            <?= esc($abogado['usuario_nombre'] . " " . $abogado['usuario_apellido_paterno']) ?>
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
                <button id="btnAsignarAbogado" type="button" class="btn btn-primary">Asignar</button>
            </div>
        </div>
    </div>
</div>

<!-- FORMULARIO NUEVO CASO -->
<template id="tplNuevoCaso">
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
                            <span>Proceso Principal del Caso</span>
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
                        <label for="cbTiposCasoAdicionales-{{id_cliente}}" class="form-label">Procesos Adicionales</label>
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
                            <label for="fecha_corte-{{id_cliente}}" class="form-label">Fecha de Corte</label>
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
                            <h5 class="card-title">Consulta en Línea</h5>
                            <p class="card-text"><strong>Meet URL:</strong></p>
                            <p class="card-text text-break"><a href="{{meet_url}}" target="_blank">{{meet_url}}</a></p>
                            <div class="text-center">
                                <img src="<?= base_url('img/google-meet.png') ?>" alt="Google Meet" class="img-fluid google-meet-img">
                            </div>
                        </div>
                    </div>
                </div>
            {{/if}}
        </div>
    </div>
</template>

<script>
    const abogados = <?= json_encode($abogados) ?>;
    const tiposCasos = <?= json_encode($tiposCasos) ?>;
</script>