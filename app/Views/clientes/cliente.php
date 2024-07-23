<div class="card card-body">
    <div class="section-header">
        <h1 class="section-title">
            <i class="fa-light fa-user-vneck-hair"></i>
            <span>Detalle Cliente</span>
        </h1>
        <h5>
            <?= $cliente["nombre"] ?>
            <?php if ($cliente["clientID"]) : ?>
                <a href="https://www.eimmigration.com/VFMLaw/Clients/<?= $cliente["clientID"] ?>" class="btn btn-link" target="_blank">
                    <span>Ver en eimmigration</span>
                    <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                </a>
            <?php endif; ?>
        </h5>
    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                <i class="fa-solid fa-square-list me-1"></i>
                <span>Formulario de Admisión</span>
            </button>
        </li>
        <?php
        $perfilesPermitidos = ["ADMIN", "PARALEGAL", "ATTORNEY", "RECEPTION"];
        if (in_array($perfil, $perfilesPermitidos)) : ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                    <i class="fa-solid fa-folder-user me-1"></i>
                    <span>Casos</span>
                </button>
            </li>
        <?php endif; ?>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit-tab-pane" type="button" role="tab" aria-controls="edit-tab-pane" aria-selected="false">
                <i class="fa-solid fa-edit me-1"></i>
                <span>Editar Información</span>
            </button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- Formulario de Admisión -->
        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <div class="card card-body">
                <div class="p-2">
                    <div id="formulario_admision" class="placeholder-glow">
                        <h5>INFORMACIÓN GENERAL:</h5>
                        <div class="data">
                            <div class="data-cell">
                                <div class="data-label">Fecha de consulta:</div>
                                <div class="data-text"><span class="placeholder col-10"></span></div>
                            </div>
                            <div class="data-cell">
                                <div class="data-label">¿Es su primera consulta aquí?</div>
                                <div class="data-text"><span class="placeholder col-10"></span></div>
                            </div>
                            <div class="data-cell">
                                <div class="data-label">¿Cómo se enteró de nuestro servicio?</div>
                                <div class="data-text"><span class="placeholder col-10"></span></div>
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-cell data-cell-full">
                                <div class="data-label">Especifique el motivo de su visita</div>
                                <div class="data-text"><span class="placeholder col-8"></span></div>
                            </div>
                        </div>
                        <div>
                            <h5>INFORMACIÓN DEL BENEFICIARIO (A):</h5>
                            <div class="data">
                                <div class="data-cell">
                                    <div class="data-label">¿Posee A-Number?</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">¿Posee alguna segunda nacionalidad?</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Nombre Completo</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Género</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Fecha de Nacimiento</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Ciudad y País de Nacimiento</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Calle y Número</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Ciudad</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">País</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Código Postal</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Teléfono</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Email</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Mejor opción para contactarlo</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Horario de contacto preferido</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="acordeon">
                            <h5>PREGUNTAS DE INMIGRACIÓN PARA EL (LA) BENEFICIARIO(A):</h5>
                            <div class="data">
                                <div class="data-cell">
                                    <div class="data-label">¿Cómo entró a EEUU?</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Estatus migratorio actual</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Fecha de última entrada a los Estados Unidos</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">¿Alguna vez han sometido una solicitud migratoria en beneficio suyo?</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">¿Está actualmente en un proceso de inmigración?</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Por favor seleccione a sus parientes que sean ciudadanos americanos o residentes legales de Estados Unidos</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">¿Tiene algún familiar en el servicio militar?</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">¿Ha sido alguna vez víctima de un crimen?</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">¿En el contexto de migración ha cometido algún crimen en Estados Unidos, alguna vez a usted le han tomado?</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">¿Alguna vez ha sido arrestado por CUALQUIER crimen?</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="acordeon">
                            <h5>Información del Peticionario:</h5>
                            <div class="data">
                                <div class="data-cell">
                                    <div class="data-label">Nombre Completo</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Teléfono</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Teléfono</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Teléfono</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                                <div class="data-cell">
                                    <div class="data-label">Especifique el motivo de su visita</div>
                                    <div class="data-text"><span class="placeholder col-10"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Casos -->
        <?php if (in_array($perfil, $perfilesPermitidos)) : ?>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <div class="card card-body">
                    <?php if (empty($casos)) : ?>
                        <div class="text-center">
                            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                            <dotlottie-player src="https://lottie.host/2dd14c8c-49f9-463b-8f96-d5cd15939761/9YecvAjtkr.json" background="transparent" speed="1" style="width: 300px; height: 300px;margin:0 auto" loop autoplay></dotlottie-player>
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
                                                            <div class="caso-label">Proceso Principal</div>
                                                            <div class="caso-text"><?= $caso['proceso'] ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="caso-item">
                                                            <div class="caso-label">Procesos Adicionales</div>
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
                                                            <div class="caso-label">Última Actualización</div>
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
            </div>
        <?php endif; ?>

        <!-- Editar Información -->
        <div class="tab-pane fade" id="edit-tab-pane" role="tabpanel" aria-labelledby="edit-tab" tabindex="0">
            <div class="card card-body">
                <form id="frmEditarCliente" action="#" method="post" class="row g-3">
                    <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">

                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $cliente['nombre'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" value="<?= $cliente['telefono'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="sucursal" class="form-label">Sucursal</label>
                        <select name="sucursal" id="sucursal" class="form-select" required>
                            <?php foreach ($sucursales as $sucursal) : ?>
                                <option value="<?= $sucursal['id'] ?>" <?= $sucursal['id'] == $cliente['sucursal'] ? 'selected' : '' ?>><?= $sucursal['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tipo_consulta" class="form-label">Tipo de Consulta</label>
                        <input type="text" name="tipo_consulta" id="tipo_consulta" value="<?= $cliente['tipo_consulta'] ?>" class="form-control" readonly>
                    </div>
                    <?php if ($cliente['tipo_consulta'] == 'online') : ?>
                        <div class="col-md-12">
                            <label for="meet_url" class="form-label">Meet URL</label>
                            <input type="text" name="meet_url" id="meet_url" class="form-control" value="<?= $cliente['meet_url'] ?>">
                        </div>
                    <?php endif; ?>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalComentarios" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Comentarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <form id="frmComentario" method="post" autocomplete="off">
                            <input type="hidden" name="id_usuario" value="<?= $usuario['id'] ?>">
                            <input type="hidden" name="id_caso" id="inputCasoComentario">
                            <div class="mb-3">
                                <label for="" class="form-label">Comentario</label>
                                <textarea name="comentario" class="form-control" rows="10" required></textarea>
                            </div>
                            <div>
                                <button class="btn btn-primary">
                                    <i class="fa-regular fa-comment-lines me-1"></i>
                                    <span>Agregar Comentario</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div id="comentariosContainer"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<template id="tplComentarios">
    <div class="card">
        <div class="card-body">
            {{#each comentarios}}
                <div class="mb-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0">
                            <i class="fa-light fa-message-lines"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{comentario}}</p>
                            <div class="text-muted small mt-1">{{fecha_creacion}}</div>
                        </div>
                    </div>
                </div>
            {{else}}
                <div class="text-center text-muted">
                    No hay comentarios
                </div>
            {{/each}}
        </div>
    </div>
</template>

<template id="tplFormulario">
    <div id="formulario_admision">
        <h5>INFORMACIÓN GENERAL:</h5>
        <div class="data">
            <div class="data-cell">
                <div class="data-label">Fecha de consulta:</div>
                <div class="data-text">{{fecha_creado}}</div>
            </div>
            <div class="data-cell">
                <div class="data-label">¿Es su primera consulta aquí?</div>
                <div class="data-text">{{es_primera_consulta}}</div>
            </div>
            <div class="data-cell">
                <div class="data-label">¿Cómo se enteró de nuestro servicio?</div>
                <div class="data-text">{{fuente_informacion}}</div>
            </div>
            <div class="data-cell data-cell-full">
                <div class="data-label">Especifique el motivo de su visita</div>
                <div class="data-text">{{motivo_visita}}</div>
            </div>
        </div>
        <div>
            <h5>INFORMACIÓN DEL BENEFICIARIO (A):</h5>
            <div class="data">
                {{#if a_number}}
                    <div class="data-cell">
                        <div class="data-label">¿Posee A-Number?</div>
                        <div class="data-text">{{a_number}}</div>
                    </div>
                {{/if}}
                <div class="data-cell">
                    <div class="data-label">¿Posee alguna segunda nacionalidad?</div>
                    <div class="data-text">{{segunda_nacionalidad}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Nombre Completo</div>
                    <div class="data-text">{{beneficiario_nombre}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Género</div>
                    <div class="data-text">{{beneficiario_genero}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Fecha de Nacimiento</div>
                    <div class="data-text">{{beneficiario_fecha_nacimiento}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Ciudad y País de Nacimiento</div>
                    <div class="data-text">{{beneficiario_ciudad_pais}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Calle y Número</div>
                    <div class="data-text">{{direccion_calle_numero}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Ciudad</div>
                    <div class="data-text">{{direccion_cuidad}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">País</div>
                    <div class="data-text">{{direccion_pais}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Código Postal</div>
                    <div class="data-text">{{direccion_cp}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Teléfono</div>
                    <div class="data-text">{{direccion_telefono}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Email</div>
                    <div class="data-text">{{direccion_email}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Mejor opción para contactarlo</div>
                    <div class="data-text">{{contacto}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Horario de contacto preferido</div>
                    <div class="data-text">{{horario_contacto}}</div>
                </div>
            </div>
        </div>
        <div class="acordeon">
            <h5>PREGUNTAS DE INMIGRACIÓN PARA EL (LA) BENEFICIARIO(A):</h5>
            <div class="data">
                <div class="data-cell">
                    <div class="data-label">¿Cómo entró a EEUU?</div>
                    <div class="data-text">{{como_entro_eeuu}}</div>
                </div>
                {{#if tipo_visa}}
                    <div class="data-cell">
                        <div class="data-label">Si entró con visa, cuál es el tipo de visa</div>
                        <div class="data-text">{{tipo_visa}}</div>
                    </div>
                {{/if}}
                <div class="data-cell">
                    <div class="data-label">Estatus migratorio actual</div>
                    <div class="data-text">{{estatus_migratorio_actual}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Fecha de última entrada a los Estados Unidos</div>
                    <div class="data-text">{{fecha_ultima_entrada}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">¿Alguna vez han sometido una solicitud migratoria en beneficio suyo?</div>
                    <div class="data-text">{{solicitud_migratoria}}</div>
                </div>
                {{#if solicitud_migratoria_explicacion}}
                    <div class="data-cell">
                        <div class="data-label">Si es así, explique quién, cuándo, y los resultados</div>
                        <div class="data-text">{{solicitud_migratoria_explicacion}}</div>
                    </div>
                {{/if}}
                <div class="data-cell">
                    <div class="data-label">¿Está actualmente en un proceso de inmigración?</div>
                    <div class="data-text">{{proceso_migracion}}</div>
                </div>
                {{#if proceso_migracion_explicacion}}
                    <div class="data-cell">
                        <div class="data-label">Si es así, explique</div>
                        <div class="data-text">{{proceso_migracion_explicacion}}</div>
                    </div>
                {{/if}}
                {{#if parientes}}
                    <div class="data-cell">
                        <div class="data-label">Por favor seleccione a sus parientes que sean ciudadanos americanos o residentes legales de Estados Unidos</div>
                        <div class="data-text">{{parientes}}</div>
                    </div>
                {{/if}}
                <div class="data-cell">
                    <div class="data-label">¿Tiene algún familiar en el servicio militar?</div>
                    <div class="data-text">{{familiar_servicio}}</div>
                </div>
                {{#if familiar_servicio_parentesco}}
                    <div class="data-cell">
                        <div class="data-label">Si es así, por favor díganos el parentesco con usted:</div>
                        <div class="data-text">{{familiar_servicio_parentesco}}</div>
                    </div>
                {{/if}}
                <div class="data-cell">
                    <div class="data-label">¿Ha sido alguna vez víctima de un crimen?</div>
                    <div class="data-text">{{victima_crimen}}</div>
                </div>
                {{#if victima_crimen_info}}
                    <div class="data-cell">
                        <div class="data-label">Lugar, fecha, y tipo de delito</div>
                        <div class="data-text">{{victima_crimen_info}}</div>
                    </div>
                {{/if}}
                {{#if cometido_crimen}}
                    <div class="data-cell">
                        <div class="data-label">¿En el contexto de migración ha cometido algún crimen en Estados Unidos, alguna vez a usted le han tomado?</div>
                        <div class="data-text">{{cometido_crimen}}</div>
                    </div>
                {{/if}}
                <div class="data-cell">
                    <div class="data-label">¿Alguna vez ha sido arrestado por CUALQUIER crimen?</div>
                    <div class="data-text">{{arrestado}}</div>
                </div>
                {{#if arrestado_fecha_cargo}}
                    <div class="data-cell">
                        <div class="data-label">Fecha y Cargo</div>
                        <div class="data-text">{{arrestado_fecha_cargo}}</div>
                    </div>
                {{/if}}
                {{#if arrestado_explicacion}}
                    <div class="data-cell">
                        <div class="data-label">Si es más de un arresto, por favor explique</div>
                        <div class="data-text">{{arrestado_explicacion}}</div>
                    </div>
                {{/if}}
            </div>
        </div>
        <div class="acordeon">
            <h5>Información del Peticionario:</h5>
            <div class="data">
                <div class="data-cell">
                    <div class="data-label">Nombre Completo</div>
                    <div class="data-text">{{peticionario_nombre}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Teléfono</div>
                    <div class="data-text">{{peticionario_telefono}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Relación</div>
                    <div class="data-text">{{peticionario_relacion}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Dirección</div>
                    <div class="data-text">{{peticionario_direccion}}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const cliente = <?= json_encode($cliente) ?>;
    const casos = <?= json_encode($casos) ?>;
    const formulario = <?= json_encode($formulario) ?>;
    const datos = formulario ? JSON.parse(formulario.datos_admision) : [];
</script>