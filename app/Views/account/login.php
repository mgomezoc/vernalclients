<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <title>Log in | Intake</title>
    <meta name="description" content="Intake Abogado Vernal">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="icon.png">

    <link rel="stylesheet" href="<?= base_url("css/normalize.css") ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url("css/style.css") ?>">
    <link rel="stylesheet" href="<?= base_url("css/login.css") ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://kit.fontawesome.com/d179c845aa.js" crossorigin="anonymous"></script>

    <link rel="manifest" href="site.webmanifest">
    <meta name="theme-color" content="#fafafa">
    <script src="https://www.google.com/recaptcha/api.js?render=6Lec0ccnAAAAAKFUlFpz2MPD2ZjV2YKC14-0l0KV"></script>
    <script>
        const baseUrl = "<?= base_url() ?>";
    </script>
</head>

<body>

    <div class="login">
        <div class="login-col">
            <div class="login-wrapper">
                <div class="login-content">
                    <img src="<?= base_url("img/logo-vernal-black.svg") ?>" alt="logo" class="login-logo" width="240px">

                    <form id="frmLogin" action="login" method="post" class="w-100">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="correo_electronico" value="<?= old('correo_electronico') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="contrasena" required>
                                <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                                    <i class="fa fa-eye" id="icon-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div id="recaptchaContainer"></div>
                        <input type="hidden" id="recaptchaToken" name="recaptchaToken">
                        <div>
                            <button class="btn w-100 btn-primary">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url("js/vendor/modernizr-3.12.0.min.js") ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js" integrity="sha512-v0vjOquuhHQslRkq1a5BwUIyKSD7ZbgFfQv4jzSBGwbIVTCOs5JQdotZVoRjPRzb9UToTvuP2kdR5CVE4TLgMw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url("js/app.js") ?>"></script>
    <script src="<?= base_url("js/login.js") ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/localforage/1.9.0/localforage.min.js"></script>

    <script>
        // Mostrar / Ocultar Contraseña
        $(document).ready(function() {
            $('#togglePassword').click(function() {
                const passwordField = $('#password');
                const passwordFieldType = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', passwordFieldType);

                const icon = $(this).find('#icon-eye');
                icon.toggleClass('fa-eye fa-eye-slash');
            });

            // Almacenar y recuperar correo electrónico usando localForage
            localforage.getItem('lastEmail').then(function(value) {
                if (value) {
                    $('#email').val(value);
                }
            });

            $('#frmLogin').submit(function() {
                const email = $('#email').val();
                localforage.setItem('lastEmail', email);
            });
        });
    </script>
</body>

</html>