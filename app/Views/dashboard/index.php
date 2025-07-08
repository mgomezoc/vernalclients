<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-container">
    <section class="section">
        <div class="section-header">
            <h1 class="section-title">
                <i class="fa-solid fa-chart-line"></i>
                <span>Panel de Control</span>
            </h1>
            <div>
                <button class="btn btn-outline-primary mb-3" data-bs-toggle="collapse" data-bs-target="#filtrosPanel" aria-expanded="false">
                    <i class="fa-solid fa-filter me-2"></i>
                    Filtros Avanzados
                </button>
            </div>
        </div>

        <div class="collapse mb-4" id="filtrosPanel">
            <div class="card card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="filtroFechaInicio" class="form-label">
                            <i class="fa-solid fa-calendar-alt me-2"></i>Fecha Inicio
                        </label>
                        <input type="text" id="filtroFechaInicio" class="form-control" placeholder="Seleccionar fecha">
                    </div>
                    <div class="col-md-4">
                        <label for="filtroFechaFin" class="form-label">
                            <i class="fa-solid fa-calendar-alt me-2"></i>Fecha Fin
                        </label>
                        <input type="text" id="filtroFechaFin" class="form-control" placeholder="Seleccionar fecha">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button id="btnAplicarFiltros" class="btn btn-success w-100">
                            <i class="fa-solid fa-search me-2"></i>Aplicar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPIs Principales -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="kpi-card">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="fa-solid fa-user-plus me-2"></i>Clientes Nuevos
                        </h6>
                        <p class="display-6" id="clientes-nuevos">24</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card warning">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="fa-solid fa-exclamation-triangle me-2"></i>Casos Sin Actualizar
                        </h6>
                        <p class="display-6" id="casos-sin-actualizar">7</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card danger">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="fa-solid fa-gavel me-2"></i>Casos Próximos a Corte
                        </h6>
                        <p class="display-6" id="casos-corte-proxima">12</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card success">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="fa-solid fa-dollar-sign me-2"></i>Ingresos del Periodo
                        </h6>
                        <p class="display-6" id="ingresos-total">$45,280</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs de Reportes -->
        <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabGeneral">
                    <i class="fa-solid fa-chart-bar me-2"></i>General
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabClientes">
                    <i class="fa-solid fa-users me-2"></i>Clientes
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabExpedientes">
                    <i class="fa-solid fa-folder-open me-2"></i>Expedientes
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabFinanciero">
                    <i class="fa-solid fa-money-bill-wave me-2"></i>Financiero
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabEncuestas">
                    <i class="fa-solid fa-poll me-2"></i>Encuestas
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabLegal">
                    <i class="fa-solid fa-balance-scale me-2"></i>Legal
                </button>
            </li>
        </ul>

        <div class="tab-content mt-4">
            <!-- Tab General -->
            <div class="tab-pane fade show active" id="tabGeneral">
                <h5><i class="fa-solid fa-chart-pie me-2"></i>Casos por Tipo y Estatus</h5>
                <canvas id="graficaCasosTipo" height="100"></canvas>
                <hr>
                <h5><i class="fa-solid fa-building me-2"></i>Formularios por Sucursal</h5>
                <canvas id="graficaFormulariosSucursal" height="100"></canvas>
                <hr>
                <h5><i class="fa-solid fa-comments me-2"></i>Casos con más Comentarios</h5>
                <div id="tablaCasosMasComentarios" class="table-container"></div>
                <h5><i class="fa-solid fa-file-alt me-2"></i>Casos con más Documentos</h5>
                <div id="tablaCasosMasDocumentos" class="table-container"></div>
                <hr>
                <h5><i class="fa-solid fa-chart-line me-2"></i>Ingresos por Mes (Histórico)</h5>
                <canvas id="graficaIngresosMensuales" height="100"></canvas>
                <hr>
                <h5><i class="fa-solid fa-funnel-dollar me-2"></i>Tasa de Conversión por Fuente de Información</h5>
                <canvas id="graficaConversionFuentes" height="100"></canvas>
                <hr>
                <h5><i class="fa-solid fa-clock me-2"></i>Promedio de Días que un Caso Permanece Abierto</h5>
                <div id="textoPromedioTiempoCaso" class="text-muted">
                    <i class="fa-solid fa-info-circle me-2"></i>
                    Los casos permanecen abiertos un promedio de 45 días antes de resolverse.
                </div>
            </div>

            <!-- Tab Clientes -->
            <div class="tab-pane fade" id="tabClientes">
                <h5><i class="fa-solid fa-passport me-2"></i>Clientes con solicitudes de asilo</h5>
                <div id="tablaClientesAsilo" class="table-container"></div>
                <h5><i class="fa-solid fa-handcuffs me-2"></i>Clientes con antecedentes criminales</h5>
                <div id="tablaClientesArrestos" class="table-container"></div>
                <h5><i class="fa-solid fa-id-card me-2"></i>Clientes por visa y modo de entrada</h5>
                <div id="tablaVisaEntrada" class="table-container"></div>
                <h5><i class="fa-solid fa-hourglass-half me-2"></i>Tiempo promedio entre consulta y caso</h5>
                <div id="textoTiempoPromedio" class="text-muted">
                    <i class="fa-solid fa-info-circle me-2"></i>
                    El tiempo promedio entre la consulta inicial y la apertura del caso es de 7 días.
                </div>
                <h5><i class="fa-solid fa-history me-2"></i>Clientes con procesos migratorios previos</h5>
                <div id="tablaProcesoPrevio" class="table-container"></div>
                <h5><i class="fa-solid fa-info me-2"></i>Clientes por fuente de información</h5>
                <div id="tablaClientesFuente" class="table-container"></div>
            </div>

            <!-- Tab Expedientes -->
            <div class="tab-pane fade" id="tabExpedientes">
                <h5><i class="fa-solid fa-folder-minus me-2"></i>Clientes con documentos sin caso</h5>
                <div id="tablaClientesSinCaso" class="table-container"></div>
            </div>

            <!-- Tab Financiero -->
            <div class="tab-pane fade" id="tabFinanciero">
                <h5><i class="fa-solid fa-credit-card me-2"></i>Ingresos por forma de pago</h5>
                <div id="tablaIngresosFormaPago" class="table-container"></div>
                <h5><i class="fa-solid fa-exclamation-circle me-2"></i>Casos no pagados o parcialmente pagados</h5>
                <div id="tablaCasosNoPagados" class="table-container"></div>
            </div>

            <!-- Tab Encuestas -->
            <div class="tab-pane fade" id="tabEncuestas">
                <h5><i class="fa-solid fa-star me-2"></i>Promedio de Satisfacción del Cliente</h5>
                <div id="tablaPromedioSatisfaccion" class="table-container"></div>
                <h5><i class="fa-solid fa-thumbs-down me-2"></i>Frecuencia de Respuestas Negativas</h5>
                <div id="textoRespuestasNegativas" class="text-muted">
                    <i class="fa-solid fa-info-circle me-2"></i>
                    El 12% de las encuestas recibidas contienen respuestas negativas sobre nuestro servicio.
                </div>
            </div>

            <!-- Tab Legal -->
            <div class="tab-pane fade" id="tabLegal">
                <h5><i class="fa-solid fa-calendar-exclamation me-2"></i>Casos con fecha de corte próxima</h5>
                <div id="tablaCasosCorteProxima" class="table-container"></div>
                <h5><i class="fa-solid fa-clock-o me-2"></i>Casos con límite vencido o próximo</h5>
                <div id="tablaCasosLimiteVencido" class="table-container"></div>
                <h5><i class="fa-solid fa-user-tie me-2"></i>Casos asignados por abogado</h5>
                <div id="tablaCasosPorAbogado" class="table-container"></div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="<?= base_url('css/dashboard.css?v=' . config('App')->assetVersion) ?>">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="<?= base_url('js/dashboard.js?v=' . config('App')->assetVersion) ?>"></script>
<?= $this->endSection() ?>