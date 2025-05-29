<div class="container mt-4">
    <h1 class="mb-4">Panel de Control</h1>

    <!-- Botón para filtros -->
    <button class="btn btn-outline-primary mb-3" data-bs-toggle="collapse" data-bs-target="#filtrosPanel" aria-expanded="false">
        Filtros Avanzados
    </button>
    <div class="collapse mb-4" id="filtrosPanel">
        <div class="card card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="filtroFechaInicio" class="form-label">Fecha Inicio</label>
                    <input type="text" id="filtroFechaInicio" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="filtroFechaFin" class="form-label">Fecha Fin</label>
                    <input type="text" id="filtroFechaFin" class="form-control">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button id="btnAplicarFiltros" class="btn btn-success w-100">Aplicar Filtros</button>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs Principales -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm bg-light">
                <div class="card-body text-center">
                    <h6 class="card-title">Clientes Nuevos</h6>
                    <p class="display-6" id="clientes-nuevos">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm bg-light">
                <div class="card-body text-center">
                    <h6 class="card-title">Casos Activos</h6>
                    <p class="display-6" id="casos-activos">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm bg-light">
                <div class="card-body text-center">
                    <h6 class="card-title">Casos Próximos a Corte</h6>
                    <p class="display-6" id="casos-corte-proxima">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm bg-light">
                <div class="card-body text-center">
                    <h6 class="card-title">Ingresos del Periodo</h6>
                    <p class="display-6" id="ingresos-total">$0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs de Reportes -->
    <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabGeneral">General</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabClientes">Clientes</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabExpedientes">Expedientes</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabFinanciero">Financiero</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabEncuestas">Encuestas</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabLegal">Legal</button></li>
    </ul>

    <div class="tab-content mt-4">
        <!-- Tab General -->
        <div class="tab-pane fade show active" id="tabGeneral">
            <h5>Casos por Tipo y Estatus</h5>
            <canvas id="graficaCasosTipo" height="100"></canvas>
            <hr>
            <h5>Formularios por Sucursal</h5>
            <canvas id="graficaFormulariosSucursal" height="100"></canvas>
            <hr>
            <h5>Casos con más Comentarios</h5>
            <div id="tablaCasosMasComentarios"></div>
            <h5>Casos con más Documentos</h5>
            <div id="tablaCasosMasDocumentos"></div>
        </div>

        <!-- Tab Clientes -->
        <div class="tab-pane fade" id="tabClientes">
            <h5>Clientes con solicitudes de asilo</h5>
            <div id="tablaClientesAsilo"></div>
            <h5>Clientes con antecedentes criminales</h5>
            <div id="tablaClientesArrestos"></div>
            <h5>Clientes por visa y modo de entrada</h5>
            <div id="tablaVisaEntrada"></div>
            <h5>Tiempo promedio entre consulta y caso</h5>
            <div id="textoTiempoPromedio" class="text-muted"></div>
            <h5>Clientes con procesos migratorios previos</h5>
            <div id="tablaProcesoPrevio"></div>
            <h5>Clientes por fuente de información</h5>
            <div id="tablaClientesFuente"></div>
        </div>

        <!-- Tab Expedientes -->
        <div class="tab-pane fade" id="tabExpedientes">
            <h5>Clientes con documentos sin caso</h5>
            <div id="tablaClientesSinCaso"></div>
        </div>

        <!-- Tab Financiero -->
        <div class="tab-pane fade" id="tabFinanciero">
            <h5>Ingresos por forma de pago</h5>
            <div id="tablaIngresosFormaPago"></div>
            <h5>Casos no pagados o parcialmente pagados</h5>
            <div id="tablaCasosNoPagados"></div>
        </div>

        <!-- Tab Encuestas -->
        <div class="tab-pane fade" id="tabEncuestas">
            <h5>Promedio de Satisfacción del Cliente</h5>
            <div id="tablaPromedioSatisfaccion"></div>
            <h5>Frecuencia de Respuestas Negativas</h5>
            <div id="textoRespuestasNegativas" class="text-muted"></div>
        </div>

        <!-- Tab Legal -->
        <div class="tab-pane fade" id="tabLegal">
            <h5>Casos con fecha de corte próxima</h5>
            <div id="tablaCasosCorteProxima"></div>
            <h5>Casos con límite vencido o próximo</h5>
            <div id="tablaCasosLimiteVencido"></div>
            <h5>Casos asignados por abogado</h5>
            <div id="tablaCasosPorAbogado"></div>
        </div>
    </div>
</div>