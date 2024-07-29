/**
 * CLIENTES
 *
 */
const urls = {
    obtener: baseUrl + 'clientes/obtener-clientes',
    agregar: baseUrl + 'clientes/agregar-cliente',
    editar: baseUrl + 'clientes/editar-cliente',
    borrar: baseUrl + 'clientes/eliminar-cliente',
    actualizarEstatus: baseUrl + 'clientes/actualizar-estatus'
};

let $tablaClientes;
let $modalNuevoCliente;
let tplAccionesTabla = '';
let tplClienteSlug = '';
let tplModalEstatus = '';
let $modalEstatus;

$(function () {
    $.validator.addMethod(
        'validarTelefonoInternacional',
        function (value, element) {
            return (
                this.optional(element) ||
                /^\+?(\d{1,3})?[-.\s]?(\(\d{1,3}\)|\d{1,3})[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/.test(value)
            );
        },
        'Por favor, introduce un número de teléfono válido.'
    );

    setActiveMenu('clientes');

    $('.select2').select2({
        placeholder: 'Seleccione una opción',
        theme: 'bootstrap-5'
    });

    tplAccionesTabla = $('#tplAccionesTabla').html();
    tplClienteSlug = $('#tplClienteSlug').html();
    tplModalEstatus = $('#tplModalEstatus').html();

    $modalNuevoCliente = $('#modalNuevoCliente');
    $modalEstatus = $('#modalEstatus');

    $modalNuevoCliente.find('.select2').select2({
        placeholder: 'Seleccione una opción',
        dropdownParent: $modalNuevoCliente,
        theme: 'bootstrap-5'
    });

    $modalNuevoCliente.on('hide.bs.modal', function () {
        const $frm = $('#frmNuevoCliente');
        $frm.find('input, select').attr('disabled', false);
        $frm[0].reset();
        $frm.find('select').trigger('change');
        $('#clienteSlug').html('');
        $('#btnAgregarCliente').attr('disabled', false);
    });

    $tablaClientes = $('#tablaClientes').bootstrapTable({
        url: urls.obtener,
        method: 'POST',
        search: true,
        showRefresh: true,
        pagination: true,
        pageSize: 50,
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
        },
        onLoadSuccess: function () {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('#resetFiltros').on('click', function () {
        $('#filtrosClientes')[0].reset();
        $('#filtrosClientes .select2').val(null).trigger('change');
        $('#filtroPeriodo').flatpickr().clear();
        $tablaClientes.bootstrapTable('refresh', {
            url: urls.obtener,
            method: 'POST'
        });
    });

    $('#filtrosClientes').on('submit', function (e) {
        e.preventDefault();

        let filtros = $(this).serialize();

        $.ajax({
            url: baseUrl + 'clientes/obtener-clientes',
            method: 'POST',
            data: filtros,
            dataType: 'json',
            success: function (response) {
                $tablaClientes.bootstrapTable('load', response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error al obtener clientes:', textStatus, errorThrown);
                alert('Hubo un error al obtener los clientes. Por favor, inténtelo de nuevo.');
            }
        });
    });

    $('#btnAgregarCliente').on('click', function () {
        $('#frmNuevoCliente').trigger('submit');
    });

    $('#frmNuevoCliente')
        .on('submit', function (e) {
            e.preventDefault();
            const $frm = $(this);
            const data = $frm.serializeObject();

            if ($frm.valid()) {
                agregarCliente(data)
                    .then(function (resultado) {
                        if (!resultado.success) {
                            swal.fire('¡Oops! Algo salió mal.', resultado.message, 'error');
                        } else {
                            swal.fire('¡Listo!', resultado.message, 'success');
                            $tablaClientes.bootstrapTable('refresh');
                            $frm.find('input, select').attr('disabled', true);
                            $('#btnAgregarCliente').attr('disabled', true);
                            $frm.find('select').trigger('change');
                            const renderData = Handlebars.compile(tplClienteSlug)(resultado.slug);
                            $('#clienteSlug').html(renderData);
                        }
                    })
                    .catch(function (error) {
                        swal.fire('¡Oops! Algo salió mal.', 'Hubo un problema al agregar el usuario.', 'error');
                    });
            }
        })
        .validate({
            rules: {
                telefono: {
                    required: true,
                    validarTelefonoInternacional: true
                }
            },
            messages: {
                telefono: {
                    required: 'Este campo es obligatorio',
                    validarTelefonoInternacional: 'Introduce un número de teléfono válido.'
                }
            }
        });

    $('#nuevo_tipo_consulta').on('change', function () {
        const tipo_consulta = $(this).val();

        if (tipo_consulta == 'online') {
            $('#containerURLGoogleMeet').show();
        } else {
            $('#containerURLGoogleMeet').hide();
        }
    });

    $(document).on('click', '#btnCopiarSlug', function () {
        const url = $('#linkSlug').prop('href');
        copyToClipboard(url);
    });

    $(document).on('click', '.btnReactivar', function (e) {
        e.preventDefault();
        const id_cliente = $(this).data('id');
        const data = {
            id_cliente: id_cliente,
            estatus: 2
        };

        actualizarEstatus(data).then(function (r) {
            if (!r.success) {
                swal.fire('¡Oops! Algo salió mal.', 'Hubo un problema al agregar el usuario.', 'error');
            } else {
                $tablaClientes.bootstrapTable('refresh');
            }
        });
    });

    $modalEstatus.on('show.bs.modal', function (e) {
        const $btn = $(e.relatedTarget);
        const id_cliente = $btn.data('id');
        const cliente = $tablaClientes.bootstrapTable('getData').find(cliente => cliente.id_cliente == id_cliente);

        const renderData = Handlebars.compile(tplModalEstatus)(cliente);

        $('#containerFormCambioEstatus').html(renderData);

        $('#containerFormCambioEstatus .select2').select2({
            placeholder: 'Seleccione una opción',
            theme: 'bootstrap-5'
        });
    });

    $(document).on('submit', '.frmCambioEstatus', function (e) {
        e.preventDefault();
        const $frm = $(this);
        const formData = $frm.serializeObject();

        actualizarEstatusCliente(formData).then(function (r) {
            if (r.success) {
                $tablaClientes.bootstrapTable('refresh');
                $modalEstatus.modal('hide');
            } else {
                swal.fire('¡Oops! Algo salía mal.', r.message, 'error');
            }
        });
    });

    $('#filtroPeriodo').flatpickr({
        mode: 'range',
        dateFormat: 'Y-m-d'
    });
});

function actualizarTablaClientes(filtros) {
    $tablaClientes.bootstrapTable('refresh', {
        url: urls.obtener,
        query: filtros,
        method: 'POST'
    });
}

function formatoNombre(value, row, index, field) {
    const tpl = `<a href="${baseUrl}/clientes/${row.id_cliente}" class="link-offset-2 link-underline link-underline-opacity-10">${value}</a>`;
    return tpl;
}

function columnaEstatus(value, row) {
    const estatusClasses = {
        1: 'text-bg-secondary', // prospecto
        2: 'text-bg-light', // intake
        3: 'text-bg-primary', // asignado
        4: 'text-bg-success', // elegible
        5: 'text-bg-danger', // no elegible
        6: 'text-bg-info', // activo
        7: 'text-bg-warning', // inactivo
        8: 'text-bg-dark' // por asignar
    };

    const defaultClass = 'text-bg-dark';
    const color = estatusClasses[row.estatus] || defaultClass;

    return `<span class="badge ${color}" title="${row.descripcion_estatus}" data-toggle='tooltip' data-placement='left'>${value}</span>`;
}

function accionesTablaUsuarios(value, row, index, field) {
    switch (row.estatus) {
        case '1':
            row.esProspecto = true;
            break;
        case '2':
            row.esIntake = true;
            break;
        case '3':
            row.esAsignado = true;
            break;
        case '4':
            row.esViable = true;
            break;
        case '5':
            row.esNoViable = true;
            break;
        case '7':
            row.estaInactivo = true;
            break;
        default:
            break;
    }

    row.baseUrl = baseUrl;

    const renderData = Handlebars.compile(tplAccionesTabla)(row);

    return renderData;
}

function agregarCliente(data) {
    return $.ajax({
        type: 'post',
        url: urls.agregar,
        data: data,
        dataType: 'json'
    });
}

function actualizarEstatus(data) {
    return $.ajax({
        type: 'post',
        url: urls.actualizarEstatus,
        data: data,
        dataType: 'json'
    });
}

function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard
            .writeText(text)
            .then(function () {
                console.log('Texto copiado al portapapeles');
            })
            .catch(function (err) {
                console.error('No se pudo copiar el texto: ', err);
            });
    } else {
        fallbackCopyToClipboard(text);
    }
}

function fallbackCopyToClipboard(text) {
    var textArea = document.createElement('textarea');
    textArea.value = text;

    document.body.appendChild(textArea);

    textArea.select();

    try {
        var successful = document.execCommand('copy');
        var message = successful ? 'Texto copiado al portapapeles' : 'Error al copiar el texto';
        console.log(message);
    } catch (err) {
        console.error('No se pudo copiar el texto: ', err);
    }

    document.body.removeChild(textArea);
}

function actualizarEstatusCliente(data) {
    return $.ajax({
        type: 'post',
        url: urls.actualizarEstatus,
        data: data,
        dataType: 'json'
    });
}
