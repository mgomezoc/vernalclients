<div class="card card-body">
    <form id="frmEditarCliente" action="#" method="post" class="row g-3">
        <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">

        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $cliente['nombre'] ?>" required>
        </div>
        <div class="col-md-6">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="<?= $cliente['telefono'] ?>" required>
        </div>
        <div class="col-md-6">
            <label for="sucursal" class="form-label">Sucursal</label>
            <select name="sucursal" id="sucursal" class="form-select select2" required>
                <?php foreach ($sucursales as $sucursal) : ?>
                    <option value="<?= $sucursal['id'] ?>" <?= $sucursal['id'] == $cliente['sucursal'] ? 'selected' : '' ?>><?= $sucursal['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="tipo_consulta" class="form-label">Tipo de Consulta</label>
            <input type="text" name="tipo_consulta" id="tipo_consulta" value="<?= $cliente['tipo_consulta'] ?>" class="form-control" readonly>
        </div>
        <?php if ($cliente['tipo_consulta'] == 'online') : ?>
            <div class="col-md-12">
                <label for="meet_url" class="form-label">Meet URL</label>
                <input type="text" name="meet_url" id="meet_url" class="form-control" value="<?= $cliente['meet_url'] ?>">
            </div>
        <?php endif; ?>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>