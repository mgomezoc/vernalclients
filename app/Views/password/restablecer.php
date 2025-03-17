<?= $this->extend('shared/auth_template') ?>

<?= $this->section('content') ?>
<h2 class="text-center">Restablecer Contraseña</h2>
<p class="text-center">Ingresa una nueva contraseña para tu cuenta.</p>

<!-- Mensajes de error -->
<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
<?php endif; ?>

<form id="frmRestablecer" action="<?= site_url('password/actualizar') ?>" method="post">
    <input type="hidden" name="token" value="<?= esc($token) ?>">

    <div class="mb-3">
        <label for="password" class="form-label">Nueva Contraseña</label>
        <div class="input-group">
            <input type="password" class="form-control" name="password" required>
            <button type="button" class="btn btn-outline-secondary toggle-password">
                <i class="fa fa-eye"></i>
            </button>
        </div>
    </div>

    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
        <div class="input-group">
            <input type="password" class="form-control" name="confirm_password" required>
            <button type="button" class="btn btn-outline-secondary toggle-password">
                <i class="fa fa-eye"></i>
            </button>
        </div>
    </div>

    <button type="submit" class="btn btn-success w-100">Actualizar Contraseña</button>
</form>

<div class="text-center mt-3">
    <a href="<?= site_url('login') ?>">Volver al inicio de sesión</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/restablecer.js') ?>"></script>
<?= $this->endSection() ?>