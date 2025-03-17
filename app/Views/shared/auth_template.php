<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <title><?= $title ?? 'Auth | Vernal' ?></title>
    <meta name="description" content="Intake Abogado Vernal">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="<?= base_url('favicon.ico') ?>" sizes="any">
    <link rel="stylesheet" href="<?= base_url("css/normalize.css") ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url("css/style.css") ?>">
    <link rel="stylesheet" href="<?= base_url("css/login.css") ?>">
    <script src="https://kit.fontawesome.com/d179c845aa.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="login">
        <div class="login-col">
            <div class="login-wrapper">
                <div class="login-content">
                    <img src="<?= base_url("img/logo-vernal-black.svg") ?>" alt="logo" class="login-logo" width="240px">

                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/localforage/1.10.0/localforage.min.js" integrity="sha512-+BMamP0e7wn39JGL8nKAZ3yAQT2dL5oaXWr4ZYlTGkKOaoXM/Yj7c4oy50Ngz5yoUutAG17flueD4F6QpTlPng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>