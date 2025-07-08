<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>Inicio<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1 class="section-title"><i class="fa-duotone fa-house-chimney icon me-2"></i> Bienvenido <?= $usuario["nombre"] ?></h1>
    </div>
</section>
<?= $this->endSection() ?>