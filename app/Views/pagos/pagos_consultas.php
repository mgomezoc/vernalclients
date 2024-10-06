<section class="section">
    <div class="section-header">
        <h1 class="section-title">
            <i class="fa-duotone fa-money-check-alt"></i>
            <span>Pagos de Consultas</span>
        </h1>
    </div>

    <div class="card card-body">
        <!-- Filtros -->
        <form id="filtrosPagosConsultas" class="row g-3 mb-3 animate__animated animate__fadeIn">
            <div class="col-md-3">
                <label for="filtroCliente" class="form-label">Cliente</label>
                <select id="filtroCliente" name="cliente" class="form-select select2">
                    <option value="">Todos los clientes</option>
                    <?php foreach ($clientes as $cliente) : ?>
                        <option value="<?= esc($cliente['id_cliente']) ?>">
                            <?= esc($cliente['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="filtroUsuario" class="form-label">Usuario</label>
                <select id="filtroUsuario" name="usuario" class="form-select select2">
                    <option value="">Todos los usuarios</option>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <option value="<?= esc($usuario['id']) ?>">
                            <?= esc($usuario['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 position-relative">
                <label for="filtroPeriodo" class="form-label">Periodo</label>
                <input type="text" id="filtroPeriodo" name="periodo" class="form-control" placeholder="Seleccionar periodo">
            </div>
            <div class="col-md-3">
                <label for="filtroFormaPago" class="form-label">Forma de Pago</label>
                <select id="filtroFormaPago" name="forma_pago" class="form-select select2">
                    <option value="">Todas las formas de pago</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="filtroEstatusPago" class="form-label">Estatus de Pago</label>
                <select id="filtroEstatusPago" name="estatus_pago" class="form-select select2">
                    <option value="">Todos los estatus</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="completado">Completado</option>
                    <option value="fallido">Fallido</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search me-2"></i>Aplicar filtros
                </button>
                <button type="button" id="resetFiltrosPagosConsultas" class="btn btn-secondary ms-2">
                    <i class="fa fa-redo me-2"></i>Limpiar
                </button>
            </div>
        </form>

        <!-- Tabla de Pagos -->
        <div class="section-table">
            <div class="table-responsive">
                <table id="tablaPagosConsultas" class="table table-striped table-sm table-linklaw">
                    <thead>
                        <tr>
                            <th data-field="id_pago">ID</th>
                            <th data-field="nombre_cliente">Cliente</th>
                            <th data-field="nombre_usuario" data-visible="false">Usuario</th>
                            <th data-field="monto">Monto</th>
                            <th data-field="forma_pago">Forma de Pago</th>
                            <th data-field="estatus_pago">Estatus</th>
                            <th data-field="fecha_pago" data-formatter="formatoAmericano">Fecha de Pago</th>
                            <th data-field="referencia">Referencia</th>
                            <th data-field="notas">Notas</th>
                            <th data-field="id_pago" data-formatter="accionesTablaPagos">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<template id="tplAccionesTabla">
    {{#ifCond estatus_pago '!=' 'completado'}}
        <button class="btn btn-sm btn-secondary btn-marcar-pagado" data-id="{{id_pago}}" title="Marcar como pagado">
            <i class="fa-solid fa-dollar-sign"></i> Marcar Pagado
        </button>
    {{/ifCond}}
</template>



<!-- Modal para Marcar como Pagado -->
<div class="modal fade" id="modalMarcarPagado" tabindex="-1" aria-labelledby="modalMarcarPagadoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frmMarcarPagado">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMarcarPagadoLabel">Marcar como Pagado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_pago" id="id_pago">

                    <div class="mb-3">
                        <label for="forma_pago" class="form-label">Forma de Pago</label>
                        <select name="forma_pago" id="forma_pago" class="form-select select2">
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nota" class="form-label">Nota</label>
                        <textarea name="nota" id="nota" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>