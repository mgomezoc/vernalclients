<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intake - <?= $formulario['beneficiario_nombre'] ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Estilos Generales */
        body {
            margin: 10px;
            font-family: 'Raleway', sans-serif;
            font-size: 14px;
            color: #333;
            background-color: #f8f9fa;
        }

        h1 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-weight: bold;
            color: #000;
        }

        h5 {
            font-size: 16px;
            margin-bottom: 10px;
            border-bottom: 1px solid #0056b3;
            padding-bottom: 5px;
            margin-top: 25px;
            text-transform: uppercase;
            color: #0056b3;
        }

        .data-label {
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        .data-text {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .data-cell {
            padding: 8px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            background-color: #fff;
            border-radius: 5px;
        }

        .data-cell-full {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            background-color: #fff;
            border-radius: 5px;
        }

        .container hr {
            margin-top: 20px;
            margin-bottom: 15px;
            border-top: 1px solid #0056b3;
        }

        .btn-imprimir {
            margin-bottom: 20px;
            background-color: #0056b3;
            color: #fff;
            border: none;
        }

        .btn-imprimir:hover {
            background-color: #003d80;
        }

        /* Estilos de Impresión */
        @media print {
            .btn-imprimir {
                display: none;
            }

            body {
                margin: 0;
                padding: 10px;
                font-size: 12px;
                color: #000;
                background-color: #fff;
            }

            .container {
                width: 100%;
            }

            h1 {
                font-size: 18px;
                margin-bottom: 10px;
            }

            h5 {
                font-size: 14px;
                margin-bottom: 8px;
                padding-bottom: 4px;
                margin-top: 15px;
                color: #000;
            }

            .data-cell,
            .data-cell-full {
                padding: 6px;
                border: 0;
                margin-bottom: 6px;
                border-radius: 0;
            }

            .data-text {
                margin-bottom: 6px;
            }

            .row {
                display: flex;
                flex-wrap: wrap;
            }

            .col-md-6 {
                width: 50%;
                padding-right: 5px;
                box-sizing: border-box;
            }

            .col-md-12 {
                width: 100%;
                padding-right: 5px;
                box-sizing: border-box;
            }

            .container hr {
                margin-top: 15px;
                margin-bottom: 10px;
            }

            .page-break {
                page-break-after: always;
            }
        }
    </style>
    <script src="https://kit.fontawesome.com/d179c845aa.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="my-5 text-end">
            <button class="btn btn-secondary btn-imprimir" onclick="window.print();">
                <i class="fa-solid fa-print me-1"></i>
                Imprimir
            </button>
        </div>
        <div id="formulario_admision">
            <h1>Expediente de Admisión</h1>

            <h5>Información General:</h5>
            <div class="row">
                <div class="col-md-6 data-cell">
                    <div class="data-label">Fecha de consulta:</div>
                    <div class="data-text"><?= isset($formulario['fecha_consulta']) ? esc($formulario['fecha_consulta']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Sucursal:</div>
                    <div class="data-text"><?= isset($formulario['sucursal_nombre']) ? esc($formulario['sucursal_nombre']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">¿Es su primera consulta aquí?</div>
                    <div class="data-text"><?= isset($formulario['es_primera_consulta']) ? esc($formulario['es_primera_consulta']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">¿Recuerda la última fecha de su consulta?</div>
                    <div class="data-text"><?= isset($formulario['fecha_ultima_consulta']) ? esc($formulario['fecha_ultima_consulta']) : 'N/A' ?></div>
                </div>
                <div class="col-md-12 data-cell">
                    <div class="data-label">¿Cómo se enteró de nuestro servicio?</div>
                    <div class="data-text"><?= isset($formulario['fuente_informacion']) ? esc($formulario['fuente_informacion']) : 'N/A' ?></div>
                </div>
                <div class="col-md-12 data-cell">
                    <div class="data-label">Especifique el motivo de su visita:</div>
                    <div class="data-text"><?= isset($formulario['motivo_visita']) ? esc($formulario['motivo_visita']) : 'N/A' ?></div>
                </div>
            </div>

            <h5>Información del Beneficiario(a):</h5>
            <div class="row">
                <?php if (isset($formulario['a_number'])): ?>
                    <div class="col-md-6 data-cell">
                        <div class="data-label">¿Posee A-Number?</div>
                        <div class="data-text"><?= esc($formulario['a_number']) ?></div>
                    </div>
                <?php endif; ?>
                <div class="col-md-6 data-cell">
                    <div class="data-label">¿Posee alguna segunda nacionalidad?</div>
                    <div class="data-text"><?= isset($formulario['segunda_nacionalidad']) ? esc($formulario['segunda_nacionalidad']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Nombre completo</div>
                    <div class="data-text"><?= isset($formulario['beneficiario_nombre']) ? esc($formulario['beneficiario_nombre']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Género</div>
                    <div class="data-text"><?= isset($formulario['beneficiario_genero']) ? esc($formulario['beneficiario_genero']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Estado Civil</div>
                    <div class="data-text"><?= isset($formulario['beneficiario_estado_civil']) ? esc($formulario['beneficiario_estado_civil']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Fecha de nacimiento</div>
                    <div class="data-text"><?= isset($formulario['beneficiario_fecha_nacimiento']) ? esc($formulario['beneficiario_fecha_nacimiento']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Ciudad y país de nacimiento</div>
                    <div class="data-text"><?= isset($formulario['beneficiario_ciudad_pais']) ? esc($formulario['beneficiario_ciudad_pais']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Calle y número</div>
                    <div class="data-text"><?= isset($formulario['direccion_calle_numero']) ? esc($formulario['direccion_calle_numero']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Ciudad</div>
                    <div class="data-text"><?= isset($formulario['direccion_ciudad']) ? esc($formulario['direccion_ciudad']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">País</div>
                    <div class="data-text"><?= isset($formulario['direccion_pais']) ? esc($formulario['direccion_pais']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Código postal</div>
                    <div class="data-text"><?= isset($formulario['direccion_cp']) ? esc($formulario['direccion_cp']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Teléfono</div>
                    <div class="data-text"><?= isset($formulario['direccion_telefono']) ? esc($formulario['direccion_telefono']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Correo electrónico</div>
                    <div class="data-text"><?= isset($formulario['direccion_email']) ? esc($formulario['direccion_email']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Mejor opción para contactarlo</div>
                    <div class="data-text"><?= isset($formulario['contacto']) ? esc($formulario['contacto']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Horario de contacto preferido</div>
                    <div class="data-text"><?= isset($formulario['horario_contacto']) ? esc($formulario['horario_contacto']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Vive con ambos padres</div>
                    <div class="data-text"><?= isset($formulario['beneficiario_vive_ambos_padres']) ? esc($formulario['beneficiario_vive_ambos_padres']) : 'N/A' ?></div>
                </div>
            </div>

            <h5>Preguntas de Inmigración para el (la) Beneficiario(a):</h5>
            <div class="row">
                <div class="col-md-6 data-cell">
                    <div class="data-label">¿Cómo entró a EE.UU.?</div>
                    <div class="data-text"><?= isset($formulario['como_entro_eeuu']) ? esc($formulario['como_entro_eeuu']) : 'N/A' ?></div>
                </div>
                <?php if (isset($formulario['tipo_visa'])): ?>
                    <div class="col-md-6 data-cell">
                        <div class="data-label">Si entró con visa, ¿cuál es el tipo de visa?</div>
                        <div class="data-text"><?= esc($formulario['tipo_visa']) ?></div>
                    </div>
                <?php endif; ?>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Estatus migratorio actual</div>
                    <div class="data-text"><?= isset($formulario['estatus_migratorio_actual']) ? esc($formulario['estatus_migratorio_actual']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Fecha de última entrada a los Estados Unidos</div>
                    <div class="data-text"><?= isset($formulario['fecha_ultima_entrada']) ? esc($formulario['fecha_ultima_entrada']) : 'N/A' ?></div>
                </div>
                <div class="col-md-12 data-cell">
                    <div class="data-label">¿Alguna vez han sometido una solicitud migratoria en beneficio suyo?</div>
                    <div class="data-text"><?= isset($formulario['solicitud_migratoria']) ? esc($formulario['solicitud_migratoria']) : 'N/A' ?></div>
                </div>
                <?php if (isset($formulario['solicitud_migratoria_explicacion'])): ?>
                    <div class="col-md-12 data-cell">
                        <div class="data-label">Si es así, explique quién, cuándo y los resultados</div>
                        <div class="data-text"><?= esc($formulario['solicitud_migratoria_explicacion']) ?></div>
                    </div>
                <?php endif; ?>
                <div class="col-md-12 data-cell">
                    <div class="data-label">¿Está actualmente en un proceso de inmigración?</div>
                    <div class="data-text"><?= isset($formulario['proceso_migracion']) ? esc($formulario['proceso_migracion']) : 'N/A' ?></div>
                </div>
                <div class="col-md-12 data-cell">
                    <div class="data-label">Relación en el proceso</div>
                    <div class="data-text"><?= isset($formulario['proceso_relacion']) ? esc($formulario['proceso_relacion']) : 'N/A' ?></div>
                </div>
                <?php if (isset($formulario['proceso_migracion_explicacion'])): ?>
                    <div class="col-md-12 data-cell">
                        <div class="data-label">Si es así, explique</div>
                        <div class="data-text"><?= esc($formulario['proceso_migracion_explicacion']) ?></div>
                    </div>
                <?php endif; ?>
                <?php if (isset($formulario['parientes'])): ?>
                    <div class="col-md-12 data-cell">
                        <div class="data-label">Por favor seleccione a sus parientes que sean ciudadanos americanos o residentes legales de Estados Unidos</div>
                        <div class="data-text"><?= esc($formulario['parientes']) ?></div>
                    </div>
                <?php endif; ?>
                <div class="col-md-12 data-cell">
                    <div class="data-label">¿Tiene algún familiar en el servicio militar?</div>
                    <div class="data-text"><?= isset($formulario['familiar_servicio']) ? esc($formulario['familiar_servicio']) : 'N/A' ?></div>
                </div>
                <?php if (isset($formulario['familiar_servicio_parentesco'])): ?>
                    <div class="col-md-12 data-cell">
                        <div class="data-label">Si es así, por favor díganos el parentesco con usted:</div>
                        <div class="data-text"><?= esc($formulario['familiar_servicio_parentesco']) ?></div>
                    </div>
                <?php endif; ?>
                <div class="col-md-12 data-cell">
                    <div class="data-label">¿Ha sido alguna vez víctima de un crimen?</div>
                    <div class="data-text"><?= isset($formulario['victima_crimen']) ? esc($formulario['victima_crimen']) : 'N/A' ?></div>
                </div>
                <?php if (isset($formulario['victima_crimen_info'])): ?>
                    <div class="col-md-12 data-cell">
                        <div class="data-label">Lugar, fecha y tipo de delito</div>
                        <div class="data-text"><?= esc($formulario['victima_crimen_info']) ?></div>
                    </div>
                <?php endif; ?>
                <?php if (isset($formulario['cometido_crimen'])): ?>
                    <div class="col-md-12 data-cell">
                        <div class="data-label">¿En el contexto de migración ha cometido algún crimen en Estados Unidos, alguna vez lo han detenido?</div>
                        <div class="data-text"><?= esc($formulario['cometido_crimen']) ?></div>
                    </div>
                <?php endif; ?>
                <div class="col-md-12 data-cell">
                    <div class="data-label">¿Alguna vez ha sido arrestado por cualquier crimen?</div>
                    <div class="data-text"><?= isset($formulario['arrestado']) ? esc($formulario['arrestado']) : 'N/A' ?></div>
                </div>
                <?php if (isset($formulario['arrestado_fecha_cargo'])): ?>
                    <div class="col-md-12 data-cell">
                        <div class="data-label">Fecha y cargo</div>
                        <div class="data-text"><?= esc($formulario['arrestado_fecha_cargo']) ?></div>
                    </div>
                <?php endif; ?>
                <?php if (isset($formulario['arrestado_explicacion'])): ?>
                    <div class="col-md-12 data-cell">
                        <div class="data-label">Si ha sido más de un arresto, por favor explique</div>
                        <div class="data-text"><?= esc($formulario['arrestado_explicacion']) ?></div>
                    </div>
                <?php endif; ?>
            </div>

            <h5>Información del Peticionario:</h5>
            <div class="row">
                <div class="col-md-6 data-cell">
                    <div class="data-label">Nombre completo</div>
                    <div class="data-text"><?= isset($formulario['peticionario_nombre']) ? esc($formulario['peticionario_nombre']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Teléfono</div>
                    <div class="data-text"><?= isset($formulario['peticionario_telefono']) ? esc($formulario['peticionario_telefono']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Relación</div>
                    <div class="data-text"><?= isset($formulario['peticionario_relacion']) ? esc($formulario['peticionario_relacion']) : 'N/A' ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Dirección</div>
                    <div class="data-text"><?= isset($formulario['peticionario_direccion']) ? esc($formulario['peticionario_direccion']) : 'N/A' ?></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>