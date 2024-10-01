<section class="section">
    <div class="section-header">
        <h1 class="section-title">
            <i class="fa-duotone fa-clipboard-list-check"></i>
            <span>Auditoría</span>
        </h1>
    </div>

    <div class="card card-body">
        <!-- Filtros -->
        <form id="filtrosAuditoria" class="row g-3 mb-3 animate__animated animate__fadeIn">
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
            <div class="col-md-3">
                <label for="filtroAccion" class="form-label">Acción</label>
                <input type="text" id="filtroAccion" name="accion" class="form-control" placeholder="Buscar acción">
            </div>
            <div class="col-md-3 position-relative">
                <label for="filtroPeriodo" class="form-label">Periodo</label>
                <input type="text" id="filtroPeriodo" name="periodo" class="form-control" placeholder="Seleccionar periodo">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search me-2"></i>Aplicar filtros
                </button>
                <button type="button" id="resetFiltrosAuditoria" class="btn btn-secondary ms-2">
                    <i class="fa fa-redo me-2"></i>Limpiar
                </button>
            </div>
        </form>

        <!-- Tabla de Auditoría -->
        <div class="section-table">
            <div class="table-responsive">
                <table id="tablaAuditoria" class="table table-striped table-sm table-linklaw">
                    <thead>
                        <tr>
                            <th data-field="id">ID</th>
                            <th data-field="usuario">Usuario</th>
                            <th data-field="accion">Acción</th>
                            <th data-field="detalle">Detalle</th>
                            <th data-field="fecha" data-formatter="formatoAmericano">Fecha</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>