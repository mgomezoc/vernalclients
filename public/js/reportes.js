/**
 * 
 * REPORTES
 * 
 */
let $tablaEncuestas;
let tplDetalleEncuesta = "";
let tplDashboard = "";

$(function () {
    setActiveMenu("reportes");

    tplDetalleEncuesta = $("#tplDetalleEncuesta").html();
    tplDashboard = $("#tplDashboard").html();

    const calificacionesServicio = {
        "1": "Muy insatisfactorio",
        "2": "Insatisfactorio",
        "3": "Neutral",
        "4": "Satisfactorio",
        "5": "Muy satisfactorio"
    };

    const preciosValorCorrespondencia = {
        "1": "Valor mucho menor que el precio",
        "2": "Valor ligeramente menor que el precio",
        "3": "Valor correspondiente al precio",
        "4": "Valor ligeramente mayor que el precio",
        "5": "Valor mucho mayor que el precio"
    };


    $tablaEncuestas = $("#tablaEncuestas").bootstrapTable({
        url: `${baseUrl}reportes/encuesta-respuestas`,
        search: true,
        pagination: true,
        detailView: true,
        iconsPrefix: 'fa-duotone',
        showRefresh: true,
        icons: {
            paginationSwitchDown: 'fa-caret-square-down',
            paginationSwitchUp: 'fa-caret-square-up',
            refresh: 'fa-sync',
            toggleOff: 'fa-toggle-off',
            toggleOn: 'fa-toggle-on',
            columns: 'fa-th-list',
            detailOpen: 'fa-circle-plus',
            detailClose: 'fa-circle-minus'
        },
        onExpandRow: function (index, row, $detail) {
            console.log(row);
            $detail.html("<div class='text-center'>Cargando...</div>");

            row.calificacion_servicio = calificacionesServicio[row.calificacion_servicio];
            row.profesionalismo_actitud = calificacionesServicio[row.profesionalismo_actitud];
            row.precio_valor_correspondencia = preciosValorCorrespondencia[row.precio_valor_correspondencia];

            const renderData = Handlebars.compile(tplDetalleEncuesta)(row);

            $detail.html(renderData);
        },
        onLoadSuccess: function (data, status, xhr) {
            //graficaRecomendacion(data);
            graficaCalificacionServicio(data);
            cargarDashborad(data);
        }
    });

    init();
});

function accionesTablaUsuarios() {
    return "";
}
var dashboard;
function cargarDashborad(rows) {
    dashboard = rows;
    const data = procesarDatos(dashboard);
    const renderData = Handlebars.compile(tplDashboard)(data);
    $("#dashboard").html(renderData);
}

function graficaRecomendacion(respuestas) {
    // Calcula el promedio de la probabilidad de recomendación
    const totalRespuestas = respuestas.length;
    const sumaProbabilidad = respuestas.reduce((suma, respuesta) => suma + parseInt(respuesta.probabilidad_recomendacion), 0);
    const promedio = sumaProbabilidad / totalRespuestas;

    // Configura los datos para la gráfica
    const labels = ['Promedio'];
    const data = [promedio];

    // Configura el gráfico
    const ctx = document.getElementById('recomendacionChart').getContext('2d');
    const recomendacionChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Promedio de Probabilidad de Recomendación',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Promedio de Probabilidad de Recomendación'
                    }
                }]
            }
        }
    });
}

function graficaCalificacionServicio(respuestas) {
    // Calcula la frecuencia de cada calificación de servicio
    const frecuenciaCalificaciones = {
        'Muy insatisfactorio': 0,
        'Insatisfactorio': 0,
        'Neutral': 0,
        'Satisfactorio': 0,
        'Muy satisfactorio': 0
    };

    respuestas.forEach(respuesta => {
        const calificacion = respuesta.calificacion_servicio;
        switch (calificacion) {
            case '1':
                frecuenciaCalificaciones['Muy insatisfactorio']++;
                break;
            case '2':
                frecuenciaCalificaciones['Insatisfactorio']++;
                break;
            case '3':
                frecuenciaCalificaciones['Neutral']++;
                break;
            case '4':
                frecuenciaCalificaciones['Satisfactorio']++;
                break;
            case '5':
                frecuenciaCalificaciones['Muy satisfactorio']++;
                break;
            default:
                break;
        }
    });

    // Configura los datos para la gráfica
    const labels = Object.keys(frecuenciaCalificaciones);
    const data = Object.values(frecuenciaCalificaciones);

    // Configura el gráfico de barras
    const ctx = document.getElementById('calificacionServicioChart').getContext('2d');
    const calificacionServicioChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Popularidad de Calificación de Servicio',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Popularidad'
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Calificación de Servicio'
                    }
                }]
            }
        },
        height: 230
    });
}



