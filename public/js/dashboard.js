$(document).ready(function () {
    const filtros = () => ({
        inicio: $('#filtroFechaInicio').val(),
        fin: $('#filtroFechaFin').val()
    });

    const cargarKpis = () => {
        $.get(`${baseUrl}/dashboard/api/clientes-nuevos`, filtros(), data => $('#clientes-nuevos').text(data.total));

        $.get(`${baseUrl}/dashboard/api/casos-sin-actualizar`, filtros(), data => {
            $('#casos-sin-actualizar').text(data.total || 0);
        });

        $.get(`${baseUrl}/dashboard/api/casos-por-tipo`, filtros(), data => $('#casos-activos').text(data.activos || 0));

        $.get(`${baseUrl}/dashboard/api/casos-corte-proxima`, filtros(), data => {
            $('#casos-corte-proxima').text(data.length || 0);
        });

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

    const cargarTabla = (url, contenedorId, columnas = null) => {
        $.get(`${baseUrl}/dashboard/api/${url}`, filtros(), data => {
            if (!data || !Array.isArray(data) || data.length === 0) {
                $(`#${contenedorId}`).html('<p class="text-muted">No hay datos disponibles.</p>');
                return;
            }

            // Detectar columnas automáticamente si no se proporcionan
            if (!columnas) {
                columnas = Object.keys(data[0]);
            }

            let html = `<table id="table-${contenedorId}" class="table table-sm table-striped"><thead><tr>`;
            columnas.forEach(col => {
                html += `<th>${col.replace(/_/g, ' ').toUpperCase()}</th>`;
            });
            html += '</tr></thead><tbody>';

            data.forEach(row => {
                html += '<tr>';
                columnas.forEach(col => {
                    html += `<td>${row[col] !== null ? row[col] : ''}</td>`;
                });
                html += '</tr>';
            });

            html += '</tbody></table>';
            $(`#${contenedorId}`).html(html);

            $(`#table-${contenedorId}`).bootstrapTable({
                search: true,
                pagination: true,
                pageSize: 10,
                pageList: [10, 25, 50, 100],
                showRefresh: true,
                showToggle: true,
                showColumns: true,
                iconsPrefix: 'fa-duotone',
                icons: {
                    paginationSwitchDown: 'fa-caret-square-down',
                    paginationSwitchUp: 'fa-caret-square-up',
                    refresh: 'fa-sync',
                    toggleOff: 'fa-toggle-off',
                    toggleOn: 'fa-toggle-on',
                    columns: 'fa-th-list',
                    detailOpen: 'fa-circle-plus',
                    detailClose: 'fa-circle-minus'
                }
            });
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
    cargarGrafica('ingresos-mensuales', 'graficaIngresosMensuales', 'mes', 'total', 'line');
    cargarGrafica('conversion-fuentes', 'graficaConversionFuentes', 'fuente', 'conversion', 'bar');
    cargarTexto('promedio-tiempo-caso-abierto', 'textoPromedioTiempoCaso');

    // Tabs dinámicos
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        const target = $(e.target).data('bs-target');
        switch (target) {
            case '#tabClientes':
                cargarTabla('clientes-asilo', 'tablaClientesAsilo');
                cargarTabla('clientes-arrestos', 'tablaClientesArrestos');
                cargarTabla('clientes-visa-entrada', 'tablaVisaEntrada');
                cargarTexto('tiempo-promedio-consulta-caso', 'textoTiempoPromedio');
                cargarTabla('clientes-proceso-previo', 'tablaProcesoPrevio');
                cargarTabla('clientes-por-fuente', 'tablaClientesFuente');
                break;
            case '#tabExpedientes':
                cargarTabla('clientes-sin-caso', 'tablaClientesSinCaso');
                break;
            case '#tabFinanciero':
                cargarTabla('ingresos-forma-pago', 'tablaIngresosFormaPago');
                cargarTabla('casos-no-pagados', 'tablaCasosNoPagados');
                break;
            case '#tabEncuestas':
                cargarTabla('promedio-satisfaccion', 'tablaPromedioSatisfaccion');
                cargarTexto('respuestas-negativas', 'textoRespuestasNegativas');
                break;
            case '#tabLegal':
                cargarTabla('casos-corte-proxima', 'tablaCasosCorteProxima');
                cargarTabla('casos-limite-vencido', 'tablaCasosLimiteVencido');
                cargarTabla('casos-por-abogado', 'tablaCasosPorAbogado');
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
