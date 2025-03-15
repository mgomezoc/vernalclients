/**
 * CLIENTES ASIGNADOS (ABOGADO)
 *
 */

const urls = {
    obtener: baseUrl + 'clientes/asignados-obtener'
};

let $tablaClientesAsignados;
let tplAccionesTabla = '';

$(function () {
    setActiveMenu('clientes');
    tplAccionesTabla = $('#tplAccionesTabla').html();

    // Inicializar Select2 en los filtros y modales
    $('.select2').select2({
        placeholder: 'Seleccione una opción',
        theme: 'bootstrap-5'
    });

    // Inicializar Flatpickr en el filtro de período
    $('#filtroPeriodo').flatpickr({
        mode: 'range',
        dateFormat: 'Y-m-d'
    });

    // Inicializar la tabla de clientes con Bootstrap Table
    $tablaClientesAsignados = $('#tablaClientes').bootstrapTable({
        url: urls.obtener,
        method: 'POST',
        search: true,
        showRefresh: true,
        pagination: true,
        sidePagination: 'server',
        pageSize: 50,
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
        },
        queryParams: function (params) {
            let filtros = $('#filtrosClientesAsignados').serializeObject();
            const data = $.extend({}, params, filtros);
            return JSON.stringify(data);
        },
        onLoadSuccess: function () {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    // Manejar el evento de reinicio de filtros
    $('#resetFiltrosAsignados').on('click', function () {
        $('#filtrosClientesAsignados')[0].reset();
        $('#filtrosClientesAsignados .select2').val(null).trigger('change');
        $('#filtroPeriodo').flatpickr().clear();

        // Re-inicializar Flatpickr después de limpiar los filtros
        $('#filtroPeriodo').flatpickr({
            mode: 'range',
            dateFormat: 'Y-m-d'
        });

        $tablaClientesAsignados.bootstrapTable('refresh', {
            url: urls.obtener,
            method: 'POST'
        });
    });

    // Aplicar filtros en la tabla al enviar el formulario
    $('#filtrosClientesAsignados').on('submit', function (e) {
        e.preventDefault();
        $tablaClientesAsignados.bootstrapTable('refresh');
    });
});

function formatoNombre(value, row, index, field) {
    const tpl = `<a href="${baseUrl}/clientes/${row.id_cliente}">${value}</a>`;
    return tpl;
}

function formatoFechaLimite(value, row, index, field) {
    if (!value || value === '0000-00-00') {
        return '<span class="text-muted">Sin fecha</span>';
    }

    let fechaLimite = moment(value);
    let hoy = moment();
    let diasDiferencia = fechaLimite.diff(hoy, 'days');

    let clase = 'text-dark';
    let icono = '';
    let etiqueta = '';

    if (diasDiferencia < 0) {
        // Fecha vencida
        clase = 'text-danger fw-bold text-decoration-line-through';
        etiqueta = `<span class="badge bg-danger">❌ Vencido</span>`;
    } else if (diasDiferencia <= 7) {
        // Urgente (menos de 7 días)
        clase = 'text-danger fw-bold';
        etiqueta = `<span class="badge bg-danger">⏳ Urgente</span>`;
    } else if (diasDiferencia <= 30) {
        // Próximo (7-30 días)
        clase = 'text-warning fw-bold';
        etiqueta = `<span class="badge bg-warning">⚠️ Próximo</span>`;
    } else {
        // A tiempo (más de 30 días)
        clase = 'text-success fw-bold';
        etiqueta = `<span class="badge bg-success">✅ A tiempo</span>`;
    }

    // Tooltip con más detalles
    let tooltip = `title="Faltan ${Math.abs(diasDiferencia)} días para esta fecha límite."`;

    return `<span class="${clase}" ${tooltip}>${icono} ${etiqueta} ${fechaLimite.format('DD/MM/YYYY')}</span>`;
}
