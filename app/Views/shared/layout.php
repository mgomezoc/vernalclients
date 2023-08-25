<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <title><?= isset($title) ? $title : "ADMIN" ?> - Intake</title>
    <meta name="description" content="<?= isset($description) ? $description : ""  ?>">
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
    <?= isset($styles) ? $styles : "" ?>


    <link rel="manifest" href="site.webmanifest">
    <meta name="theme-color" content="#fafafa">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d179c845aa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script>
        const baseUrl = "<?= base_url() ?>";
    </script>
</head>

<body>

    <div class="layout">
        <div class="layout-col menu">
            <div class="menu">
                <div class="menu-top">
                    <a href="#" class="menu-logo">
                        <img src="<?= base_url("img/logo.svg") ?>" alt="VERNAL" class="menu-logo-img">
                    </a>
                </div>
                <div class="menu-options">
                    <a href="<?= base_url("/") ?>" class="menu-link" data-menu="/">
                        <div class="icon-container">
                            <i class="fa-duotone fa-house-chimney icon fa-fade"></i>
                        </div>
                        <span>Inicio</span>
                    </a>
                    <a href="<?= base_url("/usuarios") ?>" class="menu-link" data-menu="usuarios">
                        <div class="icon-container">
                            <i class="fa-duotone fa-users fa-fade"></i>
                        </div>

                        <span>Usuarios</span>
                    </a>
                    <a href="<?= base_url("/sucursales") ?>" class="menu-link" data-menu="sucursales">
                        <div class="icon-container">
                            <i class="fa-duotone fa-file-chart-column"></i>
                        </div>

                        <span>Sucursales</span>
                    </a>
                    <a href="<?= base_url("/abogados") ?>" class="menu-link" data-menu="abogados">
                        <div class="icon-container">
                            <i class="fa-solid fa-gavel"></i>
                        </div>

                        <span>Abogados</span>
                    </a>
                    <a href="<?= base_url("/reportes") ?>" class="menu-link" data-menu="reportes">
                        <div class="icon-container">
                            <i class="fa-duotone fa-file-chart-column"></i>
                        </div>

                        <span>Reportes</span>
                    </a>
                </div>
                <div class="menu-footer">
                    <a href="#" class="menu-link">
                        <div class="icon-container">
                            <i class="fa-duotone fa-user-gear"></i>
                        </div>
                        <span>Cuenta</span>
                    </a>
                    <form action="salir" method="post">
                        <button class="menu-link">
                            <div class="icon-container">
                                <i class="fa-duotone fa-arrow-right-from-bracket"></i>
                            </div>
                            <span>Salir</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="layout-col main">
            <?= $renderBody ?>
        </div>
    </div>

    <script src="<?= base_url("js/vendor/modernizr-3.12.0.min.js") ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
    <script src="<?= base_url("js/app.js") ?>"></script>
    <?= isset($scripts) ? $scripts : "" ?>
</body>

</html>