<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>Admission Form</title>
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
                    Welcome <b><?= $cliente["nombre"] ?></b> to VFM Law Firm, we hope to assist you with your legal needs.
                    To better assist you, please answer the following questions completely and
                    accurately. This information is confidential and will not be shared with anyone
                    outside of VFM Law Firm.
                </p>
            </div>
            <div class="text-end">
                <a href="<?= base_url("intake/" . $cliente['slug']) ?>" class="btn btn-outline-light btn-sm" style="margin-top: 10px;">
                    <i class="fas fa-language"></i> Versión en Español
                </a>
            </div>

        </div>
    </header>

    <div class="container">
        <div id="mensajeCorrecto" class="row hide my-5">
            <div class="col-12">
                <div class="card card-body text-center">
                    <h2 class="mb-3">Thank you for choosing "The Law Office of Vernal Farnum Mejia"</h2>
                    <p class="mb-5">
                        For your immigration procedures. We wish to provide you with humane, honest, and effective service. Additionally, we want your visit to our office to be as pleasant as possible. Therefore, to better evaluate your immigration case, please consider the following recommendations.
                    </p>

                    <div class="row mb-5">
                        <div class="col-md-6">
                            <dotlottie-player src="https://lottie.host/a41589ca-1f46-43bb-be29-3fea83c6f622/LbMgvaHcKO.json" background="transparent" speed="1" style="width: 300px; height: 300px;margin:0 auto" loop autoplay></dotlottie-player>
                        </div>
                        <div class="col-md-6">
                            <h3>You must bring with you:</h3>
                            <ol class="list-group list-group-flush list-group-numbered text-start">
                                <li class="list-group-item">ID from your country of origin.</li>
                                <li class="list-group-item">Immigration Court documents.</li>
                                <li class="list-group-item">Border detention reports.</li>
                                <li class="list-group-item">Receipts of submitted immigration processes.</li>
                                <li class="list-group-item">Police reports</li>
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

                    <p>We also remind you that if you need to be accompanied, we allow a maximum of 2 people as we follow Health Department recommendations.</p>
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
                            <h3>GENERAL INFORMATION:</h3>
                            <div class="container-fluid">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="row justify-content-center align-content-center">
                                            <label class="col-sm-3 col-form-label">Consultation Date:</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="fecha_creado" value="<?= $fechaSimple ?>" class="form-control-plaintext" title='<?= $fechaTitle ?>' readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cbSucursales">Branch Office</label>
                                        <div class="d-flex flex-column-reverse">
                                            <select id="cbSucursales" name="sucursal" class="form-select select2" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="row justify-content-center align-items-center">
                                            <label class="col-sm-6 col-form-label">Is this your first consultation here?</label>
                                            <div class="col-sm-6">
                                                <div class="pretty p-default p-curve">
                                                    <input type="radio" name="es_primera_consulta" class="muestraMasInformacion" data-target="#container-primeraConsulta" value="Si" data-display="0" checked />
                                                    <div class="state p-success-o">
                                                        <label>Yes</label>
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
                                            <label class="col-sm-6 col-form-label">Do you remember your last consultation date?</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control flatpickr" name="fecha_ultima_consulta">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-sm-3 col-form-label">How did you hear about our service?</label>
                                    <div class="col-sm-9">
                                        <div class="pretty-container">
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Friends" />
                                                <div class="state p-info">
                                                    <label>Friends</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Family" />
                                                <div class="state p-info">
                                                    <label>Family</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Former Client" />
                                                <div class="state p-info">
                                                    <label>Former Client</label>
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
                                                <input type="checkbox" name="fuente_informacion" value="Business Card" />
                                                <div class="state p-info">
                                                    <label>Business Card</label>
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
                                                <input type="checkbox" name="fuente_informacion" value="YouTube" />
                                                <div class="state p-info">
                                                    <label>YouTube</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="TikTok" />
                                                <div class="state p-info">
                                                    <label>TikTok</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Google" />
                                                <div class="state p-info">
                                                    <label>Google</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-thick">
                                                <input type="checkbox" name="fuente_informacion" value="Other" />
                                                <div class="state p-info">
                                                    <label>Other</label>
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
                            <h3>BENEFICIARY INFORMATION:</h3>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-sm-6 col-form-label">Do you have an A-Number?</label>
                                        <div class="col-sm-6">
                                            <div class="pretty p-default p-curve">
                                                <input type="radio" name="posee_a_number" class="muestraMasInformacion" data-target="#container-a_number" value="Si" data-display="1" />
                                                <div class="state p-success-o">
                                                    <label>Yes</label>
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
                                    <label for="Ciudadanía">Citizenship</label>
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
                                        <label class="col-sm-6 col-form-label">Do you have a second nationality?</label>
                                        <div class="col-sm-6">
                                            <div class="pretty p-default p-curve">
                                                <input type="radio" name="radio-nacionalidad" class="muestraMasInformacion" data-target="#container-nacionalidad" value="Yes" data-display="1" />
                                                <div class="state p-success-o">
                                                    <label>Yes</label>
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
                                        <label class="col-sm-6 col-form-label">Nationality</label>
                                        <div class="col-sm-6">
                                            <select id="cbNacionalidad" name="segunda_nacionalidad" class="form-select">
                                                <option value="" selected disabled></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="hidden" name="beneficiario_nombre">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="name1" placeholder="First Name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="name2" placeholder="Middle Name">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="name3" placeholder="Last Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_genero" value="Masculino" required>
                                        <div class="state p-primary-o">
                                            <label>Male</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_genero" value="Femenino">
                                        <div class="state p-primary-o">
                                            <label>Female</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_genero" value="Prefiero no responder">
                                        <div class="state p-primary-o">
                                            <label>Prefer not to answer</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row gap-3 mb-3">
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">Date of Birth</label>
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
                                        <label class="form-label">If under 21, do you live with both parents?</label>
                                        <div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="beneficiario_vive_ambos_padres" value="Si">
                                                <div class="state p-primary-o">
                                                    <label>Yes</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="beneficiario_vive_ambos_padres" value="No">
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
                                    <label class="form-label">City of Birth</label>
                                    <input type="text" class="form-control" name="beneficiario_ciudad" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State of Birth</label>
                                    <input type="text" class="form-control" name="beneficiario_estado" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Country of Birth</label>
                                    <div class="d-flex flex-column-reverse">
                                        <select name="beneficiario_pais" id="cbPaisNacimiento" class="comboPaises form-select select2" required></select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Marital Status</label>
                                <div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_estado_civil" value="Married" checked>
                                        <div class="state p-primary-o">
                                            <label>Married</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_estado_civil" value="Divorced">
                                        <div class="state p-primary-o">
                                            <label>Divorced</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_estado_civil" value="Widowed">
                                        <div class="state p-primary-o">
                                            <label>Widowed</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="beneficiario_estado_civil" value="Single">
                                        <div class="state p-primary-o">
                                            <label>Single</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Who is this process for?</label>
                                        <div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="proceso" class="muestraMasInformacion" data-target="#container-proceso" value="Usted" data-display="0" checked>
                                                <div class="state p-primary-o">
                                                    <label>Yourself</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="proceso" class="muestraMasInformacion" data-target="#container-proceso" value="Alguien más" data-display="1">
                                                <div class="state p-primary-o">
                                                    <label>Someone else</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="container-proceso" class="mb-3" hidden>
                                        <label class="form-label">If for someone else, what is the relationship?</label>
                                        <select name="proceso_relacion" class="form-select select2 cbParentescos"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <fieldset>
                                    <legend>Address</legend>
                                    <div class="mb-3">
                                        <label class="form-label">Street and Number</label>
                                        <input type="text" class="form-control" name="direccion_calle_numero" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">City</label>
                                        <input type="text" class="form-control" name="direccion_ciudad" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">State</label>
                                        <input type="text" class="form-control" name="direccion_estado" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Country</label>
                                        <div class="d-flex flex-column-reverse">
                                            <select name="direccion_pais" id="" class="form-select" required>
                                                <option value="USA" selected>USA</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Zip Code</label>
                                        <input type="text" class="form-control" name="direccion_cp" required>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">Phone</label>
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
                                <label class="form-label">Best way to contact you</label>
                                <div class="mt-2">
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="contacto" value="Call" checked>
                                        <div class="state p-primary-o">
                                            <label>Call</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="contacto" value="Message">
                                        <div class="state p-primary-o">
                                            <label>Message</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="contacto" value="Email">
                                        <div class="state p-primary-o">
                                            <label>Email</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Preferred contact time</label>
                                <select id="horarioContacto" name="horario_contacto" class="form-select" required>
                                    <option value="morning" selected>Morning (9:00 AM - 12:00 PM)</option>
                                    <option value="afternoon">Afternoon (1:00 PM - 5:00 PM)</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div id="preguntas">
                            <h3>IMMIGRATION QUESTIONS FOR THE BENEFICIARY:</h3>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">How did you enter the USA?</label>
                                        <div class="mt-2">
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="como_entro_eeuu" class="muestraMasInformacion" data-target="#container-visa" value="Con Visa" data-display="1">
                                                <div class="state p-primary-o">
                                                    <label>With Visa</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="como_entro_eeuu" class="muestraMasInformacion" data-target="#container-visa" value="Sin Visa" data-display="0" checked>
                                                <div class="state p-primary-o">
                                                    <label>Without Visa</label>
                                                </div>
                                            </div>
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="como_entro_eeuu" class="muestraMasInformacion" data-target="#container-visa" value="Con parole" data-display="0">
                                                <div class="state p-primary-o">
                                                    <label>With Parole</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="container-visa" hidden>
                                        <label class="form-label">If entered With Visa, what type?</label>
                                        <select name="tipo_visa" id="cbTipoVisa" class="form-select select2"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Current immigration status</label>
                                <div class="d-flex flex-md-column-reverse">
                                    <select name="estatus_migratorio_actual" class="form-select select2 cbEstatusMigratorio" required></select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date of last entry to the United States</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-duotone fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control flatpickr" id="input-fechaUltimaEntradaUSA" name="fecha_ultima_entrada" readonly required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Has an immigration petition ever been filed on your behalf?</label>
                                <div class="mt-2">
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="solicitud_migratoria" class="muestraMasInformacion" data-target="#container-peticionado" value="Si" data-display="1">
                                        <div class="state p-primary-o">
                                            <label>Yes</label>
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
                                <label class="form-label">If yes, explain who, when, and results</label>
                                <textarea class="form-control" name="solicitud_migratoria_explicacion"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Are you currently in an immigration process?</label>
                                <div class="mt-2">
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="proceso_migracion" class="muestraMasInformacion" data-target="#container-procesoMigracion" value="Si" data-display="1">
                                        <div class="state p-primary-o">
                                            <label>Yes</label>
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
                                <label class="form-label">If yes, explain</label>
                                <textarea class="form-control" name="proceso_migracion_explicacion"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Please select relatives who are US citizens or legal permanent residents</label>
                                <div class="mt-2">
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="parientes" value="Hijo(a)" />
                                        <div class="state p-info">
                                            <label>Child</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="parientes" value="Esposo(a)" />
                                        <div class="state p-info">
                                            <label>Spouse</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="parientes" value="Hermano(a)" />
                                        <div class="state p-info">
                                            <label>Sibling</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="parientes" value="Padre / Madre" />
                                        <div class="state p-info">
                                            <label>Parent</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div>
                                        <label class="form-label">Do you have any family in military service?</label>
                                        <div class="mt-2">
                                            <div class="pretty p-default p-round">
                                                <input type="radio" name="familiar_servicio" class="muestraMasInformacion" data-target="#container-servicioMilitar" value="Si" data-display="1">
                                                <div class="state p-primary-o">
                                                    <label>Yes</label>
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
                                        <label class="form-label">If yes, what is their relationship to you?</label>
                                        <select name="familiar_servicio_parentesco" class="form-select select2 cbParentescos">
                                            <option value="" selected disabled>Select an option</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Have you ever been a victim of a crime?</label>
                                <div class="mt-2">
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="victima_crimen" class="muestraMasInformacion" data-target="#container-victimaCrimen" value="Si" data-display="1">
                                        <div class="state p-primary-o">
                                            <label>Yes</label>
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
                                <label class="form-label">Location, date, and type of crime</label>
                                <textarea class="form-control" name="victima_crimen_info"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    In the context of immigration, have you ever committed any crime in the United States, or have you ever had the following?
                                </label>
                                <div class="pretty-container mt-2">
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Huellas">
                                        <div class="state p-info">
                                            <label>Fingerprints taken</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Pedido que se regrese de la frontera">
                                        <div class="state p-info">
                                            <label>Requested to return from border</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Visto un juez de migración">
                                        <div class="state p-info">
                                            <label>Seen immigration judge</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Fotografías">
                                        <div class="state p-info">
                                            <label>Photographs taken</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Visto a un oficial de migración">
                                        <div class="state p-info">
                                            <label>Met with immigration officer</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Pedidos que firme algún documento">
                                        <div class="state p-info">
                                            <label>Asked to sign documents</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Concedido salida voluntaria">
                                        <div class="state p-info">
                                            <label>Granted voluntary departure</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Deportado">
                                        <div class="state p-info">
                                            <label>Deported</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-default">
                                        <input type="checkbox" name="cometido_crimen" value="Arresto o detención en la frontera">
                                        <div class="state p-info">
                                            <label>Border arrest or detention</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Have you ever been arrested for ANY crime?</label>
                                <div class="mt-2">
                                    <div class="pretty p-default p-round">
                                        <input type="radio" name="arrestado" class="muestraMasInformacion" data-target="#container-arresto" value="Si" data-display="1">
                                        <div class="state p-primary-o">
                                            <label>Yes</label>
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
                                    <label class="form-label">Date and Charge</label>
                                    <input type="text" class="form-control" name="arrestado_fecha_cargo">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">If more than one arrest, please explain</label>
                                    <input type="text" class="form-control" name="arrestado_explicacion">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div id="peticionario">
                            <h3>Petitioner Information:</h3>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" name="peticionario_nombre" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="peticionario_telefono" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Relationship</label>
                                    <input type="text" class="form-control" name="peticionario_relacion" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Address</label>
                                <input type="text" class="form-control" name="peticionario_direccion" required>
                            </div>

                            <h3>Specify the purpose of your visit:</h3>
                            <textarea cols="30" rows="5" class="form-control" name="motivo_visita" required></textarea>
                        </div>
                        <!-- Add input for document attachment -->
                        <div class="mb-3 mt-4">
                            <label for="documentosAdjuntos" class="form-label">Attach Documents</label>
                            <input type="file" class="form-control" id="documentosAdjuntos" name="archivo" accept=".pdf,.jpg,.jpeg,.png">
                            <small class="text-muted">You can attach a document in PDF, JPG or PNG format.</small>
                        </div>
                        <hr>
                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const Cliente = <?= json_encode($cliente) ?>;
        const Sucursal = <?= json_encode($sucursal) ?>;
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.8/handlebars.min.js" integrity="sha512-E1dSFxg+wsfJ4HKjutk/WaCzK7S2wv1POn1RRPGh8ZK+ag9l244Vqxji3r6wgz9YBf6+vhQEYJZpSjqWFPg9gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js" integrity="sha512-v0vjOquuhHQslRkq1a5BwUIyKSD7ZbgFfQv4jzSBGwbIVTCOs5JQdotZVoRjPRzb9UToTvuP2kdR5CVE4TLgMw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?= base_url('js/app.js?v=1.0.1') ?>"></script>
    <script src="<?= base_url("js/intake_eng.js?v=1.0.3") ?>"></script>

</body>

</html>