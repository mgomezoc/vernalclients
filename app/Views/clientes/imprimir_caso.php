<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caso_<?= esc($caso['id_caso']) ?></title>
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
        <div id="formulario_caso">
            <h1>Expediente del Caso #<?= esc($caso['id_caso']) ?></h1>

            <h5>Proceso Principal:</h5>
            <div class="data-cell data-cell-full">
                <div class="data-label">Descripción:</div>
                <div class="data-text"><?= esc($caso['proceso']) ?></div>
            </div>

            <h5>Procesos Adicionales:</h5>
            <div class="data-cell data-cell-full">
                <ul>
                    <?php $procesos_adicionales = json_decode($caso['procesos_adicionales'], true); ?>
                    <?php if (!empty($procesos_adicionales)): ?>
                        <?php foreach ($procesos_adicionales as $proceso): ?>
                            <li><?= esc($proceso['label']) ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No hay procesos adicionales.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <h5>Antecedente:</h5>
            <div class="data-cell data-cell-full">
                <div class="data-label">Comentarios:</div>
                <div class="data-text"><?= htmlspecialchars_decode($caso['comentarios']) ?></div>
            </div>

            <div class="row">
                <div class="col-md-6 data-cell">
                    <div class="data-label">Creado:</div>
                    <div class="data-text"><?= esc($caso['fecha_creacion']) ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Última actualización:</div>
                    <div class="data-text"><?= esc($caso['fecha_actualizacion']) ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Costo:</div>
                    <div class="data-text"><?= esc($caso['costo']) ?></div>
                </div>
                <div class="col-md-6 data-cell">
                    <div class="data-label">Fecha de corte:</div>
                    <div class="data-text"><?= esc($caso['fecha_corte']) ?></div>
                </div>
            </div>

            <h5>Comentarios</h5>
            <div class="data-cell data-cell-full">
                <?php if (empty($comentarios)): ?>
                    <p>No hay comentarios.</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($comentarios as $comentario): ?>
                            <li class="list-group-item">
                                <strong><?= esc($comentario['nombre_usuario']) ?>:</strong> <?= esc($comentario['comentario']) ?>
                                <br><small class="text-muted"><?= esc($comentario['fecha_creacion']) ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>