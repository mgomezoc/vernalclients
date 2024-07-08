<section class="section">
    <div class="section-header">
        <h1 class="section-title">
            <i class="fa-solid fa-people-simple"></i>
            <span>Clientes</span>
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
                            <th data-field="telefono" data-sortable="true">Teléfono</th>
                            <th data-field="nombre_estatus">Estatus</th>
                            <th data-field="fecha_ultima_actualizacion">Última Actualización</th>
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
    {{#if esIntake}}
        <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalAsignarAbogado" data-id="{{id_cliente}}" title="Asignar a un abogado">
            <i class="fa-duotone fa-user-tie"></i>
            <span>Asignar</span>
        </button>
    {{/if}}

    {{#if esViable}}
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCobrar" data-id="{{id_cliente}}" title="Cobrar">
            <i class="fa-solid fa-cash-register ms-1"></i>
            <span>Cobrar</span>
        </button>
    {{/if}}
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

<!-- Modal Cobrar -->
<div id="modalCobrar" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cobrar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<template id="tplCobroCliente">
    <div class="p-4">
        {{#each casos}}
            <div class="card card-body mb-5">
                <div class="mb-3">
                    <h5>Caso #{{id_caso}}</h5>
                </div>
                <div class="mb-3">
                    <b>Comentarios:</b>
                    <div>{{comentarios}}</div>
                </div>
                <div class="mb-5">
                    <b>Costo:</b>
                    <div>{{costo}}</div>
                </div>
                <div class="text-center">
                    <a href="https://www.eimmigration.com/VFMLaw/Cases/{{caseID}}/#!/Expenses" class="btn btn-secondary" target="_blank">
                        <span>Pagar</span>
                        <img src="https://www.eimmigration.com/Images/ApplicationLogo.png" alt="eimmigration" width="126px">
                    </a>
                </div>
            </div>
        {{/each}}
    </div>
</template>

<script>
    const abogados = <?= json_encode($abogados) ?>;
</script>