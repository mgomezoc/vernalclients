/**
 * CLIENTES
 *
 */
const urls = {
    obtener: baseUrl + 'clientes/obtener-recepcion',
    asignar: baseUrl + 'clientes/asignar-abogado',
    editar: baseUrl + 'clientes/editar-cliente',
    borrar: baseUrl + 'clientes/eliminar-cliente',
    casos_cliente: baseUrl + 'clientes/casos-cliente'
};

let $tablaClientes;
let $modalAsignarAbogado;
let $modalCobrar;
let tplAccionesTabla = '';
let tplEditarCliente = '';
let tplCobroCliente = '';

$(function () {
    setActiveMenu('clientes');
    tplAccionesTabla = $('#tplAccionesTabla').html();
    tplCobroCliente = $('#tplCobroCliente').html();
    $modalAsignarAbogado = $('#modalAsignarAbogado');
    $modalCobrar = $('#modalCobrar');

    $modalAsignarAbogado.find('.select2').select2({
        placeholder: 'Seleccione una opción',
        dropdownParent: $modalAsignarAbogado,
        theme: 'bootstrap-5'
    });

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

    $modalCobrar.on('show.bs.modal', function (e) {
        const $btn = $(e.relatedTarget);
        const id_cliente = $btn.data('id');
        const Clientes = $tablaClientes.bootstrapTable('getData');
        const cliente = Clientes.find(cliente => cliente.id_cliente == id_cliente);

        obtenerCasosPorCliente(id_cliente).then(function (r) {
            cliente.casos = r.casos;
            const renderData = Handlebars.compile(tplCobroCliente)(cliente);
            $('#modalCobrar .modal-body').html(renderData);
        });
    });

    $tablaClientes = $('#tablaClientes').bootstrapTable({
        url: urls.obtener,
        method: 'GET',
        search: true,
        showRefresh: true,
        pagination: true,
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
                            $tablaClientes.bootstrapTable('refresh');
                            $frm.find('input, select').attr('disabled', true);
                            $('#btnAsignarAbogado').attr('disabled', true);
                            $frm.find('select').trigger('change');
                            $modalAsignarAbogado.modal('hide');
                        }
                    })
                    .catch(function (error) {
                        swal.fire('¡Oops! Algo salió mal.', 'Hubo un problema al agregar el usuario.', 'error');
                    });
            }
        })
        .validate();
});

function accionesTablaUsuarios(value, row, index, field) {
    row.esIntake = row.estatus == '2';
    row.esViable = row.estatus == '4';
    row.esPorAsignar = row.estatus == '8';

    console.log(row);

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
    console.log(row);
    const tpl = `<a href="${baseUrl}/clientes/${row.id_cliente}">${value}</a>`;
    return tpl;
}
