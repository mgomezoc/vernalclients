<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="section-header text-center">
                    <h1 class="section-title"><i class="fa-duotone fa-user-gear me-1"></i> Mi cuenta</h1>
                </div>
                <div class="card card-body">
                    <?php if (session()->getFlashdata('mensaje')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('mensaje') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('cuenta/actualizar') ?>" method="post" novalidate>
                        <?= csrf_field() ?>
                        <div class="row mb-3">
                            <label for="nombre" class="col-md-4 col-form-label text-md-end">Nombre</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $usuario['nombre'] ?>" required>
                                <div id="nombreHelp" class="form-text">Ingresa tu nombre completo.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="apellido_paterno" class="col-md-4 col-form-label text-md-end">Apellido Paterno</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="<?= $usuario['apellido_paterno'] ?>" required>
                                <div id="apellidoPaternoHelp" class="form-text">Ingresa tu apellido paterno.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="apellido_materno" class="col-md-4 col-form-label text-md-end">Apellido Materno</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" value="<?= $usuario['apellido_materno'] ?>">
                                <div id="apellidoMaternoHelp" class="form-text">Ingresa tu apellido materno (opcional).</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="correo_electronico" class="col-md-4 col-form-label text-md-end">Correo Electrónico</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="<?= $usuario['correo_electronico'] ?>" required>
                                <div id="correoElectronicoHelp" class="form-text">Asegúrate de ingresar un correo válido.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="contrasena" class="col-md-4 col-form-label text-md-end">Nueva Contraseña</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="contrasena" name="contrasena">
                                <div id="contrasenaHelp" class="form-text">Dejar en blanco si no desea cambiar la contraseña.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>