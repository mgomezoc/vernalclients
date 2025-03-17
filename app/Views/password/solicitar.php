<?= $this->extend('shared/auth_template') ?>

<?= $this->section('content') ?>
<h2>Recuperar Contraseña</h2>
<p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
<?php endif; ?>
<?php if (session()->has('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<form action="<?= site_url('password/enviar-correo') ?>" method="post">
    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" id="email" class="form-control" name="email" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Enviar</button>
</form>
<div class="text-center mt-3">
    <a href="<?= site_url('login') ?>">Volver al inicio de sesión</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/solicitar.js') ?>"></script>
<?= $this->endSection() ?>