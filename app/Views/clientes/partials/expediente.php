<!-- clientes/partials/expediente.php -->

<div class="card card-body">
    <h5 class="section-title">
        <i class="fa-solid fa-folder me-1"></i>
        <span>Expediente de <?= $cliente['nombre'] ?></span>
    </h5>

    <!-- Formulario para subir archivos -->
    <form id="formSubirArchivo" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="archivoExpediente" class="form-label">Subir nuevo archivo</label>
            <input type="file" class="form-control" id="archivoExpediente" name="archivo" required>
            <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-upload me-1"></i> Subir Archivo
        </button>
    </form>


    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre del Documento</th>
                <th>Tipo</th>
                <th>Tamaño</th>
                <th>Fecha de Subida</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tablaExpediente">
            <?php foreach ($expedientes as $expediente): ?>
                <tr>
                    <td><?= $expediente['nombre_documento'] ?></td>
                    <td><?= $expediente['tipo_documento'] ?></td>
                    <td><?= number_format($expediente['tamano_documento'] / 1024, 2) ?> KB</td>
                    <td><?= date('m/d/Y H:i:s', strtotime($expediente['fecha_subida'])) ?></td>
                    <td>
                        <a href="<?= base_url('uploads/' . $expediente['path_documento']) ?>" class="btn btn-sm btn-primary" target="_blank">
                            <i class="fa-solid fa-download me-1"></i> Descargar
                        </a>
                        <button class="btn btn-sm btn-danger btnEliminarArchivo" data-id="<?= $expediente['id'] ?>">
                            <i class="fa-solid fa-trash me-1"></i> Eliminar
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>