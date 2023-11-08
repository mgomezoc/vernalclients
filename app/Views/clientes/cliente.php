<div class="card card-body">
    <div class="section-header">
        <h1 class="section-title">
            <i class="fa-light fa-user-vneck-hair"></i>
            <span>Detalle Cliente</span>
        </h1>
        <h5><?= $cliente["nombre"] ?></h5>
    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                Formulario de Admisión
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                Casos
            </button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
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
                                    <div class="data-label">¿Ha sido alguna vez victima de un crimen?</div>
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
                            <h5>Información de Peticionario:</h5>
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
        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
            <div class="card card-body text-center">
                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                <dotlottie-player src="https://lottie.host/2dd14c8c-49f9-463b-8f96-d5cd15939761/9YecvAjtkr.json" background="transparent" speed="1" style="width: 300px; height: 300px;margin:0 auto" loop autoplay></dotlottie-player>
                <p class="mt-3">No existen registros.</p>
            </div>
        </div>
    </div>
</div>

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
                        <div class="data-label">Si entró Con Visa, cual es el tipo de Visa</div>
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
                        <div class="data-label">Si es así, explique quién, cuando, y los resultados</div>
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
                    <div class="data-label">¿Ha sido alguna vez victima de un crimen?</div>
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
            <h5>Información de Peticionario:</h5>
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
    const formulario = <?= json_encode($formulario) ?>;
    const datos = formulario ? JSON.parse(formulario.datos_admision) : [];
</script>