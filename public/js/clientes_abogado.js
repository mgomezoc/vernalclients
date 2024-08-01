/**
 * CLIENTES (ABOGADO)
 *
 */
const urls = {
    obtener: baseUrl + 'clientes/obtener-abogado',
    asignar: baseUrl + 'clientes/asignar-abogado',
    editar: baseUrl + 'clientes/editar-cliente',
    borrar: baseUrl + 'clientes/eliminar-cliente',
    caso: baseUrl + 'clientes/nuevo-caso'
};

let $tablaClientes;
let $modalAsignarAbogado;
let tplAccionesTabla = '';
let tplEditarCliente = '';
let tplClienteSlug = '';
let tplNuevoCaso = '';
let fieldValue = [];
let ProcesosCasos = [];

$(function () {
    setActiveMenu('clientes');
    tplAccionesTabla = $('#tplAccionesTabla').html();
    tplEditarCliente = $('#tplEditarCliente').html();
    tplClienteSlug = $('#tplClienteSlug').html();
    tplNuevoCaso = $('#tplNuevoCaso').html();
    $modalAsignarAbogado = $('#modalAsignarAbogado');

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

    $tablaClientes = $('#tablaClientes').bootstrapTable({
        url: urls.obtener,
        method: 'GET',
        search: true,
        showRefresh: true,
        pagination: true,
        detailView: true,
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

    $(document).on('click', '#btnCopiarSlug', function () {
        const url = $('#linkSlug').prop('href');
        copyToClipboard(url);
    });

    $(document)
        .on('click', '.btnNuevoCaso', function (e) {
            const $btn = $(this);
            const $frm = $($btn.data('target'));

            if ($frm.valid()) {
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
                        swal.fire('¡Oops! Algo salía mal.', r.message, 'error');
                    } else {
                        swal.fire('¡Listo!', 'Se ha actualizado correctamente la informacion.', 'success');
                        $tablaClientes.bootstrapTable('refresh');
                        const id_caso = r.crearCaso;
                        createCase(formData.clientID, formData.sucursal, formData.id_tipo_caso, id_caso);
                    }
                });
            }
        })
        .validate();

    $(document).on('submit', '.frmNuevoCaso', function (e) {
        e.preventDefault();
    });

    caseProcesses();
});

function accionesTablaUsuarios(value, row, index, field) {
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

function nuevoCaso(data) {
    return $.ajax({
        type: 'post',
        url: urls.caso,
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

function formatoNombre(value, row, index, field) {
    console.log(row);
    const tpl = `<a href="${baseUrl}/clientes/${row.id_cliente}" target="_blank">${value}</a>`;
    return tpl;
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
            console.log('Case created successfully:', r);
            actualizarCaseID(id_caso, r.caseID);
            addCaseParty(r.caseID, clientID);
            updateCustomField(r.caseID, 1, {
                fieldValue: fieldValue.join(' --- '),
                description: 'Procesos Adicionales'
            });
        },
        error: function (error) {
            console.error('Error creating case:', error);
        }
    });
}

function addCaseParty(caseID, clientID, clientName) {
    var partyData = {
        clientID: clientID,
        caseID: caseID,
        clientName: '',
        clientTypeID: 0,
        isMainParty: true,
        roleID: 8,
        addressID: null,
        address: '',
        signatoryID: null,
        signatory: '',
        clientType: {
            typeID: 0,
            name: 'Individual'
        },
        role: {
            roleID: 8,
            name: 'Beneficiary'
        }
    };

    return $.ajax({
        url: `${baseUrl}api/addCaseParty/${caseID}`,
        type: 'POST',
        contentType: 'application/json-patch+json',
        data: JSON.stringify(partyData),
        dataType: 'json',
        success: function (data) {
            console.log('Party created successfully:', data);
        },
        error: function (error) {
            console.error('Error creating case:', error);
        }
    });
}

function actualizarCaseID(id_caso, caseID) {
    const data = {
        id_caso: id_caso,
        caseID: caseID
    };

    return $.ajax({
        type: 'post',
        url: baseUrl + 'casos/actualizarCaseID',
        data: data,
        dataType: 'json'
    });
}

function updateCustomField(caseID, customFieldID, customFieldData) {
    $.ajax({
        url: `${baseUrl}/api/updateCustomField/${caseID}/${customFieldID}`,
        type: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(customFieldData),
        success: function (response) {
            console.log('Campo actualizado con éxito:', response);
        },
        error: function (xhr, status, error) {
            console.error('Error al actualizar el campo:', xhr.responseText);
        }
    });
}
