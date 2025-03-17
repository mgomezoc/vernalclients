<?= $this->extend('shared/auth_template') ?>

<?= $this->section('content') ?>
<h2>Iniciar Sesión</h2>

<?php if (session()->has('error')) : ?>
    <div class="alert alert-danger text-center">
        <?= session('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('success')) : ?>
    <div class="alert alert-success text-center">
        <?= session('success') ?>
    </div>
<?php endif; ?>


<form id="frmLogin" action="<?= site_url('login') ?>" method="post">
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
    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
</form>

<div class="text-center mt-3">
    <a href="<?= site_url('password/solicitar') ?>">¿Olvidaste tu contraseña?</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/login.js') ?>"></script>
<?= $this->endSection() ?>