function procesarDatos(datos) {
    const totalRespuestas = datos.length;
    let sumaProbabilidad = 0;
    let sumaCalificacionServicio = 0;
    let sumaPrecioValorCorrespondencia = 0;
    let sumaProfesionalismoActitud = 0;
    let tiempoRespuestaAdeuado = {};

    datos.forEach(respuesta => {
        sumaProbabilidad += parseInt(respuesta.probabilidad_recomendacion);
        sumaCalificacionServicio += parseInt(respuesta.calificacion_servicio);
        sumaPrecioValorCorrespondencia += parseInt(respuesta.precio_valor_correspondencia);
        sumaProfesionalismoActitud += parseInt(respuesta.profesionalismo_actitud);

        tiempoRespuestaAdeuado[respuesta.tiempo_respuesta_adeuado] = (tiempoRespuestaAdeuado[respuesta.tiempo_respuesta_adeuado] || 0) + 1;
    });

    const promedioProbabilidadRecomendacion = (sumaProbabilidad / totalRespuestas).toFixed(2);
    const promedioCalificacionServicio = (sumaCalificacionServicio / totalRespuestas).toFixed(2);
    const promedioPrecioValorCorrespondencia = (sumaPrecioValorCorrespondencia / totalRespuestas).toFixed(2);
    const promedioProfesionalismoActitud = (sumaProfesionalismoActitud / totalRespuestas).toFixed(2);

    let respuestaMasComunTiempo = "";
    let maximo = 0;
    for (const respuesta in tiempoRespuestaAdeuado) {
        if (tiempoRespuestaAdeuado.hasOwnProperty(respuesta)) {
            if (tiempoRespuestaAdeuado[respuesta] > maximo) {
                maximo = tiempoRespuestaAdeuado[respuesta];
                respuestaMasComunTiempo = respuesta;
            }
        }
    }

    return {
        promedioProbabilidadRecomendacion,
        promedioCalificacionServicio,
        promedioPrecioValorCorrespondencia,
        promedioProfesionalismoActitud,
        respuestaMasComunTiempo
    };
}


function init() {
    CasosPorTipo().then(function (r) {
        $("#tbCasosPorTipo").bootstrapTable({
            data: r
        });
    });

    CasosPorEstatus().then(function (r) {
        $("#tbCasosPorEstatus").bootstrapTable({
            data: r
        });
    });

    CasosPorAbogado().then(function (r) {
        $("#tbCasosPorAbogado").bootstrapTable({
            data: r
        });
    });

    CasosPorSucursal().then(function (r) {
        $("#tbCasosPorSucursal").bootstrapTable({
            data: r
        });
    });

    CasosPagadosNoPagados().then(function (r) {
        $("#tbCasosPagadosNoPagados").bootstrapTable({
            data: r
        });
    });

    ClientesPorSucursal().then(function (r) {
        $("#tbClientesPorSucursal").bootstrapTable({
            data: r
        });
    });
    ClientesPorEstatus().then(function (r) {
        $("#tbClientesPorEstatus").bootstrapTable({
            data: r
        });
    });
    ComentariosPorCaso();
    EncuestaDeSatisfaccion();
    IngresosPorTipoDeCaso();
    IngresosPorSucursal();
}

function CasosPorTipo() {
    return ajaxCall({
        type: "post",
        url: `${baseUrl}reportes/casos-por-tipo`,
        dataType: "json"
    })
}

function CasosPorEstatus() {
    return ajaxCall({
        type: "post",
        url: `${baseUrl}reportes/casos-por-estatus`,
        dataType: "json"
    })
}

function CasosPorAbogado() {
    return ajaxCall({
        type: "post",
        url: `${baseUrl}reportes/casos-por-abogado`,
        dataType: "json"
    })
}

function CasosPorSucursal() {
    return ajaxCall({
        type: "post",
        url: `${baseUrl}reportes/casos-por-sucursal`,
        dataType: "json"
    })
}

function CasosPagadosNoPagados() {
    return ajaxCall({
        type: "post",
        url: `${baseUrl}reportes/casos-pagados-vs-no-pagados`,
        dataType: "json"
    })
}

function ClientesPorSucursal() {
    return ajaxCall({
        type: "post",
        url: `${baseUrl}reportes/clientes-por-sucursal`,
        dataType: "json"
    })
}

function ClientesPorEstatus() {
    return ajaxCall({
        type: "post",
        url: `${baseUrl}reportes/clientes-por-estatus`,
        dataType: "json"
    })
}

function ComentariosPorCaso() {
    return ajaxCall({
        type: "post",
        url: `${baseUrl}reportes/comentarios-por-caso`,
        dataType: "json"
    })
}

function EncuestaDeSatisfaccion() {
    return ajaxCall({
        type: "post",
        url: `${baseUrl}reportes/encuestas-de-satisfaccion`,
        dataType: "json"
    })
}

function IngresosPorTipoDeCaso() {
    return ajaxCall({
        type: "post",
        url: `${baseUrl}reportes/ingresos-por-tipo-de-caso`,
        dataType: "json"
    })
}

function IngresosPorSucursal() {
    return ajaxCall({
        type: "post",
        url: `${baseUrl}reportes/ingresos-por-sucursal`,
        dataType: "json"
    })
}