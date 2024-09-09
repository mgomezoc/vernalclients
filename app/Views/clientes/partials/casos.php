<div class="card card-body" style="background-color: #f8f9fa; border-radius: 0.5rem; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <div class="p-2">
        <div class="accordion" id="accordionCasos">
            <?php if (empty($casos)) : ?>
                <div class="text-center">
                    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                    <dotlottie-player src="https://lottie.host/2dd14c8c-49f9-463b-8f96-d5cd15939761/9YecvAjtkr.json" background="transparent" speed="1" style="width: 300px; height: 300px; margin: 0 auto;" loop autoplay></dotlottie-player>
                    <p class="mt-3">No existen registros.</p>
                </div>
            <?php else : ?>
                <div class="casos">
                    <?php foreach ($casos as $index => $caso) : ?>
                        <div class="accordion-item mb-3" style="border: 1px solid #dee2e6; border-radius: 0.25rem;">
                            <h2 class="accordion-header" id="heading<?= $index ?>">
                                <button class="accordion-button <?= $index == 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="<?= $index == 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>" style="background-color: #007bff; color: #ffffff;">
                                    <i class="fa-solid fa-briefcase me-2"></i> CASO #<?= $caso['id_caso'] ?> - <?= htmlspecialchars($caso['proceso']) ?>
                                </button>
                            </h2>
                            <div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= $index == 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $index ?>" data-bs-parent="#accordionCasos">
                                <div class="accordion-body" style="background-color: #ffffff;">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <strong>Proceso principal:</strong>
                                                        <p><?= htmlspecialchars($caso['proceso']) ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <strong>Procesos adicionales:</strong>
                                                        <?php $procesos_adicionales = json_decode($caso['procesos_adicionales'], true); ?>
                                                        <ul class="list-unstyled ms-3">
                                                            <?php if (!empty($procesos_adicionales)) : ?>
                                                                <?php foreach ($procesos_adicionales as $proceso) : ?>
                                                                    <li><i class="fa-solid fa-check me-1 text-success"></i><?= htmlspecialchars($proceso['label']) ?></li>
                                                                <?php endforeach; ?>
                                                            <?php else : ?>
                                                                <li><i class="fa-solid fa-ban me-1 text-danger"></i>No hay procesos adicionales.</li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-5">
                                                <strong>Antecedente:</strong>
                                                <div class="p-3 bg-light"><?= htmlspecialchars_decode($caso['comentarios']) ?></div>
                                            </div>

                                            <!-- Mostrar documentos del caso -->
                                            <div class="mb-5">
                                                <strong>Documentos:</strong>
                                                <ul class="list-group">
                                                    <?php if (!empty($caso['documentos'])) : ?>
                                                        <?php foreach ($caso['documentos'] as $documento) : ?>
                                                            <li class="list-group-item">
                                                                <!-- Agregar Fancybox para los documentos -->
                                                                <a data-fancybox="gallery-<?= $caso['id_caso'] ?>" href="<?= base_url('uploads/casos/' . $documento['nombre_documento']) ?>" data-caption="<?= $documento['nombre_documento'] ?>">
                                                                    <?= $documento['nombre_documento'] ?>
                                                                </a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <li class="list-group-item text-muted">No hay documentos asociados a este caso.</li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <strong>Creado:</strong>
                                                        <p><?= htmlspecialchars($caso['fecha_creacion']) ?></p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Costo:</strong>
                                                        <p><?= htmlspecialchars($caso['costo']) ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <strong>Última actualización:</strong>
                                                        <p><?= htmlspecialchars($caso['fecha_actualizacion']) ?></p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Fecha de corte:</strong>
                                                        <p><?= htmlspecialchars($caso['fecha_corte']) ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalComentarios" data-id="<?= $caso['id_caso'] ?>">
                                                    <i class="fa-regular fa-comment-lines me-1"></i>
                                                    <span>Comentarios</span>
                                                </button>
                                                <?php if ($caso['caseID'] != "0") : ?>
                                                    <a href="https://www.eimmigration.com/VFMLaw/Cases/<?= $caso['caseID'] ?>/#!/GeneralInfo" class="btn btn-link" target="_blank">
                                                        <span>Ver en eimmigration</span>
                                                        <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if ($perfil == "RECEPTION" || $perfil == "ADMIN") : ?>
                                            <div class="col-md-4">
                                                <?php if ($caso['pagado'] == "0") : ?>
                                                    <div class="text-center">
                                                        <script async src="https://js.stripe.com/v3/buy-button.js"></script>
                                                        <stripe-buy-button buy-button-id="buy_btn_1PGpEuFzRmkRg5LnINWrs4i2" publishable-key="pk_test_51OcBXaFzRmkRg5LnsciCB7VwR4BLLNSiBvjptAqWrwRpf9jkFsdQShKI2yEF5SVVop6TvMU0wpTAU4DcbTfRtcYW00yY3yi58o"></stripe-buy-button>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="text-center mt-3">
                                                        <div class="alert alert-success" role="alert">
                                                            <i class="fa-solid fa-check-circle me-1"></i>
                                                            <?php if ($caso['forma_pago'] == "1") : ?>
                                                                <span>Caso pagado en línea.</span>
                                                            <?php else : ?>
                                                                <span>Caso pagado en oficina.</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center" style="background-color: #e9ecef;">
                                    <?php if ($caso['estatus'] != "4") : ?>
                                        <button class="btn btn-danger btnCerrarCaso" data-id="<?= $caso['id_caso'] ?>">
                                            <i class="fa-solid fa-times me-1"></i>
                                            <span>Cerrar</span>
                                        </button>
                                    <?php endif; ?>

                                    <button class="btnEncuesta btn btn-azul">
                                        <i class="fa-solid fa-paper-plane me-1"></i>
                                        <span>Encuesta</span>
                                    </button>

                                    <a href="<?= site_url('clientes/imprimir_caso/' . $caso['id_caso']) ?>" target="_blank" class="btn btn-outline-primary">
                                        <i class="fa-solid fa-print me-1"></i>
                                        <span>Imprimir</span>
                                    </a>

                                    <?php if ($caso['pagado'] == "0") : ?>
                                        <button class="btnPagarCaso btn btn-verde btnVerCaso" data-id="<?= $caso['id_caso'] ?>" data-tipo="1">
                                            <i class="fa-solid fa-receipt me-1"></i>
                                            <span>Pagado en línea</span>
                                        </button>
                                        <button class="btnPagarCaso btn btn-verde btnVerCaso" data-id="<?= $caso['id_caso'] ?>" data-tipo="2">
                                            <i class="fa-solid fa-receipt me-1"></i>
                                            <span>Pagado en oficina</span>
                                        </button>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>