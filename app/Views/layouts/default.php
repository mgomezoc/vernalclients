<?php

use Config\Profiles;

$profileConfig = new Profiles();
$menus = $profileConfig->menus[$perfil] ?? [];
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title><?= $this->renderSection('title') ?> - Intake</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="<?= $this->renderSection('description') ?>">
    <link rel="stylesheet" href="<?= base_url("css/normalize.css") ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.24.1/bootstrap-table.min.css" integrity="sha512-CPL36V8ZD92nblUPfrYxCPKrlykPHIsP6dp3C/9xXchzL84rSnDdyFeXnFEoTveGFxl5Ucamm4qHR8LynUTKdg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url("css/style.css?v=" . config('App')->assetVersion) ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600&family=Ubuntu:wght@300;400;500;700&display=swap">
    <link rel="apple-touch-icon" href="<?= base_url("apple-touch-icon.png") ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url("favicon-32x32.png") ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("favicon-16x16.png") ?>">
    <link rel="manifest" href="<?= base_url("site.webmanifest") ?>">
    <link rel="mask-icon" href="<?= base_url("safari-pinned-tab.svg") ?>" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

    <?= $this->renderSection('styles') ?>

    <script src="https://kit.fontawesome.com/901438e2f4.js" crossorigin="anonymous"></script>
    <script>
        const baseUrl = "<?= base_url() ?>";
        const usuario = <?= json_encode($usuario) ?>;
    </script>
</head>

<body>
    <div class="layout">
        <div class="layout-col menu">
            <div class="menu">
                <div class="menu-top">
                    <a href="<?= base_url('/') ?>" class="menu-logo">
                        <img src="<?= base_url("img/logo.svg") ?>" alt="VERNAL" class="menu-logo-img">
                    </a>
                    <div class="menu-top-info">
                        <div><?= esc($usuario["nombre"]) ?> <?= esc($usuario["apellido_paterno"]) ?></div>
                        <div><?= esc($usuario["correo_electronico"]) ?></div>
                    </div>
                </div>

                <div class="menu-options">
                    <a href="<?= base_url("/") ?>" class="menu-link" data-menu="/">
                        <div class="icon-container"><i class="fa-duotone fa-house-chimney icon"></i></div>
                        <span>Inicio</span>
                    </a>

                    <?php foreach ($menus as $menu): ?>
                        <a href="<?= base_url($menu['url']) ?>" class="menu-link" data-menu="<?= $menu['url'] ?>">
                            <div class="icon-container">
                                <i class="<?= esc($menu['icon']) ?>"></i>
                            </div>
                            <span><?= esc($menu['label']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="menu-footer">
                    <a href="<?= base_url('cuenta') ?>" class="menu-link">
                        <div class="icon-container"><i class="fa-duotone fa-user-gear"></i></div>
                        <span>Cuenta</span>
                    </a>
                    <form action="<?= base_url("salir") ?>" method="post">
                        <button class="menu-link">
                            <div class="icon-container"><i class="fa-duotone fa-arrow-right-from-bracket"></i></div>
                            <span>Salir</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="layout-col main">
            <div id="buscador" class="buscador">
                <div class="buscador-container">
                    <div class="buscador-group">
                        <input type="text" id="search" class="buscador-input" placeholder="Buscar casos o clientes...">
                        <i class="fa-sharp fa-solid fa-user-magnifying-glass"></i>
                    </div>
                    <div id="results" class="buscador-resultados"></div>
                </div>
            </div>

            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <?= $this->renderSection('modals') ?>

    <template id="tplResultados">
        <ul class="list-group list-group-flush">
            {{#if casos}}
                <li class="list-group-item disabled">
                    CASOS
                </li>
                {{#each casos}}
                    <a href="<?= base_url("/") ?>clientes/{{id_cliente}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                        <div class="mb-1">Caso #{{id_caso}}: {{proceso}}</div>
                        <small>Creado: {{formatFecha fecha_creacion}}</small>
                    </a>
                {{/each}}
            {{/if}}
        </ul>
        {{#if clientes}}
            <ul class="list-group list-group-flush">
                <li class="list-group-item disabled">
                    CLIENTES
                </li>
                {{#each clientes}}
                    <a href="<?= base_url("/") ?>clientes/{{id_cliente}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                        <div class="mb-1">{{nombre}}</div>
                        <small class="mb-1">Teléfono: {{telefono}}</small>
                    </a>
                {{/each}}
            </ul>
        {{/if}}
    </template>

    <script src="<?= base_url("js/vendor/modernizr-3.12.0.min.js") ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.24.1/bootstrap-table.min.js" integrity="sha512-SluUb5Wij76laheDMpw6UZXUuvefcSa3wbeMZoAzEwc8Fe9aVqUwAhG1n2FPDnZh8bExgmx5H6N3k2xzrd1nuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url("js/app.js?v=" . config('App')->assetVersion) ?>"></script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>