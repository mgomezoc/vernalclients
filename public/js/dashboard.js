$(document).ready(function () {
    const filtros = () => ({
        inicio: $('#filtroFechaInicio').val(),
        fin: $('#filtroFechaFin').val()
    });

    const cargarKpis = () => {
        $.get(`${baseUrl}/dashboard/api/clientes-nuevos`, filtros(), data => $('#clientes-nuevos').text(data.total));
        $.get(`${baseUrl}/dashboard/api/casos-por-tipo`, filtros(), data => $('#casos-activos').text(data.activos || 0));
        $.get(`${baseUrl}/dashboard/api/casos-corte-proxima`, filtros(), data => $('#casos-corte-proxima').text(data.total || 0));
        $.get(`${baseUrl}/dashboard/api/ingresos-forma-pago`, filtros(), data => {
            let total = data.reduce((sum, item) => sum + parseFloat(item.total), 0);
            $('#ingresos-total').text(`$${total.toFixed(2)}`);
        });
    };

    const cargarGrafica = (url, canvasId, labelKey, valueKey) => {
        $.get(`${baseUrl}/dashboard/api/${url}`, filtros(), data => {
            const labels = data.map(d => d[labelKey]);
            const values = data.map(d => d[valueKey]);
            const ctx = document.getElementById(canvasId).getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{ label: 'Total', data: values }]
                },
                options: { responsive: true }
            });
        });
    };

    const cargarTabla = (url, contenedorId, columnas) => {
        $.get(`${baseUrl}/dashboard/api/${url}`, filtros(), data => {
            let html = '<table class="table table-sm table-striped"><thead><tr>';
            columnas.forEach(col => (html += `<th>${col}</th>`));
            html += '</tr></thead><tbody>';
            data.forEach(row => {
                html += '<tr>';
                columnas.forEach(col => (html += `<td>${row[col]}</td>`));
                html += '</tr>';
            });
            html += '</tbody></table>';
            $(`#${contenedorId}`).html(html);
        });
    };

    const cargarTexto = (url, contenedorId, prop = 'valor') => {
        $.get(`${baseUrl}/dashboard/api/${url}`, filtros(), data => {
            $(`#${contenedorId}`).text(data[prop]);
        });
    };

    // Cargar al inicio
    cargarKpis();
    cargarGrafica('casos-por-tipo', 'graficaCasosTipo', 'tipo', 'total');
    cargarGrafica('formularios-por-sucursal', 'graficaFormulariosSucursal', 'sucursal', 'total');
    cargarTabla('casos-mas-comentarios', 'tablaCasosMasComentarios', ['caso', 'total']);
    cargarTabla('casos-mas-documentos', 'tablaCasosMasDocumentos', ['caso', 'total']);

    // Tabs dinámicos
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        const target = $(e.target).data('bs-target');
        switch (target) {
            case '#tabClientes':
                cargarTabla('clientes-asilo', 'tablaClientesAsilo', ['cliente']);
                cargarTabla('clientes-arrestos', 'tablaClientesArrestos', ['cliente']);
                cargarTabla('clientes-visa-entrada', 'tablaVisaEntrada', ['tipo_visa', 'como_entro_eeuu', 'total']);
                cargarTexto('tiempo-promedio-consulta-caso', 'textoTiempoPromedio');
                cargarTabla('clientes-proceso-previo', 'tablaProcesoPrevio', ['cliente']);
                cargarTabla('clientes-por-fuente', 'tablaClientesFuente', ['fuente', 'total']);
                break;
            case '#tabExpedientes':
                cargarTabla('clientes-sin-caso', 'tablaClientesSinCaso', ['cliente']);
                break;
            case '#tabFinanciero':
                cargarTabla('ingresos-forma-pago', 'tablaIngresosFormaPago', ['forma_pago', 'total']);
                cargarTabla('casos-no-pagados', 'tablaCasosNoPagados', ['caso']);
                break;
            case '#tabEncuestas':
                cargarTabla('promedio-satisfaccion', 'tablaPromedioSatisfaccion', ['pregunta', 'promedio']);
                cargarTexto('respuestas-negativas', 'textoRespuestasNegativas');
                break;
            case '#tabLegal':
                cargarTabla('casos-corte-proxima', 'tablaCasosCorteProxima', ['caso']);
                cargarTabla('casos-limite-vencido', 'tablaCasosLimiteVencido', ['caso']);
                cargarTabla('casos-por-abogado', 'tablaCasosPorAbogado', ['abogado', 'total']);
                break;
        }
    });

    // Filtros
    $('#btnAplicarFiltros').click(function () {
        location.reload(); // O recargar dinámicamente cada gráfico si se prefiere
    });

    // Flatpickr para fechas
    flatpickr('#filtroFechaInicio', { dateFormat: 'Y-m-d' });
    flatpickr('#filtroFechaFin', { dateFormat: 'Y-m-d' });
});
