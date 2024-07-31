<section class="section">
    <div class="section-header">
        <h1 class="section-title">
            <i class="fa-solid fa-people-simple"></i>
            <span>Clientes Asignados</span>
        </h1>
    </div>

    <div class="card card-body">
        <!-- Filtros -->
        <form id="filtrosClientesAsignados" class="row g-3 mb-3 animate__animated animate__fadeIn">
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
                    <option value="online">Online</option>
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
                <button type="button" id="resetFiltrosAsignados" class="btn btn-secondary ms-2 animate__animated animate__fadeIn">
                    <i class="fa fa-redo me-2"></i>Limpiar
                </button>
            </div>
        </form>

        <!-- Tabla de Clientes Asignados -->
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
                            <th data-field="nombre_estatus" data-formatter="columnaEstatus">Estatus</th>
                            <th data-field="fecha_ultima_actualizacion">Última Actualización</th>
                            <th data-field="fecha_creado" data-sortable="true">Creado</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>