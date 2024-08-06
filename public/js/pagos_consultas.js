/**
 * PAGOS CONSULTAS
 *
 */
const urls = {
    obtener: baseUrl + 'pagos_consultas/obtener'
};

let $tablaPagosConsultas;
let tplAccionesTabla;

$(function () {
    setActiveMenu('pagos_consultas');

    tplAccionesTabla = $('#tplAccionesTabla').html();

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

    // Inicializar la tabla de pagos con Bootstrap Table
    $tablaPagosConsultas = $('#tablaPagosConsultas').bootstrapTable({
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
            let filtros = $('#filtrosPagosConsultas').serializeObject();
            const data = $.extend({}, params, filtros);
            return JSON.stringify(data);
        },
        onLoadSuccess: function () {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    // Manejar el evento de reinicio de filtros
    $('#resetFiltrosPagosConsultas').on('click', function () {
        $('#filtrosPagosConsultas')[0].reset();
        $('#filtrosPagosConsultas .select2').val(null).trigger('change');
        $('#filtroPeriodo').flatpickr().clear();

        // Re-inicializar Flatpickr después de limpiar los filtros
        $('#filtroPeriodo').flatpickr({
            mode: 'range',
            dateFormat: 'Y-m-d'
        });

        $tablaPagosConsultas.bootstrapTable('refresh', {
            url: urls.obtener,
            method: 'POST'
        });
    });

    // Aplicar filtros en la tabla al enviar el formulario
    $('#filtrosPagosConsultas').on('submit', function (e) {
        e.preventDefault();
        $tablaPagosConsultas.bootstrapTable('refresh');
    });

    // Manejar la apertura del modal
    $(document).on('click', '.btn-marcar-pagado', function () {
        const idPago = $(this).data('id');
        $('#id_pago').val(idPago);
        $('#modalMarcarPagado').modal('show');
    });

    // Validar y enviar el formulario del modal
    $('#frmMarcarPagado').validate({
        rules: {
            forma_pago: {
                required: true
            },
            nota: {
                required: false
            }
        },
        submitHandler: function (form) {
            const data = $(form).serializeObject();
            ajaxCall({
                url: baseUrl + 'pagos_consultas/marcar_pagado',
                method: 'POST',
                data: data,
                success: function (response) {
                    if (response.success) {
                        showSweetAlert('success', response.message);
                        $('#modalMarcarPagado').modal('hide');
                        $tablaPagosConsultas.bootstrapTable('refresh');
                    } else {
                        showSweetAlert('error', response.message);
                    }
                }
            });
        }
    });
});

function accionesTablaPagos(value, row) {
    const renderData = Handlebars.compile(tplAccionesTabla)(row);
    return renderData;
}
