<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <title>Formulario ya Completado</title>
    <meta name="description" content="Intake Form Submitted">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url("apple-touch-icon.png") ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url("favicon-32x32.png") ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("favicon-16x16.png") ?>">
    <link rel="manifest" href="<?= base_url("site.webmanifest") ?>">
    <link rel="mask-icon" href="<?= base_url("safari-pinned-tab.svg") ?>" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="<?= base_url("css/normalize.css") ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url("css/intake.css") ?>">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">

    <script>
        const baseUrl = "<?= base_url() ?>";
    </script>
</head>

<body>
    <header class="container header mt-3">
        <div class="row align-items-center mb-3">
            <div class="col-md-5">
                <div class="p-4">
                    <img src="<?= base_url("img/logo.svg") ?>" alt="" class="img-fluid" width="100%">
                </div>
            </div>
            <div class="col-md-7">
                <p class="text-white">
                    ¡Hola <b><?= esc($cliente["nombre"]) ?></b>! Nos complace informarte que ya has completado el formulario de admisión. Si necesitas realizar cambios o actualizaciones, por favor contáctanos.
                </p>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row my-5">
            <div class="col-12">
                <div class="card card-body text-center">
                    <h2 class="mb-3">Formulario ya completado</h2>
                    <p class="mb-5">
                        Hemos recibido toda la información necesaria para continuar con tu proceso. A continuación, te mostramos los detalles más relevantes que proporcionaste para que puedas revisarlos.
                    </p>

                    <!-- Resumen de la información proporcionada -->
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <h3>Detalles del Cliente:</h3>
                            <ul class="list-group list-group-flush text-start">
                                <li class="list-group-item"><strong>Nombre del cliente:</strong> <?= esc($cliente["nombre"]) ?></li>
                                <li class="list-group-item"><strong>Teléfono:</strong> <?= esc($cliente["telefono"]) ?></li>
                                <li class="list-group-item"><strong>Sucursal:</strong> <?= esc($formularioExistente["sucursal_nombre"]) ?></li>
                                <li class="list-group-item"><strong>Fecha de Consulta:</strong> <?= esc($formularioExistente["fecha_consulta"]) ?></li>
                                <li class="list-group-item"><strong>Contacto preferido:</strong> <?= esc($formularioExistente["contacto"]) ?> (Horario: <?= esc($formularioExistente["horario_contacto"]) ?>)</li>
                                <li class="list-group-item"><strong>Motivo de la visita:</strong> <?= esc($formularioExistente["motivo_visita"]) ?></li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <h3>Detalles del Beneficiario:</h3>
                            <ul class="list-group list-group-flush text-start">
                                <li class="list-group-item"><strong>Nombre del Beneficiario:</strong> <?= esc($formularioExistente["beneficiario_nombre"]) ?></li>
                                <li class="list-group-item"><strong>Género:</strong> <?= esc($formularioExistente["beneficiario_genero"]) ?></li>
                                <li class="list-group-item"><strong>Fecha de Nacimiento:</strong> <?= esc($formularioExistente["beneficiario_fecha_nacimiento"]) ?></li>
                                <li class="list-group-item"><strong>Ciudad de Nacimiento:</strong> <?= esc($formularioExistente["beneficiario_ciudad"]) ?></li>
                                <li class="list-group-item"><strong>Nacionalidad:</strong> <?= esc($formularioExistente["nationality"]) ?><?= esc($formularioExistente["segunda_nacionalidad"]) ? ', ' . esc($formularioExistente["segunda_nacionalidad"]) : '' ?></li>
                                <li class="list-group-item"><strong>Estatus Migratorio Actual:</strong> <?= esc($formularioExistente["estatus_migratorio_actual"]) ?></li>
                                <li class="list-group-item"><strong>Fecha de última entrada a EEUU:</strong> <?= esc($formularioExistente["fecha_ultima_entrada"]) ?></li>
                            </ul>
                        </div>
                    </div>

                    <p>Si notas algún error en la información o necesitas realizar cambios, contáctanos directamente para asistencia.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url("js/intake.js") ?>"></script>
</body>

</html>