<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <title>Formulario de Admisión</title>
    <meta name="description" content="Intake New Clients">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url("apple-touch-icon.png") ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url("favicon-32x32.png") ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("favicon-16x16.png") ?>">
    <link rel="manifest" href="<?= base_url("site.webmanifest") ?>">
    <link rel="mask-icon" href="<?= base_url("safari-pinned-tab.svg") ?>" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="<?= base_url("css/normalize.css") ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    <link rel="stylesheet" href="<?= base_url("css/intake.css") ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <meta name="theme-color" content="#fafafa">
    <script src="https://kit.fontawesome.com/901438e2f4.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
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
                    Bienvenido <b><?= $cliente["nombre"] ?></b> a VFM Law Firm, esperamos poder ayudarlo con sus necesidades legales.
                    Para poder asistirlo mejor, responda las siguientes preguntas de manera completa y
                    precisa. Esta información es confidencial y no se compartirá con nadie que no
                    pertenezca a VFM Law Firm.
                </p>
            </div>
        </div>
    </header>

    <div class="container">
        <div id="mensajeCorrecto" class="row hide my-5">
            <div class="col-12">
                <div class="card card-body text-center">
                    <h2 class="mb-3">Gracias por elegir a “The Law Office of Vernal Farnum Mejia”</h2>
                    <p class="mb-5">
                        Para realizar tus trámites migratorios. Deseamos ofrecerte un servicio humano, honesto y eficaz. Además, deseamos que tu visita a nuestras oficinas sea lo más agradable posible. Por eso, para evaluar mejor tu caso de inmigración queremos que tomes en cuenta las siguientes recomendaciones.
                    </p>

                    <div class="row mb-5">
                        <div class="col-md-6">
                            <dotlottie-player src="https://lottie.host/a41589ca-1f46-43bb-be29-3fea83c6f622/LbMgvaHcKO.json" background="transparent" speed="1" style="width: 300px; height: 300px;margin:0 auto" loop autoplay></dotlottie-player>
                        </div>
                        <div class="col-md-6">
                            <h3>Debes traer contigo:</h3>
                            <ol class="list-group list-group-flush list-group-numbered text-start">
                                <li class="list-group-item">Una identificación de tu país de origen.</li>
                                <li class="list-group-item">Documentos de la Corte de inmigración.</li>
                                <li class="list-group-item">Reporte de detenciones en la frontera.</li>
                                <li class="list-group-item">Recibos de procesos migratorios sometidos.</li>
                                <li class="list-group-item">Reportes de la policía</li>
                            </ol>
                            <div class="text-center my-3">
                                <script async src="https://js.stripe.com/v3/buy-button.js">
                                </script>

                                <stripe-buy-button
                                    buy-button-id="buy_btn_1Q0XUGFzRmkRg5LnvTDOHQzS"
                                    publishable-key="pk_live_51OcBXaFzRmkRg5LnA8pS8iBLjsTOGSBfUe6qqij1C8Vp0t5AoGuKzBatdgeuoYSnpyzi2bpBSnRRbWalzHSi7EN200s6W8aC4L">
                                </stripe-buy-button>
                            </div>
                        </div>
                    </div>

                    <p>También le recordamos que si necesita ser acompañado, contemplamos un máximo de 2 personas ya que seguimos las recomendaciones del Departamento de Salud.</p>
                    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                </div>
            </div>
        </div>

        <div id="formContainer" class="col-md-12">
            <form id="frmIntake" method="post" class="card card-body p-5 mb-5" autocomplete="off">
                <input type="hidden" name="id_cliente" value="<?= $cliente["id_cliente"] ?>">
                <div class="row">
                    <div class="col-md-8">
                        <div id="informacion-general" class="mb-5">
                            <h3>INFORMACIÓN GENERAL:</h3>
                            <div class="container-fluid">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="row justify-content-center align-content-center">
                                            <label class="col-sm-3 col-form-label">Fecha de consulta:</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="fecha_creado" value="<?= $fechaActual ?>" class="form-control-plaintext" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cbSucursales">Sucursal</label>
                                        <div class="d-flex flex-column-reverse">
                                            <select id="cbSucursales" name="sucursal" class="form-select select2" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="row justify-content-center align-items-center">
                                            <label class="col-sm-6 col-form-label">¿Es su primera consulta aquí?</label>
                                            <div class="col-sm-6">
                                                <div class="pretty p-default p-curve">
                                                    <input type="radio" name="es_primera_consulta" class="muestraMasInformacion" data-target="#container-primeraConsulta" value="Si" data-display="0" checked />
                                                    <div class="state p-success-o">
                                                        <label>Si</label>
                                                    </div>
                                                </div>
                                                <div class="pretty p-default p-curve">
                                                    <input type="radio" name="es_primera_consulta" class="muestraMasInformacion" data-target="#container-primeraConsulta" value="No" data-display="1" />
                                                    <div class="state p-primary-o">
                                                        <label>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="container-primeraConsulta" class="row justify-content-center align-items-center" hidden>
                                            <label class="col-sm-6 col-form-label">¿Recuerda la última fecha de su consulta?</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control flatpickr" name="fecha_ultima_consulta">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-sm-3 col-form-label">¿Cómo se enteró de nuestro servicio?</label>
                                    <div class="col-sm-9">
                                        <div class="pretty-container">
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Amigos" />
                                                <div class="state p-info">
                                                    <label>Amigos</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Familia" />
                                                <div class="state p-info">
                                                    <label>Familia</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Fue Cliente" />
                                                <div class="state p-info">
                                                    <label>Fue Cliente</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Walk-In" />
                                                <div class="state p-info">
                                                    <label>Walk-In</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Facebook" />
                                                <div class="state p-info">
                                                    <label>Facebook</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Tarjeta" />
                                                <div class="state p-info">
                                                    <label>Tarjeta</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Internet" />
                                                <div class="state p-info">
                                                    <label>Internet</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Instagram" />
                                                <div class="state p-info">
                                                    <label>Instagram</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Youtube" />
                                                <div class="state p-info">
                                                    <label>Youtube</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Tiktok" />
                                                <div class="state p-info">
                                                    <label>Tiktok</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Google" />
                                                <div class="state p-info">
                                                    <label>Google</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Otro" />
                                                <div class="state p-info">
                                                    <label>Otro</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div id="informacion-beneficiario" class="mb-5">
                            <h3>INFORMACIÓN DEL BENEFICIARIO (A):</h3>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-sm-6 col-form-label">¿Posee A-Number?</label>
                                        <div class="col-sm-6">
                                            <div class="pretty p-default p-curve">
                                                <input type="radio" name="posee_a_number" class="muestraMasInformacion" data-target="#container-a_number" value="Si" data-display="1" />
                                                <div class="state p-success-o">
                                                    <label>Si</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-curve">
                                                <input type="radio" name="posee_a_number" class="muestraMasInformacion" data-target="#container-a_number" value="No" data-display="0" checked />
                                                <div class="state p-primary-o">
                                                    <label>No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="container-a_number" class="row" hidden>
                                        <label class="col-sm-6 col-form-label">A-Number</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="a_number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label for="Ciudadanía">Ciudadanía</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column-reverse">
                                        <select name="nationality" id="cbCuidadania" class="comboPaises form-select select2" required></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-sm-6 col-form-label">¿Posee alguna segunda nacionalidad?</label>
                                        <div class="col-sm-6">
                                            <div class="pretty p-default p-curve">
                                                <input type="radio" name="radio-nacionalidad" class="muestraMasInformacion" data-target="#container-nacionalidad" value="Si" data-display="1" />
                                                <div class="state p-success-o">
                                                    <label>Si</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-curve">
                                                <input type="radio" name="radio-nacionalidad" class="muestraMasInformacion" data-target="#container-nacionalidad" value="No" data-display="0" checked />
                                                <div class="state p-primary-o">
                                                    <label>No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="container-nacionalidad" class="row" hidden>
                                        <label class="col-sm-6 col-form-label">Nacionalidad</label>
                                        <div class="col-sm-6">
                                            <select id="cbNacionalidad" name="segunda_nacionalidad" class="form-select">
                                                <option value="" selected disabled></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nombre Completo</label>
                                <input type="hidden" name="beneficiario_nombre">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="name1" placeholder="Primer Nombre" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="name2" placeholder="Segundo Nombre">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="name3" placeholder="Apellidos" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Género</label>
                                <div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_genero" value="Masculino" required>
                                        <div class="state p-primary-o">
                                            <label>Masculino</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_genero" value="Femenino">
                                        <div class="state p-primary-o">
                                            <label>Femenino</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_genero" value="Prefiero no responder">
                                        <div class="state p-primary-o">
                                            <label>Prefiero no responder</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row gap-3 mb-3">
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">Fecha de Nacimiento</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa-duotone fa-calendar"></i>
                                            </span>
                                            <div class="d-flex flex-column flex-column">
                                                <input type="text" class="form-control flatpickr" id="input-fechaNacimiento" name="beneficiario_fecha_nacimiento" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div id="container-menorEdad" hidden>
                                        <label class="form-label">¿Si es menor de 21, vive con ambos padres?</label>
                                        <div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="beneficiario_vive_ambos_padres" value="1">
                                                <div class="state p-primary-o">
                                                    <label>Si</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="beneficiario_vive_ambos_padres" value="0">
                                                <div class="state p-primary-o">
                                                    <label>No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Ciudad de Nacimiento</label>
                                    <input type="text" class="form-control" name="beneficiario_ciudad" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Estado de Nacimiento</label>
                                    <input type="text" class="form-control" name="beneficiario_estado" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">País de Nacimiento</label>
                                    <div class="d-flex flex-column-reverse">
                                        <select name="beneficiario_pais" id="cbPaisNacimiento" class="comboPaises form-select select2" required></select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Estado Civil</label>
                                <div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_estado_civil" value="Married" checked>
                                        <div class="state p-primary-o">
                                            <label>Casado</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_estado_civil" value="Divorced">
                                        <div class="state p-primary-o">
                                            <label>Divorciado</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_estado_civil" value="Widowed">
                                        <div class="state p-primary-o">
                                            <label>Viudo</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_estado_civil" value="Single">
                                        <div class="state p-primary-o">
                                            <label>Soltero</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">¿Para quién es este proceso?</label>
                                        <div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="proceso" class="muestraMasInformacion" data-target="#container-proceso" value="Usted" data-display="0" checked>
                                                <div class="state p-primary-o">
                                                    <label>Usted</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="proceso" class="muestraMasInformacion" data-target="#container-proceso" value="Alguien más" data-display="1">
                                                <div class="state p-primary-o">
                                                    <label>Alguien más</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="container-proceso" class="mb-3" hidden>
                                        <label class="form-label">Si es para alguien más, cual es la relación</label>
                                        <select name="proceso_relacion" class="form-select select2 cbParentescos"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <fieldset>
                                    <legend>Dirección</legend>
                                    <div class="mb-3">
                                        <label class="form-label">Calle y Número</label>
                                        <input type="text" class="form-control" name="direccion_calle_numero" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Ciudad</label>
                                        <input type="text" class="form-control" name="direccion_ciudad" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">País</label>
                                        <div class="d-flex flex-column-reverse">
                                            <select name="direccion_pais" id="" class="form-select" required>
                                                <option value="EEUU" selected>EEUU</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Código Postal</label>
                                        <input type="text" class="form-control" name="direccion_cp" required>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" name="direccion_telefono" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="direccion_email" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Mejor opción para contactarlo</label>
                                <div class="mt-2">
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="contacto" value="Llamada" checked>
                                        <div class="state p-primary-o">
                                            <label>Llamada</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="contacto" value="Mensaje">
                                        <div class="state p-primary-o">
                                            <label>Mensaje</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="contacto" value="Correo">
                                        <div class="state p-primary-o">
                                            <label>Correo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Horario de contacto preferido</label>
                                <select id="horarioContacto" name="horario_contacto" class="form-select" required>
                                    <option value="manana" selected>Mañana (9:00 AM - 12:00 PM)</option>
                                    <option value="tarde">Tarde (1:00 PM - 5:00 PM)</option>
                                    <!-- Puedes agregar más opciones de horarios según tus necesidades -->
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div id="preguntas">
                            <h3>PREGUNTAS DE INMIGRACIÓN PARA EL (LA) BENEFICIARIO(A):</h3>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">¿Cómo entró a EEUU?</label>
                                        <div class="mt-2">
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="como_entro_eeuu" class="muestraMasInformacion" data-target="#container-visa" value="Con Visa" data-display="1">
                                                <div class="state p-primary-o">
                                                    <label>Con Visa</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="como_entro_eeuu" class="muestraMasInformacion" data-target="#container-visa" value="Sin Visa" data-display="0" checked>
                                                <div class="state p-primary-o">
                                                    <label>Sin Visa</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="como_entro_eeuu" class="muestraMasInformacion" data-target="#container-visa" value="Con parole" data-display="0">
                                                <div class="state p-primary-o">
                                                    <label>Con parole</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="container-visa" hidden>
                                        <label class="form-label">Si entró Con Visa, cual es el tipo de Visa</label>
                                        <select name="tipo_visa" id="cbTipoVisa" class="form-select select2"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Estatus migratorio actual</label>
                                <div class="d-flex flex-md-column-reverse">
                                    <select name="estatus_migratorio_actual" class="form-select select2 cbEstatusMigratorio" required></select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fecha de última entrada a los Estados Unidos</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-duotone fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control flatpickr" id="input-fechaUltimaEntradaUSA" name="fecha_ultima_entrada" readonly required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">¿Alguna vez han sometido una solicitud migratoria en beneficio
                                    suyo?</label>
                                <div class="mt-2">
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="solicitud_migratoria" class="muestraMasInformacion" data-target="#container-peticionado" value="Si" data-display="1">
                                        <div class="state p-primary-o">
                                            <label>Si</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="solicitud_migratoria" class="muestraMasInformacion" data-target="#container-peticionado" value="No" data-display="0" checked>
                                        <div class="state p-primary-o">
                                            <label>No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="container-peticionado" class="mb-3" hidden>
                                <label class="form-label">Si es así, explique quién, cuando, y los resultados</label>
                                <textarea class="form-control" name="solicitud_migratoria_explicacion"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">¿Está actualmente en un proceso de inmigración?</label>
                                <div class="mt-2">
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="proceso_migracion" class="muestraMasInformacion" data-target="#container-procesoMigracion" value="Si" data-display="1">
                                        <div class="state p-primary-o">
                                            <label>Si</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="proceso_migracion" class="muestraMasInformacion" data-target="#container-procesoMigracion" value="No" data-display="0" checked>
                                        <div class="state p-primary-o">
                                            <label>No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="container-procesoMigracion" class="mb-3" hidden>
                                <label class="form-label">Si es así, explique</label>
                                <textarea class="form-control" name="proceso_migracion_explicacion"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Por favor seleccione a sus parientes que sean ciudadanos americanos o
                                    residentes
                                    legales de Estados Unidos</label>
                                <div class="mt-2">
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="parientes" value="Hijo(a)" />
                                        <div class="state p-info">
                                            <label>Hijo(a)</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="parientes" value="Esposo(a)" />
                                        <div class="state p-info">
                                            <label>Esposo(a)</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="parientes" value="Hermano(a)" />
                                        <div class="state p-info">
                                            <label>Hermano(a)</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="parientes" value="Padre / Madre" />
                                        <div class="state p-info">
                                            <label>Padre / Madre</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">¿Tiene algún familiar en el servicio militar?</label>
                                        <div class="mt-2">
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="familiar_servicio" class="muestraMasInformacion" data-target="#container-servicioMilitar" value="Si" data-display="1">
                                                <div class="state p-primary-o">
                                                    <label>Si</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="familiar_servicio" class="muestraMasInformacion" data-target="#container-servicioMilitar" value="No" data-display="0" checked>
                                                <div class="state p-primary-o">
                                                    <label>No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="container-servicioMilitar" class="col-md-6" hidden>
                                    <div>
                                        <label class="form-label">Si es así, por favor díganos el parentesco con usted:</label>
                                        <select name="familiar_servicio_parentesco" class="form-select select2 cbParentescos">
                                            <option value="" selected disabled>Selecciona una opción</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">¿Ha sido alguna vez victima de un crimen?</label>
                                <div class="mt-2">
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="victima_crimen" class="muestraMasInformacion" data-target="#container-victimaCrimen" value="Si" data-display="1">
                                        <div class="state p-primary-o">
                                            <label>Si</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="victima_crimen" class="muestraMasInformacion" data-target="#container-victimaCrimen" value="No" data-display="0" checked>
                                        <div class="state p-primary-o">
                                            <label>No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="container-victimaCrimen" class="mb-3" hidden>
                                <label class="form-label">Lugar, fecha, y tipo de delito</label>
                                <textarea class="form-control" name="victima_crimen_info"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">¿En el contexto de migración ha cometido algún crimen en Estados Unidos,
                                    alguna
                                    vez a usted le han tomado?</label>
                                <div class="pretty-container mt-2">
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Huellas">
                                        <div class="state p-info">
                                            <label>Huellas </label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Pedido que se regrese de la frontera">
                                        <div class="state p-info">
                                            <label>Pedido que se regrese de la frontera </label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Visto un juez de migración">
                                        <div class="state p-info">
                                            <label>Visto un juez de migración </label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Fotografías">
                                        <div class="state p-info">
                                            <label>Fotografías </label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Visto a un oficial de migración">
                                        <div class="state p-info">
                                            <label>Visto a un oficial de migración </label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Pedidos que firme algún documento">
                                        <div class="state p-info">
                                            <label>Pedidos que firme algún documento </label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Concedido salida voluntaria">
                                        <div class="state p-info">
                                            <label>Concedido salida voluntaria </label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Deportado">
                                        <div class="state p-info">
                                            <label>Deportado </label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Arresto o detención en la frontera">
                                        <div class="state p-info">
                                            <label>Arresto o detención en la frontera</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">¿Alguna vez ha sido arrestado por CUALQUIER crimen?</label>
                                <div class="mt-2">
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="arrestado" class="muestraMasInformacion" data-target="#container-arresto" value="Si" data-display="1">
                                        <div class="state p-primary-o">
                                            <label>Si</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="arrestado" class="muestraMasInformacion" data-target="#container-arresto" value="No" data-display="0" checked>
                                        <div class="state p-primary-o">
                                            <label>No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="container-arresto" hidden>
                                <div class="mb-3">
                                    <label class="form-label">Fecha y Cargo</label>
                                    <input type="text" class="form-control" name="arrestado_fecha_cargo">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Si es más de un arresto, por favor explique</label>
                                    <input type="text" class="form-control" name="arrestado_explicacion">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div id="peticionario">
                            <h3>Información de Peticionario:</h3>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nombre Completo</label>
                                        <input type="text" class="form-control" name="peticionario_nombre" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" name="peticionario_telefono" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Relación</label>
                                    <input type="text" class="form-control" name="peticionario_relacion" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="peticionario_direccion" required>
                            </div>

                            <h3>Especifique el motivo de su visita:</h3>
                            <textarea cols="30" rows="5" class="form-control" name="motivo_visita" required></textarea>
                        </div>
                        <!-- Agregar input para adjuntar documentos -->
                        <div class="mb-3 mt-4">
                            <label for="documentosAdjuntos" class="form-label">Adjuntar Documentos</label>
                            <input type="file" class="form-control" id="documentosAdjuntos" name="documentos[]" multiple>
                            <small class="text-muted">Puede adjuntar múltiples documentos. (Formatos aceptados: PDF, JPG, PNG)</small>
                        </div>
                        <hr>
                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-lg btn-primary">Enviar</button>
                        </div>
                    </div>
                </div>`
            </form>
        </div>
    </div>
    </div>
    </div>
    <script>
        const Cliente = <?= json_encode($cliente) ?>;
        const Sucursal = <?= json_encode($sucursal) ?>;
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js" integrity="sha512-v0vjOquuhHQslRkq1a5BwUIyKSD7ZbgFfQv4jzSBGwbIVTCOs5JQdotZVoRjPRzb9UToTvuP2kdR5CVE4TLgMw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?= base_url("js/intake.js") ?>"></script>

</body>

</html>