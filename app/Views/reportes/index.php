<div class="section">
    <div class="section-header">
        <h1 class="section-title">
            <i class="fa-solid fa-chart-line me-2"></i>
            <span>Reportes</span>
        </h1>
    </div>
    <div class="card card-body">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="clientes-tab" data-bs-toggle="tab" data-bs-target="#tab-clientes" type="button" role="tab" aria-controls="tab-clientes" aria-selected="true">Clientes</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="casos-tab" data-bs-toggle="tab" data-bs-target="#tab-casos" type="button" role="tab" aria-controls="tab-casos" aria-selected="false">Casos</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="encuestas-tab" data-bs-toggle="tab" data-bs-target="#tab-encuestas" type="button" role="tab" aria-controls="tab-encuestas" aria-selected="false">Encuestas</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div id="tab-clientes" class="tab-pane fade show active" role="tabpanel" tabindex="0">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">Clientes por Sucursal</h5>
                                </div>
                                <div class="card-body p-0">
                                    <table id="tbClientesPorSucursal" class="table table-sm table-striped mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th data-field="sucursal">Sucursal</th>
                                                <th data-field="total_clientes">Total Clientes</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">Clientes por Estatus</h5>
                                </div>
                                <div class="card-body p-0">
                                    <table id="tbClientesPorEstatus" class="table table-sm table-striped mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th data-field="estatus">Estatus</th>
                                                <th data-field="total_clientes">Total Clientes</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div id="tab-casos" class="tab-pane fade" role="tabpanel" tabindex="0">
                <div class="card card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">Casos por Tipo</h5>
                                </div>
                                <div class="card-body p-0">
                                    <table id="tbCasosPorTipo" class="table table-sm table-striped mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th data-field="tipo_caso">Proceso</th>
                                                <th data-field="total_casos">Total</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">Casos por Estatus</h5>
                                </div>
                                <div class="card-body p-0">
                                    <table id="tbCasosPorEstatus" class="table table-sm table-striped mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th data-field="estatus">Estatus</th>
                                                <th data-field="total_casos">Total</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">Casos por Abogado</h5>
                                </div>
                                <div class="card-body p-0">
                                    <table id="tbCasosPorAbogado" class="table table-sm table-striped mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th data-field="nombre">Nombre</th>
                                                <th data-field="total_casos">Total</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">Casos por Sucursal</h5>
                                </div>
                                <div class="card-body p-0">
                                    <table id="tbCasosPorSucursal" class="table table-sm table-striped mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th data-field="sucursal">Sucursal</th>
                                                <th data-field="total_casos">Casos</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-warning">
                                    <h5 class="card-title mb-0">Casos Pagados vs No Pagados</h5>
                                </div>
                                <div class="card-body p-0">
                                    <table id="tbCasosPagadosNoPagados" class="table table-sm table-striped mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th data-field="estado_pago">Estado de pago</th>
                                                <th data-field="total_casos">Casos</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="tab-pane fade" id="tab-encuestas" role="tabpanel" tabindex="0">
                <div class="card card-body">
                    <h3>Encuestas</h3>
                    <div class="section-table row justify-content-end align-items-center">
                        <div class="col-12 mb-3">
                            <div id="dashboard"></div>
                        </div>
                        <div class="col-12 mb-5">
                            <canvas id="calificacionServicioChart" style="height: 160px;"></canvas>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tablaEncuestas" class="table table-striped table-sm table-linklaw">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-sortable="true">ID</th>
                                            <th data-field="nombre_cliente">Usuario</th>
                                            <th data-field="fecha_creacion" data-sortable="true">Creado</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<template id="tplDashboard">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">Probabilidad de Recomendación</div>
                    <div class="card-body">
                        <div class="fs-5">{{promedioProbabilidadRecomendacion}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">Calificación de Servicio</div>
                    <div class="card-body">
                        <div class="fs-5">{{promedioCalificacionServicio}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">Tiempo de Respuesta Adecuado</div>
                    <div class="card-body">
                        <div class="fs-5">{{respuestaMasComunTiempo}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="tplDetalleEncuesta">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card card-body">
                    <h5>Detalles de la Encuesta</h5>
                    <table class="table table-sm table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">ID</th>
                                <td>{{id}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Cliente</th>
                                <td>{{nombre_cliente}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Probabilidad de Recomendación</th>
                                <td>{{probabilidad_recomendacion}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Calificación de Servicio</th>
                                <td>{{calificacion_servicio}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tiempo de Respuesta Adecuado</th>
                                <td>{{tiempo_respuesta_adeuado}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Profesionalismo y Actitud</th>
                                <td>{{profesionalismo_actitud}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Correspondencia Precio-Valor</th>
                                <td>{{precio_valor_correspondencia}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Comentarios o Sugerencias</th>
                                <td>{{comentarios_sugerencias}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Fecha de Creación</th>
                                <td>{{fecha_creacion}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</template>