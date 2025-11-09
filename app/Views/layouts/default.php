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

    <!-- Normalize CSS -->
    <link rel="stylesheet" href="<?= base_url("css/normalize.css") ?>">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- Bootstrap Table -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.24.1/bootstrap-table.min.css" integrity="sha512-CPL36V8ZD92nblUPfrYxCPKrlykPHIsP6dp3C/9xXchzL84rSnDdyFeXnFEoTveGFxl5Ucamm4qHR8LynUTKdg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600&family=Ubuntu:wght@300;400;500;700&display=swap">

    <!-- Estilos principales -->
    <link rel="stylesheet" href="<?= base_url("css/style.css?v=" . config('App')->assetVersion) ?>">

    <!-- NUEVO: Estilos responsive SCOPEADOS (evita colisiones con style.css) -->
    <link rel="stylesheet" href="<?= base_url("css/responsive-layout.css?v=" . config('App')->assetVersion) ?>">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="<?= base_url("apple-touch-icon.png") ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url("favicon-32x32.png") ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("favicon-16x16.png") ?>">
    <link rel="manifest" href="<?= base_url("site.webmanifest") ?>">
    <link rel="mask-icon" href="<?= base_url("safari-pinned-tab.svg") ?>" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

    <?= $this->renderSection('styles') ?>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/901438e2f4.js" crossorigin="anonymous"></script>

    <!-- Variables globales JavaScript -->
    <script>
        const baseUrl = "<?= base_url() ?>";
        const usuario = <?= json_encode($usuario) ?>;
    </script>
</head>

<body data-layout="responsive">
    <!-- Overlay para móviles (se crea vía JS pero puede pre-cargarse aquí) -->

    <div class="layout">
        <!-- Sidebar / Menú -->
        <div class="layout-col menu">
            <div class="menu">
                <!-- Header del menú -->
                <div class="menu-top">
                    <a href="<?= base_url('/') ?>" class="menu-logo">
                        <img src="<?= base_url("img/logo.svg") ?>" alt="VERNAL" class="menu-logo-img">
                    </a>
                    <div class="menu-top-info">
                        <div><?= esc($usuario["nombre"]) ?> <?= esc($usuario["apellido_paterno"]) ?></div>
                        <div><?= esc($usuario["correo_electronico"]) ?></div>
                    </div>
                </div>

                <!-- Opciones del menú -->
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

                <!-- Footer del menú -->
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

        <!-- Contenido principal -->
        <div class="layout-col main">
            <!-- Buscador -->
            <div id="buscador" class="buscador">
                <div class="buscador-container">
                    <div class="buscador-group">
                        <input type="text" id="search" class="buscador-input" placeholder="Buscar casos o clientes..." autocomplete="off">
                        <i class="fa-sharp fa-solid fa-user-magnifying-glass"></i>
                    </div>
                    <div id="results" class="buscador-resultados"></div>
                </div>
            </div>

            <!-- Contenido de la página -->
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Modales -->
    <?= $this->renderSection('modals') ?>

    <!-- Template para resultados de búsqueda -->
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
            {{#if clientes}}
                <li class="list-group-item disabled">
                    CLIENTES
                </li>
                {{#each clientes}}
                    <a href="<?= base_url("/") ?>clientes/{{id_cliente}}" class="list-group-item list-group-item-action">
                        {{nombre}} {{apellido_paterno}} {{apellido_materno}}
                    </a>
                {{/each}}
            {{/if}}
            {{#unless casos}}
                {{#unless clientes}}
                    <li class="list-group-item">
                        No se encontraron resultados
                    </li>
                {{/unless}}
            {{/unless}}
        </ul>
    </template>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-7aVQ8xHj2HKcdwwZ67rQW4yqRBpvAnIqfVOGEG4yc68OFZ5t9L4x7v6N8LyFgPvW" crossorigin="anonymous"></script>

    <!-- Bootstrap Table -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.24.1/bootstrap-table.min.js" integrity="sha512-HCLRl5aPwEw1Q2dP0vDmjBkfQYH7S8pq5M5vQaI6wLEdLRsEp4nGRZW9sJBaX/BGQqyT4OLkNcOUBNiGEUXF2w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Bootstrap Table Español -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.24.1/extensions/mobile/bootstrap-table-mobile.min.js" integrity="sha512-1YDV2fLsOdDvH5IH7Ssc0AUWxOFWtJPvvnGvxH8x+b9/rZBMELSqgHGwOKKvUf7cDjXmFKkzR8PzVlhz9n+TJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Handlebars (para templates) -->
    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>

    <!-- NUEVO: Script de menú responsive -->
    <script src="<?= base_url("js/menu-responsive.js?v=" . config('App')->assetVersion) ?>"></script>

    <!-- Scripts de la aplicación -->
    <script src="<?= base_url("js/app.js?v=" . config('App')->assetVersion) ?>"></script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>