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

// Funciones adicionales para gestionar la tabla y los formularios
function columnaEstatus(value, row) {
    let color = '';

    switch (row.estatus) {
        case '1':
            color = 'text-bg-secondary';
            break;
        case '2':
            color = 'text-bg-light';
            break;
        case '3':
            color = 'text-bg-primary';
            break;
        case '4':
            color = 'text-bg-success';
            break;
        case '5':
            color = 'text-bg-danger';
            break;
        case '6':
            color = 'text-bg-info';
            break;
        default:
            color = 'text-bg-dark';
            break;
    }

    return `<span class="badge ${color}">${value}</span>`;
}

function formatoNombre(value, row, index, field) {
    const tpl = `<a href="${baseUrl}/clientes/${row.id_cliente}">${value}</a>`;
    return tpl;
}
