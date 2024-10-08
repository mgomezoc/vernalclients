<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Información del formulario</h5>
        <div>
            <a href="<?= site_url('clientes/imprimir/' . $cliente['id_cliente']) ?>" class="btn btn-outline-secondary me-2">
                <i class="fa-solid fa-print"></i> Imprimir
            </a>
            <button id="btnEditar" class="btn btn-outline-secondary me-2">
                <i class="fa-solid fa-edit"></i> Editar
            </button>
            <button id="btnGuardar" class="btn btn-primary d-none" form="formularioAdmision">
                <i class="fa-solid fa-save"></i> Guardar
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($formulario)): ?>
            <!-- Información del formulario -->
            <form id="formularioAdmision" method="post" class="needs-validation" novalidate>
                <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">
                <!-- INFORMACIÓN GENERAL -->
                <div id="intake-informacion-general" class="p-3 border mb-5">
                    <h5 class="fs-4 mb-4">INFORMACIÓN GENERAL</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="fecha_consulta">Fecha de consulta:</label>
                            <p><?= date('m-d-Y', strtotime($formulario['fecha_consulta'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="sucursal">Sucursal:</label>
                            <select name="sucursal" id="cbSucursales" class="select2 form-select" disabled>
                                <option value="" selected disabled>Cargando...</option>
                            </select>
                        </div>

                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">¿Es su primera consulta aquí?</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="consultaSi" name="es_primera_consulta" class="form-check-input" value="Si"
                                        <?= set_radio('es_primera_consulta', 'Si', $formulario['es_primera_consulta'] == 'Si') ?> disabled>
                                    <label class="form-check-label" for="consultaSi">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="consultaNo" name="es_primera_consulta" class="form-check-input" value="No"
                                        <?= set_radio('es_primera_consulta', 'No', $formulario['es_primera_consulta'] == 'No') ?> disabled>
                                    <label class="form-check-label" for="consultaNo">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_ultima_consulta" class="form-label">¿Recuerda la última fecha de su consulta?</label>
                            <input type="text" name="fecha_ultima_consulta" class="form-control flatpickr" value="<?= $formulario['fecha_ultima_consulta'] ?>" disabled>
                        </div>
                    </div>


                    <div class="mb-4">
                        <label class="form-label">¿Cómo se enteró de nuestro servicio?</label>
                        <div>
                            <?php
                            $fuentes = explode('|', $formulario['fuente_informacion']);
                            $opciones = ['Amigos', 'Familia', 'Fue Cliente', 'Walk-In', 'Facebook', 'Tarjeta', 'Internet', 'Instagram', 'Youtube', 'Tiktok', 'Google', 'Otro'];
                            foreach ($opciones as $opcion): ?>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" name="fuente_informacion" value="<?= $opcion ?>" <?= in_array($opcion, $fuentes) ? 'checked' : '' ?> disabled>
                                    <label class="form-check-label"><?= $opcion ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="motivo_visita">Especifique el motivo de su visita:</label>
                        <textarea name="motivo_visita" class="form-control" rows="3" disabled><?= $formulario['motivo_visita'] ?></textarea>
                    </div>
                </div>

                <!-- INFORMACIÓN DEL BENEFICIARIO -->
                <div id="intake-beneficiario" class="p-3 border mb-5">
                    <h5 class="fs-4 mb-4">INFORMACIÓN DEL BENEFICIARIO(A):</h5>

                    <div class="row mb-4">
                        <div class="form-check form-check-inline">
                            <input type="radio" id="aNumberSi" name="a_number" class="form-check-input" value="Si"
                                <?= set_radio('a_number', 'Si', $formulario['a_number'] == 'Si') ?> disabled>
                            <label class="form-check-label" for="aNumberSi">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="aNumberNo" name="a_number" class="form-check-input" value="No"
                                <?= set_radio('a_number', 'No', $formulario['a_number'] == 'No') ?> disabled>
                            <label class="form-check-label" for="aNumberNo">No</label>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="nationality">Ciudadanía:</label>
                            <input type="text" name="nationality" class="form-control" value="<?= $formulario['nationality'] ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="segunda_nacionalidad">¿Posee alguna segunda nacionalidad?</label>
                            <input type="text" name="segunda_nacionalidad" class="form-control" value="<?= $formulario['segunda_nacionalidad'] ?>" disabled>
                        </div>
                    </div>

                    <!-- Datos Básicos -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="beneficiario_nombre">Nombre completo:</label>
                            <input type="text" name="beneficiario_nombre" class="form-control" value="<?= $formulario['beneficiario_nombre'] ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="beneficiario_fecha_nacimiento">Fecha de nacimiento:</label>
                            <input type="text" name="beneficiario_fecha_nacimiento" class="form-control flatpickr" value="<?= $formulario['beneficiario_fecha_nacimiento'] ?>" disabled>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Género:</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="generoMasculino" name="beneficiario_genero" class="form-check-input" value="Masculino"
                                        <?= set_radio('beneficiario_genero', 'Masculino', $formulario['beneficiario_genero'] == 'Masculino') ?> disabled>
                                    <label class="form-check-label" for="generoMasculino">Masculino</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="generoFemenino" name="beneficiario_genero" class="form-check-input" value="Femenino"
                                        <?= set_radio('beneficiario_genero', 'Femenino', $formulario['beneficiario_genero'] == 'Femenino') ?> disabled>
                                    <label class="form-check-label" for="generoFemenino">Femenino</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estado Civil:</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="estadoCasado" name="beneficiario_estado_civil" class="form-check-input" value="Married"
                                        <?= set_radio('beneficiario_estado_civil', 'Married', $formulario['beneficiario_estado_civil'] == 'Married') ?> disabled>
                                    <label class="form-check-label" for="estadoCasado">Casado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="estadoDivorciado" name="beneficiario_estado_civil" class="form-check-input" value="Divorced"
                                        <?= set_radio('beneficiario_estado_civil', 'Divorced', $formulario['beneficiario_estado_civil'] == 'Divorced') ?> disabled>
                                    <label class="form-check-label" for="estadoDivorciado">Divorciado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="estadoViudo" name="beneficiario_estado_civil" class="form-check-input" value="Widowed"
                                        <?= set_radio('beneficiario_estado_civil', 'Widowed', $formulario['beneficiario_estado_civil'] == 'Widowed') ?> disabled>
                                    <label class="form-check-label" for="estadoViudo">Viudo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="estadoSoltero" name="beneficiario_estado_civil" class="form-check-input" value="Single"
                                        <?= set_radio('beneficiario_estado_civil', 'Single', $formulario['beneficiario_estado_civil'] == 'Single') ?> disabled>
                                    <label class="form-check-label" for="estadoSoltero">Soltero</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Datos de Nacimiento -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label" for="direccion_ciudad">Ciudad de nacimiento:</label>
                            <input type="text" name="direccion_ciudad" class="form-control" value="<?= $formulario['beneficiario_ciudad'] ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="direccion_estado">Estado de nacimiento:</label>
                            <input type="text" name="direccion_estado" class="form-control" value="<?= $formulario['beneficiario_estado'] ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="direccion_pais">País de nacimiento:</label>
                            <input type="text" name="direccion_pais" class="form-control" value="<?= $formulario['beneficiario_pais'] ?>" disabled>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="direccion_calle_numero">Calle y número:</label>
                            <input type="text" name="direccion_calle_numero" class="form-control" value="<?= $formulario['direccion_calle_numero'] ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="direccion_ciudad">Ciudad:</label>
                            <input type="text" name="direccion_ciudad" class="form-control" value="<?= $formulario['direccion_ciudad'] ?>" disabled>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="direccion_pais">País:</label>
                            <input type="text" name="direccion_pais" class="form-control" value="<?= $formulario['direccion_pais'] ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="direccion_cp">Código postal:</label>
                            <input type="text" name="direccion_cp" class="form-control" value="<?= $formulario['direccion_cp'] ?>" disabled>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="direccion_telefono">Teléfono:</label>
                            <input type="text" name="direccion_telefono" class="form-control" value="<?= $formulario['direccion_telefono'] ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="direccion_email">Correo electrónico:</label>
                            <input type="email" name="direccion_email" class="form-control" value="<?= $formulario['direccion_email'] ?>" disabled>
                        </div>
                    </div>

                    <!-- Otras Preferencias -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="contacto">Mejor opción para contactarlo:</label>
                            <select name="contacto" id="contacto" class="form-select" disabled>
                                <option value="Llamada" <?= set_select('contacto', 'Llamada', $formulario['contacto'] == 'Llamada') ?>>Llamada</option>
                                <option value="Mensaje" <?= set_select('contacto', 'Mensaje', $formulario['contacto'] == 'Mensaje') ?>>Mensaje</option>
                                <option value="Correo" <?= set_select('contacto', 'Correo', $formulario['contacto'] == 'Correo') ?>>Correo</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="horario_contacto">Horario de contacto preferido:</label>
                            <select id="horarioContacto" name="horario_contacto" class="form-select" disabled>
                                <option value="manana" <?= set_select('horario_contacto', 'manana', $formulario['horario_contacto'] == 'manana') ?>>Mañana (9:00 AM - 12:00 PM)</option>
                                <option value="tarde" <?= set_select('horario_contacto', 'tarde', $formulario['horario_contacto'] == 'tarde') ?>>Tarde (1:00 PM - 5:00 PM)</option>
                            </select>
                        </div>
                    </div>
                </div>


                <!-- PREGUNTAS DE INMIGRACIÓN -->
                <div id="intake-preguntas" class="p-3 border mb-5">
                    <h5 class="fs-4 mb-4">PREGUNTAS DE INMIGRACIÓN PARA EL (LA) BENEFICIARIO(A):</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="como_entro_eeuu">¿Cómo entró a EE.UU.?</label>
                            <select id="comoEntroEeuu" name="como_entro_eeuu" class="form-select" disabled>
                                <option value="Con Visa" <?= set_select('como_entro_eeuu', 'Con Visa', $formulario['como_entro_eeuu'] == 'Con Visa') ?>>Con Visa</option>
                                <option value="Sin Visa" <?= set_select('como_entro_eeuu', 'Sin Visa', $formulario['como_entro_eeuu'] == 'Sin Visa') ?>>Sin Visa</option>
                                <option value="Con parole" <?= set_select('como_entro_eeuu', 'Con parole', $formulario['como_entro_eeuu'] == 'Con parole') ?>>Con parole</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="container-visa" style="display: <?= ($formulario['como_entro_eeuu'] == 'Con Visa') ? 'block' : 'none' ?>;">
                            <label class="form-label" for="tipo_visa">Tipo de visa (si aplica):</label>
                            <input type="text" name="tipo_visa" id="tipoVisa" class="form-control" value="<?= $formulario['tipo_visa'] ?>" disabled>
                        </div>
                    </div>


                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="estatus_migratorio_actual">Estatus migratorio actual:</label>
                            <select name="estatus_migratorio_actual" id="cbEstatusMigratorio" class="form-select select2 cbEstatusMigratorio" disabled></select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="fecha_ultima_entrada">Fecha de última entrada a los Estados Unidos:</label>
                            <input type="text" name="fecha_ultima_entrada" class="form-control flatpickr" value="<?= $formulario['fecha_ultima_entrada'] ?>" disabled>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="solicitud_migratoria">¿Alguna vez han sometido una solicitud migratoria en beneficio suyo?</label>
                            <select id="solicitudMigratoria" name="solicitud_migratoria" class="form-select" disabled>
                                <option value="Si" <?= set_select('solicitud_migratoria', 'Si', $formulario['solicitud_migratoria'] == 'Si') ?>>Sí</option>
                                <option value="No" <?= set_select('solicitud_migratoria', 'No', $formulario['solicitud_migratoria'] == 'No') ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="container-peticionado" style="display: <?= ($formulario['solicitud_migratoria'] == 'Si') ? 'block' : 'none' ?>;">
                            <label class="form-label" for="solicitud_migratoria_explicacion">Si es así, explique quién, cuándo, y los resultados:</label>
                            <textarea name="solicitud_migratoria_explicacion" class="form-control" rows="3" disabled><?= $formulario['solicitud_migratoria_explicacion'] ?></textarea>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="proceso_migracion">¿Está actualmente en un proceso de inmigración?</label>
                            <select id="procesoMigracion" name="proceso_migracion" class="form-select" disabled>
                                <option value="Si" <?= set_select('proceso_migracion', 'Si', $formulario['proceso_migracion'] == 'Si') ?>>Sí</option>
                                <option value="No" <?= set_select('proceso_migracion', 'No', $formulario['proceso_migracion'] == 'No') ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="container-procesoMigracion" style="display: <?= ($formulario['proceso_migracion'] == 'Si') ? 'block' : 'none' ?>;">
                            <label class="form-label" for="proceso_migracion_explicacion">Si es así, explique:</label>
                            <textarea name="proceso_migracion_explicacion" class="form-control" rows="3" disabled><?= $formulario['proceso_migracion_explicacion'] ?></textarea>
                        </div>
                    </div>


                    <?php
                    // Convertimos la cadena de parientes en un array para marcar los checkboxes seleccionados
                    $parientesSeleccionados = explode(',', $formulario['parientes']);
                    ?>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="form-label" for="parientes">Parientes en EE.UU.:</label>
                            <div class="d-flex flex-wrap">
                                <div class="form-check me-3">
                                    <input type="checkbox" class="form-check-input" name="parientes" value="Hijo(a)" id="parienteHijo" <?= in_array('Hijo(a)', $parientesSeleccionados) ? 'checked' : '' ?> disabled>
                                    <label class="form-check-label" for="parienteHijo">Hijo(a)</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" class="form-check-input" name="parientes" value="Esposo(a)" id="parienteEsposo" <?= in_array('Esposo(a)', $parientesSeleccionados) ? 'checked' : '' ?> disabled>
                                    <label class="form-check-label" for="parienteEsposo">Esposo(a)</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" class="form-check-input" name="parientes" value="Hermano(a)" id="parienteHermano" <?= in_array('Hermano(a)', $parientesSeleccionados) ? 'checked' : '' ?> disabled>
                                    <label class="form-check-label" for="parienteHermano">Hermano(a)</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" class="form-check-input" name="parientes" value="Padre / Madre" id="parientePadreMadre" <?= in_array('Padre / Madre', $parientesSeleccionados) ? 'checked' : '' ?> disabled>
                                    <label class="form-check-label" for="parientePadreMadre">Padre / Madre</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="familiar_servicio">¿Tiene algún familiar en el servicio militar?</label>
                            <select id="familiarServicio" name="familiar_servicio" class="form-select" disabled>
                                <option value="Si" <?= set_select('familiar_servicio', 'Si', $formulario['familiar_servicio'] == 'Si') ?>>Sí</option>
                                <option value="No" <?= set_select('familiar_servicio', 'No', $formulario['familiar_servicio'] == 'No') ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="container-servicioMilitar" style="display: <?= ($formulario['familiar_servicio'] == 'Si') ? 'block' : 'none' ?>;">
                            <label class="form-label" for="familiar_servicio_parentesco">Parentesco con el familiar en el servicio militar:</label>
                            <select name="familiar_servicio_parentesco" id="familiarServicioParentesco" class="form-select select2" disabled>
                                <option value="" disabled <?= empty($formulario['familiar_servicio_parentesco']) ? 'selected' : '' ?>>Selecciona una opción</option>
                                <option value="Padre" <?= set_select('familiar_servicio_parentesco', 'Padre', $formulario['familiar_servicio_parentesco'] == 'Padre') ?>>Padre</option>
                                <option value="Madre" <?= set_select('familiar_servicio_parentesco', 'Madre', $formulario['familiar_servicio_parentesco'] == 'Madre') ?>>Madre</option>
                                <option value="Hermano/a" <?= set_select('familiar_servicio_parentesco', 'Hermano/a', $formulario['familiar_servicio_parentesco'] == 'Hermano/a') ?>>Hermano/a</option>
                                <option value="Hijo/a" <?= set_select('familiar_servicio_parentesco', 'Hijo/a', $formulario['familiar_servicio_parentesco'] == 'Hijo/a') ?>>Hijo/a</option>
                                <option value="Otro" <?= set_select('familiar_servicio_parentesco', 'Otro', $formulario['familiar_servicio_parentesco'] == 'Otro') ?>>Otro</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="victima_crimen">¿Ha sido alguna vez víctima de un crimen?</label>
                            <select id="victimaCrimen" name="victima_crimen" class="form-select" disabled>
                                <option value="Si" <?= set_select('victima_crimen', 'Si', $formulario['victima_crimen'] == 'Si') ?>>Sí</option>
                                <option value="No" <?= set_select('victima_crimen', 'No', $formulario['victima_crimen'] == 'No') ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="container-victimaCrimen" style="display: <?= ($formulario['victima_crimen'] == 'Si') ? 'block' : 'none' ?>;">
                            <label class="form-label" for="victima_crimen_info">Lugar, fecha, y tipo de delito:</label>
                            <textarea name="victima_crimen_info" class="form-control" rows="3" disabled><?= $formulario['victima_crimen_info'] ?></textarea>
                        </div>
                    </div>


                    <?php
                    // Convertimos la cadena de valores separados por comas en un array para marcar los checkboxes seleccionados
                    $cometidoCrimenSeleccionados = explode(',', $formulario['cometido_crimen']);
                    ?>
                    <div class="mb-4">
                        <label class="form-label" for="cometido_crimen">En el contexto de migración, ¿ha cometido algún crimen en EE.UU.?</label>
                        <div class="d-flex gap-3 flex-wrap">
                            <div class="form-check me-3">
                                <input type="checkbox" class="form-check-input" name="cometido_crimen" value="Huellas" id="huellas" <?= in_array('Huellas', $cometidoCrimenSeleccionados) ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="huellas">Huellas</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" class="form-check-input" name="cometido_crimen" value="Pedido que se regrese de la frontera" id="pedidoFrontera" <?= in_array('Pedido que se regrese de la frontera', $cometidoCrimenSeleccionados) ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="pedidoFrontera">Pedido que se regrese de la frontera</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" class="form-check-input" name="cometido_crimen" value="Visto un juez de migración" id="juezMigracion" <?= in_array('Visto un juez de migración', $cometidoCrimenSeleccionados) ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="juezMigracion">Visto un juez de migración</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" class="form-check-input" name="cometido_crimen" value="Fotografías" id="fotografias" <?= in_array('Fotografías', $cometidoCrimenSeleccionados) ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="fotografias">Fotografías</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" class="form-check-input" name="cometido_crimen" value="Visto a un oficial de migración" id="oficialMigracion" <?= in_array('Visto a un oficial de migración', $cometidoCrimenSeleccionados) ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="oficialMigracion">Visto a un oficial de migración</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" class="form-check-input" name="cometido_crimen" value="Pedidos que firme algún documento" id="firmarDocumento" <?= in_array('Pedidos que firme algún documento', $cometidoCrimenSeleccionados) ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="firmarDocumento">Pedidos que firme algún documento</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" class="form-check-input" name="cometido_crimen" value="Concedido salida voluntaria" id="salidaVoluntaria" <?= in_array('Concedido salida voluntaria', $cometidoCrimenSeleccionados) ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="salidaVoluntaria">Concedido salida voluntaria</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" class="form-check-input" name="cometido_crimen" value="Deportado" id="deportado" <?= in_array('Deportado', $cometidoCrimenSeleccionados) ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="deportado">Deportado</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" class="form-check-input" name="cometido_crimen" value="Arresto o detención en la frontera" id="arrestoFrontera" <?= in_array('Arresto o detención en la frontera', $cometidoCrimenSeleccionados) ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="arrestoFrontera">Arresto o detención en la frontera</label>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="intake-arrestos" class="p-3 border mb-5">
                    <h5 class="fs-4 mb-4">INFORMACIÓN DE ARRESTOS:</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="arrestado">¿Alguna vez ha sido arrestado por CUALQUIER crimen?</label>
                            <select id="arrestado" name="arrestado" class="form-select" disabled>
                                <option value="Si" <?= set_select('arrestado', 'Si', $formulario['arrestado'] == 'Si') ?>>Sí</option>
                                <option value="No" <?= set_select('arrestado', 'No', $formulario['arrestado'] == 'No') ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="container-arresto" style="display: <?= ($formulario['arrestado'] == 'Si') ? 'block' : 'none' ?>;">
                            <label class="form-label" for="arrestado_fecha_cargo">Fecha y Cargo:</label>
                            <textarea name="arrestado_fecha_cargo" class="form-control" rows="3" disabled><?= $formulario['arrestado_fecha_cargo'] ?></textarea>
                        </div>
                    </div>
                    <div class="mb-4" id="container-explicacion" style="display: <?= ($formulario['arrestado'] == 'Si') ? 'block' : 'none' ?>;">
                        <label class="form-label" for="arrestado_explicacion">Si es más de un arresto, por favor explique:</label>
                        <textarea name="arrestado_explicacion" class="form-control" rows="3" disabled><?= $formulario['arrestado_explicacion'] ?></textarea>
                    </div>
                </div>


                <!-- INFORMACIÓN DEL PETICIONARIO -->
                <div id="intake" class="p-3 border mb-5">
                    <h5 class="fs-4 mb-4">INFORMACIÓN DEL PETICIONARIO:</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label" for="peticionario_nombre">Nombre completo:</label>
                            <input type="text" name="peticionario_nombre" class="form-control" value="<?= $formulario['peticionario_nombre'] ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="peticionario_telefono">Teléfono:</label>
                            <input type="text" name="peticionario_telefono" class="form-control" value="<?= $formulario['peticionario_telefono'] ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="peticionario_relacion">Relación:</label>
                            <input type="text" name="peticionario_relacion" class="form-control" value="<?= $formulario['peticionario_relacion'] ?>" disabled>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="peticionario_direccion">Dirección:</label>
                        <input type="text" name="peticionario_direccion" class="form-control" value="<?= $formulario['peticionario_direccion'] ?>" disabled>
                    </div>
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