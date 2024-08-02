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
                <span>Formulario de admisión</span>
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
                <span>Editar información</span>
            </button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- Formulario de Admisión -->
        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <?= view('clientes/partials/formulario_admision') ?>
        </div>

        <!-- Casos -->
        <?php if (in_array($perfil, $perfilesPermitidos)) : ?>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <?= view('clientes/partials/casos', compact('casos', 'perfil')) ?>
            </div>
        <?php endif; ?>

        <!-- Editar Información -->
        <div class="tab-pane fade" id="edit-tab-pane" role="tabpanel" aria-labelledby="edit-tab" tabindex="0">
            <?= view('clientes/partials/editar_informacion', compact('cliente', 'sucursales')) ?>
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
                                    <span>Agregar comentario</span>
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
                            <div class="d-flex justify-content-between">
                                <strong>{{nombre_usuario}}</strong>
                                <div class="text-muted small">{{fecha_creacion}}</div>
                            </div>
                            <p class="mb-1">{{comentario}}</p>
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
                    <div class="data-label">Nombre completo</div>
                    <div class="data-text">{{beneficiario_nombre}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Género</div>
                    <div class="data-text">{{beneficiario_genero}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Fecha de nacimiento</div>
                    <div class="data-text">{{beneficiario_fecha_nacimiento}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Ciudad y país de nacimiento</div>
                    <div class="data-text">{{beneficiario_ciudad_pais}}</div>
                </div>
                <div class="data-cell">
                    <div class="data-label">Calle y número</div>
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
                    <div class="data-label">Código postal</div>
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
                    <div class="data-label">¿Cómo entró a EE.UU.?</div>
                    <div class="data-text">{{como_entro_eeuu}}</div>
                </div>
                {{#if tipo_visa}}
                    <div class="data-cell">
                        <div class="data-label">Si entró con visa, ¿cuál es el tipo de visa?</div>
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
                        <div class="data-label">Si es así, explique quién, cuándo y los resultados</div>
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
                        <div class="data-label">Lugar, fecha y tipo de delito</div>
                        <div class="data-text">{{victima_crimen_info}}</div>
                    </div>
                {{/if}}
                {{#if cometido_crimen}}
                    <div class="data-cell">
                        <div class="data-label">¿En el contexto de migración ha cometido algún crimen en Estados Unidos, alguna vez lo han detenido?</div>
                        <div class="data-text">{{cometido_crimen}}</div>
                    </div>
                {{/if}}
                <div class="data-cell">
                    <div class="data-label">¿Alguna vez ha sido arrestado por cualquier crimen?</div>
                    <div class="data-text">{{arrestado}}</div>
                </div>
                {{#if arrestado_fecha_cargo}}
                    <div class="data-cell">
                        <div class="data-label">Fecha y cargo</div>
                        <div class="data-text">{{arrestado_fecha_cargo}}</div>
                    </div>
                {{/if}}
                {{#if arrestado_explicacion}}
                    <div class="data-cell">
                        <div class="data-label">Si ha sido más de un arresto, por favor explique</div>
                        <div class="data-text">{{arrestado_explicacion}}</div>
                    </div>
                {{/if}}
            </div>
        </div>
        <div class="acordeon">
            <h5>Información del peticionario:</h5>
            <div class="data">
                <div class="data-cell">
                    <div class="data-label">Nombre completo</div>
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