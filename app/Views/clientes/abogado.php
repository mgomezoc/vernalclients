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
                            <th data-field="fecha_ultima_actualizacion">Ultima Actualización</th>
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

<!-- Modal -->
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
                            <label for="abogados" class="form-label">Abogado a asignar:</label>
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

<template id="tplNuevoCaso">
    <div class="card card-body">
        <h3>Nuevo Caso</h3>
        <div class="row">
            <div class="col-md-8">
                <form id="frmNuevoCaso" action="/" method="post" autocomplete="none">
                    <div class="mb-3">
                        <label class="form-label">Comentarios</label>
                        <textarea name="comentarios" class="form-control" cols="30" rows="10" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Costo</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">$</span>
                            <input type="text" class="form-control" name="costo" required>
                        </div>

                    </div>
                    <div>
                        <button type="button" class="btnNuevoCaso btn btn-success" data-tipo="1">
                            <i class="fa-solid fa-check-to-slot me-1"></i>
                            <span>Aplica</span>
                        </button>
                        <button type="button" class="btnNuevoCaso btn btn-danger" data-tipo="2">
                            <i class="fa-sharp fa-light fa-xmark-to-slot me-1"></i>
                            <span>No Aplica</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    const abogados = <?= json_encode($abogados) ?>;
</script>