/**
 * AUDITORÍA
 *
 */
const urls = {
    obtener: baseUrl + 'auditoria/obtener'
};

let $tablaAuditoria;

$(function () {
    setActiveMenu('auditoria');

    // Inicializar Select2 en los filtros
    $('.select2').select2({
        placeholder: 'Seleccione una opción',
        theme: 'bootstrap-5'
    });

    // Inicializar Flatpickr en el filtro de período
    $('#filtroPeriodo').flatpickr({
        mode: 'range',
        dateFormat: 'Y-m-d'
    });

    // Inicializar la tabla de auditoría con Bootstrap Table
    $tablaAuditoria = $('#tablaAuditoria').bootstrapTable({
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
            let filtros = $('#filtrosAuditoria').serializeObject();
            const data = $.extend({}, params, filtros);
            return JSON.stringify(data);
        },
        onLoadSuccess: function () {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    // Manejar el evento de reinicio de filtros
    $('#resetFiltrosAuditoria').on('click', function () {
        $('#filtrosAuditoria')[0].reset();
        $('#filtrosAuditoria .select2').val(null).trigger('change');
        $('#filtroPeriodo').flatpickr().clear();

        // Re-inicializar Flatpickr después de limpiar los filtros
        $('#filtroPeriodo').flatpickr({
            mode: 'range',
            dateFormat: 'Y-m-d'
        });

        $tablaAuditoria.bootstrapTable('refresh', {
            url: urls.obtener,
            method: 'POST'
        });
    });

    // Aplicar filtros en la tabla al enviar el formulario
    $('#filtrosAuditoria').on('submit', function (e) {
        e.preventDefault();
        $tablaAuditoria.bootstrapTable('refresh');
    });
});
