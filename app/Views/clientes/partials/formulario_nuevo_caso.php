<form id="formCrearCaso" class="p-4">
    <!-- Identificadores Ocultos -->
    <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">
    <input type="hidden" name="id_usuario" value="<?= $usuario['id'] ?>">

    <!-- Proceso Principal -->
    <div class="mb-3">
        <label for="cbProcesosEInmigration" class="form-label fw-bold">Proceso Principal</label>
        <select name="id_tipo_caso" id="cbProcesosEInmigration" class="form-control" required aria-required="true">
            <option value="" selected disabled>Seleccione un proceso</option>
        </select>
    </div>

    <!-- Procesos Adicionales -->
    <div class="mb-3">
        <label for="cbProcesosAdicionalesEInmigration" class="form-label fw-bold">Procesos Adicionales</label>
        <select name="procesos_adicionales[]" id="cbProcesosAdicionalesEInmigration" class="form-control select2" multiple>
        </select>
        <small class="form-text text-muted">Seleccione uno o más procesos adicionales.</small>
    </div>

    <!-- Antecedente -->
    <div class="mb-3">
        <label for="comentarios" class="form-label fw-bold">Antecedente</label>
        <textarea name="comentarios" id="comentarios" class="form-control tinymce-editor" rows="5" required aria-required="true" aria-label="Antecedente"></textarea>
    </div>

    <!-- Sección de Costo y Fechas Importantes -->
    <fieldset class="mb-4">
        <legend class="fw-bold">Datos Importantes</legend>
        <div class="row">
            <!-- Costo -->
            <div class="col-md-6 mb-3">
                <label for="costo" class="form-label fw-bold">Costo</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-solid fa-dollar-sign text-success"></i>
                    </span>
                    <input type="number" name="costo" id="costo" class="form-control" step="0.01" required aria-required="true" aria-label="Costo">
                </div>
                <small class="form-text text-muted">Indique el costo total del caso en dólares.</small>
            </div>

            <!-- Fecha de Corte -->
            <div class="col-md-6 mb-3">
                <label for="fecha_corte" class="form-label fw-bold">Fecha de Corte</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-regular fa-calendar-alt text-primary"></i>
                    </span>
                    <input type="text" name="fecha_corte" id="fecha_corte" class="form-control flatpickr" required aria-required="true" aria-label="Fecha de Corte">
                </div>
            </div>

            <!-- Fecha Límite -->
            <div class="col-md-6 mb-3">
                <label for="limite_tiempo" class="form-label fw-bold">Fecha Límite</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-regular fa-calendar-alt text-primary"></i>
                    </span>
                    <input type="text" name="limite_tiempo" id="limite_tiempo" class="form-control flatpickr" required aria-required="true" aria-label="Fecha Límite">
                </div>
            </div>
        </div>
    </fieldset>

    <!-- Estatus del Caso -->
    <div class="mb-4">
        <label class="form-label fw-bold d-block">Estatus del Caso</label>
        <div class="btn-group" role="group" aria-label="Estatus del Caso">
            <input type="radio" class="btn-check" name="estatus" id="estatusElegible" value="4" required aria-required="true">
            <label class="btn btn-outline-success" for="estatusElegible">
                <i class="fa-solid fa-check"></i> Elegible
            </label>

            <input type="radio" class="btn-check" name="estatus" id="estatusNoElegible" value="5" required aria-required="true">
            <label class="btn btn-outline-danger" for="estatusNoElegible">
                <i class="fa-solid fa-times"></i> No Elegible
            </label>

            <input type="radio" class="btn-check" name="estatus" id="estatusEnEspera" value="9" checked required aria-required="true">
            <label class="btn btn-outline-warning" for="estatusEnEspera">
                <i class="fa-solid fa-clock"></i> En espera
            </label>
        </div>
    </div>

    <!-- Botón de Enviar -->
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success">
            <i class="fa-solid fa-check me-1"></i> Crear Caso
        </button>
    </div>
</form>