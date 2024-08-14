<div class="card card-body">
    <div class="p-2">
        <div class="text-end">
            <a href="<?= site_url('clientes/imprimir/' . $cliente['id_cliente']) ?>" class="btn btn-secondary">
                <i class="fa-solid fa-print me-1"></i>
                Imprimir
            </a>
        </div>
        <hr>
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
                    <div class="data-label">Especifique el motivo de su visita:</div>
                    <div class="data-text"><span class="placeholder col-8"></span></div>
                </div>
            </div>
            <div>
                <h5>INFORMACIÓN DEL BENEFICIARIO(A):</h5>
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
                        <div class="data-label">Nombre completo</div>
                        <div class="data-text"><span class="placeholder col-10"></span></div>
                    </div>
                    <div class="data-cell">
                        <div class="data-label">Género</div>
                        <div class="data-text"><span class="placeholder col-10"></span></div>
                    </div>
                    <div class="data-cell">
                        <div class="data-label">Fecha de nacimiento</div>
                        <div class="data-text"><span class="placeholder col-10"></span></div>
                    </div>
                    <div class="data-cell">
                        <div class="data-label">Ciudad y país de nacimiento</div>
                        <div class="data-text"><span class="placeholder col-10"></span></div>
                    </div>
                    <div class="data-cell">
                        <div class="data-label">Calle y número</div>
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
                        <div class="data-label">Código postal</div>
                        <div class="data-text"><span class="placeholder col-10"></span></div>
                    </div>
                    <div class="data-cell">
                        <div class="data-label">Teléfono</div>
                        <div class="data-text"><span class="placeholder col-10"></span></div>
                    </div>
                    <div class="data-cell">
                        <div class="data-label">Correo electrónico</div>
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
            <div class="accordion">
                <h5>PREGUNTAS DE INMIGRACIÓN PARA EL (LA) BENEFICIARIO(A):</h5>
                <div class="data">
                    <div class="data-cell">
                        <div class="data-label">¿Cómo entró a EE.UU.?</div>
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
                        <div class="data-label">Por favor, seleccione a sus parientes que sean ciudadanos americanos o residentes legales de Estados Unidos</div>
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
                        <div class="data-label">¿En el contexto de migración ha cometido algún crimen en Estados Unidos? ¿Alguna vez le han detenido?</div>
                        <div class="data-text"><span class="placeholder col-10"></span></div>
                    </div>
                    <div class="data-cell">
                        <div class="data-label">¿Alguna vez ha sido arrestado por cualquier crimen?</div>
                        <div class="data-text"><span class="placeholder col-10"></span></div>
                    </div>
                </div>
            </div>
            <div class="accordion">
                <h5>INFORMACIÓN DEL PETICIONARIO:</h5>
                <div class="data">
                    <div class="data-cell">
                        <div class="data-label">Nombre completo</div>
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