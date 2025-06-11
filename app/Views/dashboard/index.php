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

<style>
    :root {
        --primary-color: #2563eb;
        --secondary-color: #64748b;
        --success-color: #16a34a;
        --warning-color: #d97706;
        --danger-color: #dc2626;
        --bg-light: #f8fafc;
        --bg-card: #ffffff;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    }

    .dashboard-container {
        background: var(--bg-light);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .section {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .section-header {
        background: var(--bg-card);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .section-title i {
        background: linear-gradient(135deg, var(--primary-color), #3b82f6);
        color: white;
        padding: 1rem;
        border-radius: 12px;
        margin-right: 1rem;
        box-shadow: var(--shadow-md);
    }

    .btn-outline-primary {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success-color), #22c55e);
        border: none;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .collapse .card {
        border: none;
        box-shadow: var(--shadow-md);
        border-radius: 16px;
        background: var(--bg-card);
    }

    .form-control {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
    }

    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    /* KPI Cards */
    .kpi-card {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), #3b82f6);
    }

    .kpi-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }

    .kpi-card.warning::before {
        background: linear-gradient(90deg, var(--warning-color), #f59e0b);
    }

    .kpi-card.success::before {
        background: linear-gradient(90deg, var(--success-color), #22c55e);
    }

    .kpi-card.danger::before {
        background: linear-gradient(90deg, var(--danger-color), #ef4444);
    }

    .kpi-card .card-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .kpi-card .display-6 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin: 0;
    }

    /* Navigation Tabs */
    .nav-tabs {
        border: none;
        background: var(--bg-card);
        border-radius: 16px;
        padding: 0.5rem;
        box-shadow: var(--shadow-md);
        margin-bottom: 2rem;
    }

    .nav-tabs .nav-link {
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: var(--text-secondary);
        transition: all 0.3s ease;
        margin: 0 0.25rem;
    }

    .nav-tabs .nav-link:hover {
        background: var(--bg-light);
        color: var(--text-primary);
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color), #3b82f6);
        color: white;
        box-shadow: var(--shadow-md);
    }

    /* Tab Content */
    .tab-content {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
    }

    .tab-content h5 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid var(--primary-color);
        display: inline-block;
    }

    .tab-content hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, var(--primary-color), transparent);
        margin: 3rem 0;
    }

    /* Canvas containers */
    canvas {
        background: var(--bg-light);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 2rem;
    }

    /* Tables */
    .table-container {
        background: var(--bg-light);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
    }

    .text-muted {
        background: var(--bg-light);
        padding: 1.5rem;
        border-radius: 12px;
        border-left: 4px solid var(--primary-color);
        font-weight: 500;
        color: var(--text-secondary);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .kpi-card {
        animation: fadeInUp 0.6s ease forwards;
    }

    .kpi-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .kpi-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .kpi-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .kpi-card:nth-child(4) {
        animation-delay: 0.4s;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .section-title {
            font-size: 2rem;
        }

        .section-title i {
            padding: 0.75rem;
            margin-right: 0.75rem;
        }

        .section-header {
            padding: 1.5rem;
        }

        .tab-content {
            padding: 1.5rem;
        }

        .nav-tabs .nav-link {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
    }

    /* Loading states */
    .loading {
        position: relative;
        opacity: 0.7;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid var(--primary-color);
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>