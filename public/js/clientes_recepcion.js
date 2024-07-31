/**
 * CLIENTES RECEPCIÓN
 *
 */
const urls = {
    obtener: baseUrl + 'clientes/obtener-recepcion',
    asignar: baseUrl + 'clientes/asignar-abogado',
    editar: baseUrl + 'clientes/editar-cliente',
    borrar: baseUrl + 'clientes/eliminar-cliente',
    casos_cliente: baseUrl + 'clientes/casos-cliente'
};

let $tablaClientesRecepcion;
let $modalAsignarAbogado;
let $modalCobrar;
let tplAccionesTabla = '';
let tplCobroCliente = '';

$(function () {
    setActiveMenu('clientes');
    tplAccionesTabla = $('#tplAccionesTabla').html();
    tplCobroCliente = $('#tplCobroCliente').html();
    $modalAsignarAbogado = $('#modalAsignarAbogado');
    $modalCobrar = $('#modalCobrar');

    // Inicializar Select2 en los filtros y modales
    $('.select2').select2({
        placeholder: 'Seleccione una opción',
        theme: 'bootstrap-5'
    });

    // Inicializar Flatpickr en el filtro de período
    $('#filtroPeriodoRecepcion').flatpickr({
        mode: 'range',
        dateFormat: 'Y-m-d'
    });

    // Inicializar la tabla de clientes con Bootstrap Table
    $tablaClientesRecepcion = $('#tablaClientesRecepcion').bootstrapTable({
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
            let filtros = $('#filtrosClientesRecepcion').serializeObject();
            const data = $.extend({}, params, filtros);
            return JSON.stringify(data);
        },
        onLoadSuccess: function () {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    // Manejar el evento de reinicio de filtros
    $('#resetFiltrosRecepcion').on('click', function () {
        $('#filtrosClientesRecepcion')[0].reset();
        $('#filtrosClientesRecepcion .select2').val(null).trigger('change');
        $('#filtroPeriodoRecepcion').flatpickr().clear();

        // Re-inicializar Flatpickr después de limpiar los filtros
        $('#filtroPeriodoRecepcion').flatpickr({
            mode: 'range',
            dateFormat: 'Y-m-d'
        });

        $tablaClientesRecepcion.bootstrapTable('refresh', {
            url: urls.obtener,
            method: 'POST'
        });
    });

    // Aplicar filtros en la tabla al enviar el formulario
    $('#filtrosClientesRecepcion').on('submit', function (e) {
        e.preventDefault();
        $tablaClientesRecepcion.bootstrapTable('refresh');
    });

    // Mostrar el modal de asignar abogado
    $modalAsignarAbogado
        .on('show.bs.modal', function (e) {
            const $btn = $(e.relatedTarget);
            const id_cliente = $btn.data('id');
            $('#idClienteAsignarAbogado').val(id_cliente);
        })
        .on('hide.bs.modal', function () {
            const $frm = $('#frmAsignarAbogado');
            $frm.find('input, select').attr('disabled', false);
            $frm[0].reset();
            $frm.find('select').trigger('change');
            $('#btnAsignarAbogado').attr('disabled', false);
        });

    // Mostrar el modal de cobrar y cargar los casos del cliente
    $modalCobrar.on('show.bs.modal', function (e) {
        const $btn = $(e.relatedTarget);
        const id_cliente = $btn.data('id');
        const clientes = $tablaClientesRecepcion.bootstrapTable('getData');
        const cliente = clientes.find((cliente) => cliente.id_cliente == id_cliente);

        obtenerCasosPorCliente(id_cliente).then(function (r) {
            const casos = r.casos
                .filter((caso) => caso.pagado == '0')
                .map((caso) => {
                    caso.muestraCasoAPI = caso.caseID !== '0';
                    caso.casoPagado = caso.pagado == '1';

                    return caso;
                });
            cliente.casos = casos;

            console.log({ cliente });

            const renderData = Handlebars.compile(tplCobroCliente)(cliente);
            $('#modalCobrar .modal-body').html(renderData);
        });
    });

    // Enviar formulario para asignar abogado
    $('#btnAsignarAbogado').on('click', function () {
        $('#frmAsignarAbogado').trigger('submit');
    });

    $('#frmAsignarAbogado')
        .on('submit', function (e) {
            e.preventDefault();
            const $frm = $(this);
            const data = $frm.serializeObject();

            if ($frm.valid()) {
                agregarAbogado(data)
                    .then(function (resultado) {
                        if (!resultado.success) {
                            swal.fire('¡Oops! Algo salió mal.', resultado.message, 'error');
                        } else {
                            swal.fire('¡Listo!', resultado.message, 'success');
                            $tablaClientesRecepcion.bootstrapTable('refresh');
                            $frm.find('input, select').attr('disabled', true);
                            $('#btnAsignarAbogado').attr('disabled', true);
                            $frm.find('select').trigger('change');
                            $modalAsignarAbogado.modal('hide');
                        }
                    })
                    .catch(function (error) {
                        swal.fire('¡Oops! Algo salió mal.', 'Hubo un problema al asignar el abogado.', 'error');
                    });
            }
        })
        .validate();
});

// Funciones adicionales para gestionar la tabla y los formularios
function accionesTablaUsuarios(value, row, index, field) {
    row.esIntake = row.estatus == '2';
    row.esViable = row.estatus == '4';
    row.esPorAsignar = row.estatus == '8';

    const renderData = Handlebars.compile(tplAccionesTabla)(row);
    return renderData;
}

function agregarAbogado(data) {
    return $.ajax({
        type: 'post',
        url: urls.asignar,
        data: data,
        dataType: 'json'
    });
}

function obtenerCasosPorCliente(id_cliente) {
    return $.ajax({
        type: 'post',
        url: urls.casos_cliente,
        data: { id_cliente },
        dataType: 'json'
    });
}

function formatoNombre(value, row, index, field) {
    const tpl = `<a href="${baseUrl}/clientes/${row.id_cliente}">${value}</a>`;
    return tpl;
}
