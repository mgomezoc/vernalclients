let fieldValue = [];

// Añadir método de validación personalizado para las fechas
$.validator.addMethod(
    'validarFechaLimite',
    function (value, element) {
        const fechaCorte = $('#fecha_corte').val();
        console.log('Validando fecha límite:', value, 'Fecha de corte:', fechaCorte); // Debugging
        if (!fechaCorte || !value) return true; // Si no hay fecha de corte o fecha límite, no validar
        const limiteTiempo = new Date(value);
        const fechaCorteDate = new Date(fechaCorte);
        return limiteTiempo <= fechaCorteDate; // Validar que el límite sea anterior o igual
    },
    'La fecha límite debe ser anterior o igual a la fecha de corte.' // Mensaje de error
);

$(function () {
    const $modalCrearCaso = $('#modalCrearCaso');
    const $formCrearCaso = $('#formCrearCaso');

    // Mostrar el modal al hacer clic en el botón
    $('.btnCrearCaso').on('click', function () {
        $modalCrearCaso.modal('show');
    });

    // Configurar las validaciones del formulario
    $formCrearCaso.validate({
        rules: {
            id_tipo_caso: {
                required: true
            },
            comentarios: {
                required: true,
                minlength: 10
            },
            costo: {
                required: true,
                number: true,
                min: 0
            },
            fecha_corte: {
                date: true
            },
            limite_tiempo: {
                date: true,
                validarFechaLimite: true
            },
            estatus: {
                required: true
            }
        },
        messages: {
            id_tipo_caso: {
                required: 'Seleccione un proceso principal.'
            },
            comentarios: {
                required: 'Este campo es obligatorio.',
                minlength: 'El antecedente debe contener al menos 10 caracteres.'
            },
            costo: {
                required: 'Ingrese el costo del caso.',
                number: 'El costo debe ser un número válido.',
                min: 'El costo debe ser mayor que 0.'
            },
            fecha_corte: {
                required: 'Seleccione la fecha de corte.',
                date: 'Ingrese una fecha válida.'
            },
            limite_tiempo: {
                required: 'Seleccione una fecha límite.',
                date: 'Ingrese una fecha válida.',
                validarFechaLimite: 'La fecha límite debe ser anterior o igual a la fecha de corte.'
            },
            estatus: {
                required: 'Seleccione un estatus para el caso.'
            }
        },
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        errorElement: 'div',
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent()); // Para campos con iconos
            } else {
                error.insertAfter(element); // Para otros campos
            }
        },
        submitHandler: function () {
            const formData = $formCrearCaso.serializeObject();

            formData.proceso = $(`#cbProcesosEInmigration option:selected`).text();

            let procesos_adicionales = [];
            $(`#cbProcesosAdicionalesEInmigration option:selected`).each(function (i, option) {
                const $option = $(option);
                procesos_adicionales.push({
                    id: $option.val(),
                    label: $option.text()
                });

                fieldValue.push($option.text());
            });

            formData.procesos_adicionales = JSON.stringify(procesos_adicionales);

            console.log(formData);

            Swal.fire({
                title: 'Creando caso...',
                text: 'Por favor, espere mientras procesamos su solicitud.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            nuevoCaso(formData).then(function (r) {
                Swal.close();

                if (!r.success) {
                    swal.fire('¡Oops! Algo salió mal.', r.message, 'error');
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Caso creado',
                        text: `Se creó el caso correctamente`
                    }).then(() => {
                        setTimeout(() => {
                            cargarCasos();
                        }, 800);
                    });
                    //crea caso en eimmigration
                    const id_caso = r.crearCaso;

                    if (formData.clientID) {
                        createCaseEImmigration(formData.clientID, formData.sucursal, formData.id_tipo_caso, id_caso);
                    }
                }
            });

            return false;
        }
    });

    // Cargar procesos en los selects
    cargarProcesosEInmigration();

    //Eliminar casos
    $('.btnEliminarCaso').on('click', function (e) {
        e.preventDefault();
        const $btn = $(this);
        const idCaso = $btn.data('id');
        const nombreCaso = $btn.data('nombre');
        eliminarCaso(idCaso);
    });
});

// Funciones auxiliares
function cargarCasos() {
    location.reload();
}

async function cargarProcesosEInmigration() {
    try {
        const res = await getCaseProcesses();
        if (res && res.data && Array.isArray(res.data)) {
            const selectElement = $('#cbProcesosEInmigration, #cbProcesosAdicionalesEInmigration');
            selectElement.empty();
            res.data.forEach(({ processID, name }) => {
                selectElement.append(new Option(name, processID));
            });
            selectElement.select2({
                placeholder: 'Seleccione un proceso',
                theme: 'bootstrap-5',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#modalCrearCaso')
            }); // Inicia Select2
        } else {
            console.error('Formato de datos inesperado:', res);
        }
    } catch (error) {
        console.error('Error al cargar los procesos:', error);
    }
}

function nuevoCaso(data) {
    return $.ajax({
        type: 'post',
        url: baseUrl + 'clientes/nuevo-caso',
        data: data,
        dataType: 'json'
    });
}

function eliminarCaso(idCaso) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                url: baseUrl + 'casos/eliminar',
                type: 'POST',
                data: { id_caso: idCaso },
                success: function (response) {
                    if (response.success) {
                        Swal.fire('¡Eliminado!', response.message, 'success').then(function () {
                            // Actualizar la lista de casos
                            cargarCasos();
                        });
                    } else {
                        Swal.fire('¡Error!', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('¡Error!', 'Ocurrió un error al intentar eliminar el caso.', 'error');
                }
            });
        }
    });
}

function createCaseEImmigration(clientID, sucursal, processID, id_caso) {
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
            addCasePartyEImmigration(r.caseID, clientID);
            updateCustomFieldEImmigration(r.caseID, 1, {
                fieldValue: fieldValue.join(' --- '),
                description: 'Procesos Adicionales'
            });
        },
        error: function (error) {
            console.error('Error al crear el caso:', error);
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

function addCasePartyEImmigration(caseID, clientID, clientName) {
    var partyData = {
        clientID: clientID,
        caseID: caseID,
        clientName: '',
        clientTypeID: 0,
        isMainParty: true,
        roleID: 8
    };

    return $.ajax({
        url: `${baseUrl}api/addCaseParty/${caseID}`,
        type: 'POST',
        contentType: 'application/json-patch+json',
        data: JSON.stringify(partyData),
        dataType: 'json',
        success: function (data) {
            console.log('Parte creada con éxito:', data);
        },
        error: function (error) {
            console.error('Error al crear la parte del caso:', error);
        }
    });
}

function updateCustomFieldEImmigration(caseID, customFieldID, customFieldData) {
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
