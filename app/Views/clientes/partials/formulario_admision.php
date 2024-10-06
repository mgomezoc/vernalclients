<div class="card card-body">
    <div class="p-2">
        <div class="text-end">
            <!-- Botón Imprimir -->
            <a href="<?= site_url('clientes/imprimir/' . $cliente['id_cliente']) ?>" class="btn btn-secondary">
                <i class="fa-solid fa-print me-1"></i>
                Imprimir
            </a>

            <!-- Botón Editar -->
            <button id="btnEditar" class="btn btn-secondary">
                <i class="fa-solid fa-edit me-1"></i>
                Editar
            </button>

            <!-- Botón Guardar (Solo visible en modo edición) -->
            <button id="btnGuardar" class="btn btn-primary d-none">
                <i class="fa-solid fa-save me-1"></i>
                Guardar
            </button>
        </div>

        <hr>

        <?php if (!empty($formulario)): ?>
            <!-- Información del formulario -->
            <form id="formularioAdmision" method="post" class="needs-validation" novalidate>

                <!-- INFORMACIÓN GENERAL -->
                <h5 class="mb-3">INFORMACIÓN GENERAL:</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="fecha_consulta">Fecha de consulta:</label>
                        <input type="text" name="fecha_consulta" class="form-control"
                            value="<?= date('m-d-Y', strtotime($formulario['fecha_consulta'])) ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="sucursal">Sucursal:</label>
                        <input type="text" name="sucursal" class="form-control"
                            value="<?= $formulario['sucursal_nombre'] ?>" readonly>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label>¿Es su primera consulta aquí?</label>
                        <input type="text" name="es_primera_consulta" class="form-control" value="<?= ($formulario['proceso'] == 'Usted') ? 'Sí' : 'No' ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>¿Cómo se enteró de nuestro servicio?</label>
                        <div>
                            <?php
                            $fuentes = explode('|', $formulario['fuente_informacion']);
                            $opciones = ['Amigos', 'Familia', 'Fue Cliente', 'Walk-In', 'Facebook', 'Tarjeta', 'Internet', 'Instagram', 'Youtube', 'Tiktok', 'Google', 'Otro'];
                            foreach ($opciones as $opcion): ?>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="fuente_informacion[]" value="<?= $opcion ?>" <?= in_array($opcion, $fuentes) ? 'checked' : '' ?> disabled>
                                    <label class="form-check-label"><?= $opcion ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="motivo_visita">Especifique el motivo de su visita:</label>
                    <textarea name="motivo_visita" class="form-control" rows="3" readonly><?= $formulario['motivo_visita'] ?></textarea>
                </div>

                <!-- INFORMACIÓN DEL BENEFICIARIO -->
                <h5 class="mb-3">INFORMACIÓN DEL BENEFICIARIO(A):</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="beneficiario_nombre">Nombre completo:</label>
                        <input type="text" name="beneficiario_nombre" class="form-control" value="<?= $formulario['beneficiario_nombre'] ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="beneficiario_genero">Género:</label>
                        <input type="text" name="beneficiario_genero" class="form-control" value="<?= $formulario['beneficiario_genero'] ?>" readonly>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="beneficiario_fecha_nacimiento">Fecha de nacimiento:</label>
                        <input type="text" name="beneficiario_fecha_nacimiento" class="form-control" value="<?= date('m-d-Y', strtotime($formulario['beneficiario_fecha_nacimiento'])) ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="ciudad_pais_nacimiento">Ciudad y país de nacimiento:</label>
                        <input type="text" name="ciudad_pais_nacimiento" class="form-control" value="<?= $formulario['direccion_ciudad'] . ', ' . $formulario['direccion_pais'] ?>" readonly>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="beneficiario_estado_civil">Estado Civil:</label>
                        <input type="text" name="beneficiario_estado_civil" class="form-control" value="<?= $formulario['beneficiario_estado_civil'] ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="direccion_calle_numero">Calle y número:</label>
                        <input type="text" name="direccion_calle_numero" class="form-control" value="<?= $formulario['direccion_calle_numero'] ?>" readonly>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="direccion_cp">Código postal:</label>
                        <input type="text" name="direccion_cp" class="form-control" value="<?= $formulario['direccion_cp'] ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="direccion_telefono">Teléfono:</label>
                        <input type="text" name="direccion_telefono" class="form-control" value="<?= $formulario['direccion_telefono'] ?>" readonly>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="direccion_email">Correo electrónico:</label>
                        <input type="email" name="direccion_email" class="form-control" value="<?= $formulario['direccion_email'] ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="contacto">Mejor opción para contactarlo:</label>
                        <input type="text" name="contacto" class="form-control" value="<?= $formulario['contacto'] ?>" readonly>
                    </div>
                </div>

                <!-- PREGUNTAS DE INMIGRACIÓN -->
                <h5 class="mb-3">PREGUNTAS DE INMIGRACIÓN PARA EL (LA) BENEFICIARIO(A):</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="como_entro_eeuu">¿Cómo entró a EE.UU.?</label>
                        <input type="text" name="como_entro_eeuu" class="form-control" value="<?= $formulario['como_entro_eeuu'] ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="tipo_visa">Tipo de visa (si aplica):</label>
                        <input type="text" name="tipo_visa" class="form-control" value="<?= $formulario['tipo_visa'] ?>" readonly>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="estatus_migratorio_actual">Estatus migratorio actual:</label>
                        <input type="text" name="estatus_migratorio_actual" class="form-control" value="<?= $formulario['estatus_migratorio_actual'] ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha_ultima_entrada">Fecha de última entrada a los Estados Unidos:</label>
                        <input type="text" name="fecha_ultima_entrada" class="form-control" value="<?= date('m-d-Y', strtotime($formulario['fecha_ultima_entrada'])) ?>" readonly>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="solicitud_migratoria">¿Alguna vez han sometido una solicitud migratoria en beneficio suyo?</label>
                        <input type="text" name="solicitud_migratoria" class="form-control" value="<?= ($formulario['solicitud_migratoria'] == 'Si') ? 'Sí' : 'No' ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="solicitud_migratoria_explicacion">Si es así, explique quién, cuándo, y los resultados:</label>
                        <textarea name="solicitud_migratoria_explicacion" class="form-control" rows="3" readonly><?= $formulario['solicitud_migratoria_explicacion'] ?></textarea>
                    </div>
                </div>

                <!-- Campos adicionales que faltaban -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="proceso_migracion">¿Está actualmente en un proceso de inmigración?</label>
                        <input type="text" name="proceso_migracion" class="form-control" value="<?= ($formulario['proceso_migracion'] == 'Si') ? 'Sí' : 'No' ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="proceso_migracion_explicacion">Si es así, explique:</label>
                        <textarea name="proceso_migracion_explicacion" class="form-control" rows="3" readonly><?= $formulario['proceso_migracion_explicacion'] ?></textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="parientes">Parientes en EE.UU.:</label>
                        <input type="text" name="parientes" class="form-control" value="<?= $formulario['parientes'] ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="familiar_servicio">¿Tiene algún familiar en el servicio militar?</label>
                        <input type="text" name="familiar_servicio" class="form-control" value="<?= ($formulario['familiar_servicio'] == 'Si') ? 'Sí' : 'No' ?>" readonly>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="familiar_servicio_parentesco">Parentesco con el familiar en el servicio militar:</label>
                        <input type="text" name="familiar_servicio_parentesco" class="form-control" value="<?= $formulario['familiar_servicio_parentesco'] ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="victima_crimen">¿Ha sido alguna vez víctima de un crimen?</label>
                        <input type="text" name="victima_crimen" class="form-control" value="<?= ($formulario['victima_crimen'] == 'Si') ? 'Sí' : 'No' ?>" readonly>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="victima_crimen_info">Lugar, fecha, y tipo de delito:</label>
                    <textarea name="victima_crimen_info" class="form-control" rows="3" readonly><?= $formulario['victima_crimen_info'] ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="cometido_crimen">En el contexto de migración, ¿ha cometido algún crimen en EE.UU.?</label>
                    <input type="text" name="cometido_crimen" class="form-control" value="<?= $formulario['cometido_crimen'] ?>" readonly>
                </div>

                <!-- INFORMACIÓN DE ARRESTOS -->
                <h5 class="mb-3">INFORMACIÓN DE ARRESTOS:</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="arrestado">¿Alguna vez ha sido arrestado por CUALQUIER crimen?</label>
                        <input type="text" name="arrestado" class="form-control" value="<?= ($formulario['arrestado'] == 'Si') ? 'Sí' : 'No' ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="arrestado_fecha_cargo">Fecha y Cargo:</label>
                        <textarea name="arrestado_fecha_cargo" class="form-control" rows="3" readonly><?= $formulario['arrestado_fecha_cargo'] ?></textarea>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="arrestado_explicacion">Si es más de un arresto, por favor explique:</label>
                    <textarea name="arrestado_explicacion" class="form-control" rows="3" readonly><?= $formulario['arrestado_explicacion'] ?></textarea>
                </div>

                <!-- INFORMACIÓN DEL PETICIONARIO -->
                <h5 class="mb-3">INFORMACIÓN DEL PETICIONARIO:</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="peticionario_nombre">Nombre completo:</label>
                        <input type="text" name="peticionario_nombre" class="form-control" value="<?= $formulario['peticionario_nombre'] ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="peticionario_telefono">Teléfono:</label>
                        <input type="text" name="peticionario_telefono" class="form-control" value="<?= $formulario['peticionario_telefono'] ?>" readonly>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="peticionario_direccion">Dirección:</label>
                    <input type="text" name="peticionario_direccion" class="form-control" value="<?= $formulario['peticionario_direccion'] ?>" readonly>
                </div>

            </form>
        <?php else: ?>
            <!-- Mensaje si no hay información del intake -->
            <div class="alert alert-info text-center">
                <i class="fa-solid fa-info-circle me-2"></i>
                Aún no se ha completado el formulario de admisión (Intake) para este cliente. Por favor, solicite al cliente que lo complete en su próxima consulta.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript para habilitar edición -->
<script>
    document.getElementById('btnEditar').addEventListener('click', function() {
        const inputs = document.querySelectorAll('#formularioAdmision input, #formularioAdmision textarea, #formularioAdmision select');
        inputs.forEach(input => input.removeAttribute('readonly'));
        document.getElementById('btnGuardar').classList.remove('d-none');
        this.classList.add('d-none');
    });

    document.getElementById('btnGuardar').addEventListener('click', function() {
        // Aquí puedes añadir la lógica para guardar el formulario
        alert('Guardar cambios...');
    });
</script>