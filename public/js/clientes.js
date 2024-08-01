/**
 * CLIENTES
 *
 */
const urls = {
    actualizarEstatus: baseUrl + 'clientes/actualizar-estatus',
    agregar: baseUrl + 'clientes/agregar-cliente',
    asignar: baseUrl + 'clientes/asignar-abogado',
    borrar: baseUrl + 'clientes/eliminar-cliente',
    caso: baseUrl + 'clientes/nuevo-caso',
    editar: baseUrl + 'clientes/editar-cliente',
    obtener: baseUrl + 'clientes/obtener-clientes'
};

let $tablaClientes;
let $modalNuevoCliente;
let tplAccionesTabla = '';
let tplClienteSlug = '';
let tplModalEstatus = '';
let $modalEstatus;
let tplNuevoCaso = '';
let ProcesosCasos = [];
let fieldValue = [];

let $modalAsignarAbogado;

$(function () {
    $.validator.addMethod(
        'validarTelefonoInternacional',
        function (value, element) {
            return this.optional(element) || /^\+?(\d{1,3})?[-.\s]?(\(\d{1,3}\)|\d{1,3})[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/.test(value);
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
    tplNuevoCaso = $('#tplNuevoCaso').html();

    $modalNuevoCliente = $('#modalNuevoCliente');
    $modalEstatus = $('#modalEstatus');
    $modalAsignarAbogado = $('#modalAsignarAbogado');

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

    // Validación de transición de estatus
    function validarTransicionEstatus(estatusActual) {
        const transicionesPermitidas = {
            1: [2, 7], // Prospecto -> Intake, Inactivo
            2: [3, 7, 8], // Intake -> Asignado, Inactivo, Por Asignar
            3: [4, 5, 7, 8], // Asignado -> Elegible, No Elegible, Inactivo, Por Asignar
            4: [6, 7], // Elegible -> Activo, Inactivo
            5: [1, 7], // No Elegible -> Prospecto, Inactivo
            6: [3, 7], // Activo -> Asignado, Inactivo
            7: [1, 2, 6], // Inactivo -> Prospecto, Intake, Activo
            8: [2, 3, 7] // Por Asignar -> Intake, Asignado, Inactivo
        };

        // Obtener el select de estatus
        const $estatusSelect = $('#cbEstatus');
        const opcionesPermitidas = transicionesPermitidas[estatusActual] || [];

        // Deshabilitar o eliminar opciones no permitidas
        $estatusSelect.find('option').each(function () {
            const valor = parseInt($(this).val(), 10);

            if (!opcionesPermitidas.includes(valor)) {
                $(this).attr('disabled', 'disabled');
            } else {
                $(this).removeAttr('disabled');
            }
        });
    }

    // Evento para mostrar el modal de cambio de estatus
    $modalEstatus.on('show.bs.modal', function (e) {
        const $btn = $(e.relatedTarget);
        const id_cliente = $btn.data('id');
        const cliente = $tablaClientes.bootstrapTable('getData').find((cliente) => cliente.id_cliente == id_cliente);

        const renderData = Handlebars.compile(tplModalEstatus)(cliente);
        $('#containerFormCambioEstatus').html(renderData);

        $('#containerFormCambioEstatus .select2').select2({
            placeholder: 'Seleccione una opción',
            theme: 'bootstrap-5'
        });

        // Llamar la función de validación con el estatus actual
        validarTransicionEstatus(parseInt(cliente.estatus, 10));
    });

    $tablaClientes = $('#tablaClientes').bootstrapTable({
        url: urls.obtener,
        method: 'POST',
        dataType: 'json',
        search: true,
        showRefresh: true,
        pagination: true,
        sidePagination: 'server',
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
        queryParams: function (params) {
            let filtros = $('#filtrosClientes').serializeObject();
            const data = $.extend({}, params, filtros);
            return JSON.stringify(data);
        },
        onLoadSuccess: function () {
            $('[data-toggle="tooltip"]').tooltip();
        },
        detailView: true,
        onExpandRow: function (index, row, $detail) {
            $detail.html('...cargando');
            row.ProcesosCasos = ProcesosCasos;
            row.consultaOnline = row.tipo_consulta == 'online';
            console.log(row);
            const renderData = Handlebars.compile(tplNuevoCaso)(row);
            $detail.html(renderData);

            $detail
                .find('.cbTiposCaso')
                .on('change', function () {
                    const $cb = $(this);
                    const $input = $($cb.data('target'));
                    const costo = $cb.find('option:selected').data('costo');

                    $input.val(costo);
                })
                .select2({
                    placeholder: 'Seleccione una opción',
                    theme: 'bootstrap-5'
                });

            $('.flatpickr').flatpickr();
        }
    });

    $('#resetFiltros').on('click', function () {
        $('#filtrosClientes')[0].reset();
        $('#filtrosClientes .select2').val(null).trigger('change');
        $('#filtroPeriodo').flatpickr().clear();

        // Re-inicializar Flatpickr después de limpiar los filtros
        $('#filtroPeriodo').flatpickr({
            mode: 'range',
            dateFormat: 'Y-m-d'
        });

        $tablaClientes.bootstrapTable('refresh', {
            url: urls.obtener,
            method: 'POST'
        });
    });

    $('#filtrosClientes').on('submit', function (e) {
        e.preventDefault();
        $tablaClientes.bootstrapTable('refresh');
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
                    required: 'Este campo es obligatorio.',
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
                swal.fire('¡Oops! Algo salió mal.', 'Hubo un problema al reactivar el usuario.', 'error');
            } else {
                $tablaClientes.bootstrapTable('refresh');
            }
        });
    });

    $modalEstatus.on('show.bs.modal', function (e) {
        const $btn = $(e.relatedTarget);
        const id_cliente = $btn.data('id');
        const cliente = $tablaClientes.bootstrapTable('getData').find((cliente) => cliente.id_cliente == id_cliente);

        const renderData = Handlebars.compile(tplModalEstatus)(cliente);

        $('#containerFormCambioEstatus').html(renderData);

        $('#containerFormCambioEstatus .select2').select2({
            placeholder: 'Seleccione una opción',
            theme: 'bootstrap-5'
        });

        // Validar transiciones de estatus
        validarTransicionEstatus(parseInt(cliente.estatus, 10));
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
                swal.fire('¡Oops! Algo salió mal.', r.message, 'error');
            }
        });
    });

    $('#filtroPeriodo').flatpickr({
        mode: 'range',
        dateFormat: 'Y-m-d'
    });

    caseProcesses();

    $(document).on('submit', '.frmNuevoCaso', function (e) {
        e.preventDefault();
    });

    $(document)
        .on('click', '.btnNuevoCaso', function (e) {
            const $btn = $(this);
            const $frm = $($btn.data('target'));

            if (!$frm.valid()) {
                return false;
            }

            const formData = $frm.serializeObject();
            const estatus = $btn.data('tipo');

            formData.estatus = estatus;
            formData.proceso = $(`#cbTiposCaso-${formData.id_cliente} option:selected`).text();

            let procesos_adicionales = [];
            $(`#cbTiposCasoAdicionales-${formData.id_cliente} option:selected`).each(function (i, option) {
                const $option = $(option);
                procesos_adicionales.push({
                    id: $option.val(),
                    label: $option.text()
                });

                fieldValue.push($option.text());
            });

            formData.procesos_adicionales = JSON.stringify(procesos_adicionales);

            console.log(formData);

            nuevoCaso(formData).then(function (r) {
                console.log(r);
                if (!r.success) {
                    swal.fire('¡Oops! Algo salió mal.', r.message, 'error');
                } else {
                    swal.fire('¡Listo!', 'Se ha actualizado correctamente la información.', 'success');
                    $tablaClientes.bootstrapTable('refresh');
                    const id_caso = r.crearCaso;
                    createCase(formData.clientID, formData.sucursal, formData.id_tipo_caso, id_caso);
                }
            });
        })
        .validate();

    //ASIGNAR
    // Enviar formulario para asignar abogado
    $('#btnAsignarAbogado').on('click', function () {
        $('#frmAsignarAbogado').trigger('submit');
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
    //Asignar usuario a abogado
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
                        swal.fire('¡Oops! Algo salió mal.', 'Hubo un problema al asignar el abogado.', 'error');
                    });
            }
        })
        .validate();
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

