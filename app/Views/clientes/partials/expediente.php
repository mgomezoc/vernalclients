<!-- clientes/partials/expediente.php -->

<div class="card card-body">
    <h5 class="section-title">
        <i class="fa-solid fa-folder me-1"></i>
        <span>Expediente de <?= $cliente['nombre'] ?></span>
    </h5>

    <?php if (!empty($expedientes)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre del Documento</th>
                    <th>Tipo</th>
                    <th>Tamaño</th>
                    <th>Fecha de Subida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expedientes as $expediente): ?>
                    <tr>
                        <td><?= $expediente['nombre_documento'] ?></td>
                        <td><?= $expediente['tipo_documento'] ?></td>
                        <td><?= number_format($expediente['tamano_documento'] / 1024, 2) ?> KB</td>
                        <td><?= date('d-m-Y H:i:s', strtotime($expediente['fecha_subida'])) ?></td>
                        <td>
                            <a href="<?= base_url('uploads/casos/' . $expediente['path_documento']) ?>" class="btn btn-sm btn-primary" target="_blank">
                                <i class="fa-solid fa-download me-1"></i>
                                Descargar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">
            No hay documentos en el expediente.
        </div>
    <?php endif; ?>
</div>