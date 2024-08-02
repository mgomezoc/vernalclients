<div class="card card-body">
    <?php if (empty($casos)) : ?>
        <div class="text-center">
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
            <dotlottie-player src="https://lottie.host/2dd14c8c-49f9-463b-8f96-d5cd15939761/9YecvAjtkr.json" background="transparent" speed="1" style="width: 300px; height: 300px; margin: 0 auto;" loop autoplay></dotlottie-player>
            <p class="mt-3">No existen registros.</p>
        </div>
    <?php else : ?>
        <div class="casos">
            <?php foreach ($casos as $caso) : ?>
                <div class="caso card mb-4">
                    <div class="card-header">
                        <div class="caso-titulo">CASO #<?= $caso['id_caso'] ?> - <?= $caso['proceso'] ?></div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="caso-item">
                                            <div class="caso-label">Proceso principal</div>
                                            <div class="caso-text"><?= $caso['proceso'] ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="caso-item">
                                            <div class="caso-label">Procesos adicionales</div>
                                            <?php $procesos_adicionales = json_decode($caso['procesos_adicionales'], true); ?>
                                            <ul class="caso-text">
                                                <?php if (!empty($procesos_adicionales)) : ?>
                                                    <?php foreach ($procesos_adicionales as $proceso) : ?>
                                                        <li><?= $proceso['label'] ?></li>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <li>No hay procesos adicionales.</li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="caso-item">
                                    <div class="caso-label">Antecedente</div>
                                    <div class="caso-text"><?= $caso['comentarios'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="caso-item">
                                            <div class="caso-label">Creado</div>
                                            <div class="caso-text"><?= $caso['fecha_creacion'] ?></div>
                                        </div>
                                        <div class="caso-item">
                                            <div class="caso-label">Costo</div>
                                            <div class="caso-text"><?= $caso['costo'] ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="caso-item">
                                            <div class="caso-label">Última actualización</div>
                                            <div class="caso-text"><?= $caso['fecha_actualizacion'] ?></div>
                                        </div>
                                        <div class="caso-item">
                                            <div class="caso-label">Fecha de corte</div>
                                            <div class="caso-text"><?= $caso['fecha_corte'] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="caso-item">
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalComentarios" data-id="<?= $caso['id_caso'] ?>">
                                        <i class="fa-regular fa-comment-lines me-1"></i>
                                        <span>Comentarios</span>
                                    </button>
                                    <a href="https://www.eimmigration.com/VFMLaw/Cases/<?= $caso['caseID'] ?>/#!/GeneralInfo" class="btn btn-link" target="_blank">
                                        <span>Ver en eimmigration</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php if ($caso['pagado'] == "0") : ?>
                                    <div class="text-center">
                                        <script async src="https://js.stripe.com/v3/buy-button.js"></script>
                                        <stripe-buy-button buy-button-id="buy_btn_1PGpEuFzRmkRg5LnINWrs4i2" publishable-key="pk_test_51OcBXaFzRmkRg5LnsciCB7VwR4BLLNSiBvjptAqWrwRpf9jkFsdQShKI2yEF5SVVop6TvMU0wpTAU4DcbTfRtcYW00yY3yi58o"></stripe-buy-button>
                                    </div>
                                <?php else : ?>
                                    <div class="text-center mt-3">
                                        <div class="alert alert-success" role="alert">
                                            <?php if ($caso['forma_pago'] == "1") : ?>
                                                <span>Caso pagado en línea.</span>
                                            <?php else : ?>
                                                <span>Caso pagado en oficina.</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?php if ($caso['estatus'] != "4") : ?>
                            <button class="btn btn-danger btnCerrarCaso" data-id="<?= $caso['id_caso'] ?>">
                                <i class="fa-duotone fa-ballot-check me-1"></i>
                                <span>Cerrar</span>
                            </button>
                        <?php endif; ?>
                        <button class="btnEncuesta btn btn-azul">
                            <i class="fa-duotone fa-paper-plane-top me-1"></i>
                            <span>Encuesta</span>
                        </button>
                        <?php if ($caso['pagado'] == "0") : ?>
                            <button class="btnPagarCaso btn btn-verde btnVerCaso" data-id="<?= $caso['id_caso'] ?>" data-tipo="1">
                                <i class="fa-duotone fa-receipt me-1"></i>
                                <span>Pagado en línea</span>
                            </button>
                            <button class="btnPagarCaso btn btn-verde btnVerCaso" data-id="<?= $caso['id_caso'] ?>" data-tipo="2">
                                <i class="fa-duotone fa-receipt me-1"></i>
                                <span>Pagado en oficina</span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>