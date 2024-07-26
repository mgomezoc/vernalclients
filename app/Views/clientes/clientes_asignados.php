<section class="section">
    <div class="section-header">
        <h1 class="section-title">
            <i class="fa-solid fa-people-simple"></i>
            <span>Clientes Asignados</span>
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
                            <th data-field="nombre_estatus" data-formatter="columnaEstatus">Estatus</th>
                            <th data-field="fecha_ultima_actualizacion">Última Actualización</th>
                            <th data-field="fecha_creado" data-sortable="true">Creado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente) : ?>
                            <tr>
                                <td><?= $cliente['id_cliente'] ?></td>
                                <td><?= esc($cliente['nombre']) ?></td>
                                <td><?= esc($cliente['nombre_sucursal']) ?></td>
                                <td><?= esc($cliente['tipo_consulta']) ?></td>
                                <td><?= esc($cliente['telefono']) ?></td>
                                <td><?= esc($cliente['nombre_estatus']) ?></td>
                                <td><?= esc($cliente['fecha_ultima_actualizacion']) ?></td>
                                <td><?= esc($cliente['fecha_creado']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>