function caseProcesses() {
    $.ajax({
        url: `${baseUrl}api/caseProcesses`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            ProcesosCasos = response.data;
        },
        error: function (xhr, status, error) {
            console.error('Error al cargar caseProcesses: ' + error);
        }
    });
}

function nuevoCaso(data) {
    return $.ajax({
        type: 'post',
        url: urls.caso,
        data: data,
        dataType: 'json'
    });
}

function createCase(clientID, sucursal, processID, id_caso) {
    const sucursalToLocationIDMap = {
        1: 1,
        2: 0,
        4: 2,
        5: 3
    };

    const lawFirmLocationID = sucursalToLocationIDMap[sucursal] !== undefined ? sucursalToLocationIDMap[sucursal] : 1;

    var caseData = {
        autoGenerateCaseNumber: true,
        clientID: clientID,
        caseID: 0,
        applicationText: '',
        caseCategoryID: null,
        caseName: 'Intake',
        caseNumber: `CN-${clientID}-${processID}`,
        //"creationDate": "2024-03-26T18:46:47.217Z",
        denialText: null,
        expirationText: null,
        externalCaseID: null,
        externalCaseNumber: null,
        filingTypeID: null,
        physicalDocumentLocationID: null,
        processID: processID,
        areaOfPracticeID: 1,
        processingText: null,
        statusChangeComment: null,
        //"statusChangeDate": "2024-03-26T18:46:47.217Z",
        statusID: 0,
        //"updateDate": "2024-03-26T18:46:47.217Z",
        incidentText: null,
        statuteOfLimitationText: null,
        incidentLocation: null,
        note: null,
        case_Client: clientID,
        lawFirmLocationID: lawFirmLocationID,
        mainPartyID: clientID
    };

    return $.ajax({
        url: `${baseUrl}api/createCase`,
        type: 'POST',
        contentType: 'application/json-patch+json',
        data: JSON.stringify(caseData),
        dataType: 'json',
        success: function (r) {
            console.log('Caso creado exitosamente:', r);
            actualizarCaseID(id_caso, r.caseID);
            addCaseParty(r.caseID, clientID);
            updateCustomField(r.caseID, 1, {
                fieldValue: fieldValue.join(' --- '),
                description: 'Procesos Adicionales'
            });
        },
        error: function (error) {
            console.error('Error al crear el caso:', error);
        }
    });
}

function agregarAbogado(data) {
    return $.ajax({
        type: 'post',
        url: urls.asignar,
        data: data,
        dataType: 'json'
    });
}
