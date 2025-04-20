/***
 *
 * INTAKE
 *
 */

const tiposVisa = [
    { Purpose: 'Athletes, artists, entertainers', 'Visa Type': 'P' },
    { Purpose: 'Australian Specialty Occupation Worker', 'Visa Type': 'E-3' },
    { Purpose: 'Border Crossing Card: Mexico', 'Visa Type': 'BCC' },
    { Purpose: 'Business Visitors', 'Visa Type': 'B-1' },
    { Purpose: 'Crew Members (serving aboard ships or aircraft in U.S.)', 'Visa Type': 'D' },
    { Purpose: 'Diplomats and foreign government officials', 'Visa Type': 'A' },
    { Purpose: 'Domestic workers or nannies (must accompany foreign employer)', 'Visa Type': 'B-1' },
    { Purpose: 'Employees of designated international organizations and NATO', 'Visa Type': 'G1-G5, NATO' },
    { Purpose: 'Exchange Visitors', 'Visa Type': 'J' },
    { Purpose: 'Exchange Visitors - au pairs', 'Visa Type': 'J-1' },
    { Purpose: 'Exchange Visitors - children (under 21) or spouse of J-1 holder', 'Visa Type': 'J-2' },
    { Purpose: 'Exchange Visitors - professors, researchers, teachers', 'Visa Type': 'J-1' },
    { Purpose: 'Exchange Visitors - cultural exchange', 'Visa Type': 'J, Q' },
    { Purpose: 'Fiancé(e)', 'Visa Type': 'K-1' },
    { Purpose: 'Foreign military personnel stationed in U.S.', 'Visa Type': 'A-2, NATO1-6' },
    { Purpose: 'Foreign nationals with extraordinary ability in sciences, arts, education, business or athletics', 'Visa Type': 'O-1' },
    { Purpose: 'Free Trade Agreement (FTA) Professionals: Chile', 'Visa Type': 'H-1B1' },
    { Purpose: 'Free Trade Agreement (FTA) Professionals: Singapore', 'Visa Type': 'H-1B1' },
    { Purpose: 'Information Media Representatives (press, journalists)', 'Visa Type': 'I' },
    { Purpose: 'Intracompany Transferees', 'Visa Type': 'L' },
    { Purpose: 'Medical Treatment', 'Visa Type': 'B-2' },
    { Purpose: 'NAFTA Workers: Mexico, Canada', 'Visa Type': 'TN/TD' },
    { Purpose: 'Nurses going to work in health professional shortage areas', 'Visa Type': 'H-1C' },
    { Purpose: 'Physicians', 'Visa Type': 'J-1, H-1B' },
    { Purpose: 'Religious Workers', 'Visa Type': 'R' },
    { Purpose: 'Specialty occupations requiring highly specialized knowledge', 'Visa Type': 'H-1B' },
    { Purpose: 'Students - academic and language', 'Visa Type': 'F-1' },
    { Purpose: 'Students - dependents (F-1 visa holder dependent)', 'Visa Type': 'F-2' },
    { Purpose: 'Students - vocational', 'Visa Type': 'M-1' },
    { Purpose: 'Students - dependents (M-1 visa holder dependent)', 'Visa Type': 'M-2' },
    { Purpose: 'Temporary Agricultural Workers - seasonal', 'Visa Type': 'H-2A' },
    { Purpose: 'Temporary Workers - non-agricultural', 'Visa Type': 'H-2B' },
    { Purpose: 'Tourism, vacation, pleasure visitors', 'Visa Type': 'B-2' },
    { Purpose: 'Training in a program not for employment', 'Visa Type': 'H-3' },
    { Purpose: 'Treaty Investors', 'Visa Type': 'E-2' },
    { Purpose: 'Treaty Traders', 'Visa Type': 'E-1' },
    { Purpose: 'Transiting through U.S.', 'Visa Type': 'C' },
    { Purpose: 'Victims of Human Trafficking', 'Visa Type': 'T-1' },
    { Purpose: 'Visa Renewals in U.S. - A, G, and NATO', 'Visa Type': 'A1-2, G1-4, NATO1-6' }
];

const Parentescos = [
    { label: 'Son/Daughter' },
    { label: 'Spouse' },
    { label: 'Parent' },
    { label: 'Sibling' },
    { label: 'Grandparent' },
    { label: 'Grandchild' },
    { label: 'Uncle/Aunt' },
    { label: 'Nephew/Niece' },
    { label: 'Cousin' },
    { label: 'Son-in-law/Daughter-in-law' },
    { label: 'In-law' },
    { label: 'Stepfather/Stepmother' },
    { label: 'Stepbrother/Stepsister' },
    { label: 'Friend' },
    { label: 'Colleague' },
    { label: 'Neighbor' },
    { label: 'Partner (unmarried)' },
    { label: 'Boyfriend/Girlfriend' },
    { label: 'Roommate' },
    { label: 'Other' }
];

const EstatusMigratorio = [{ label: 'Citizen' }, { label: 'Permanent Resident' }, { label: 'Work Visa' }, { label: 'Student Visa' }, { label: 'Refugee/Asylee' }, { label: 'Undocumented' }, { label: 'Naturalization Process' }, { label: 'Other Immigration Status' }, { label: 'Unknown' }];

$(function () {
    Parentescos.forEach(function (option) {
        $('.cbParentescos').append($('<option>', { value: option.label, text: option.label }));
    });

    EstatusMigratorio.forEach(function (option) {
        $('.cbEstatusMigratorio').append($('<option>', { value: option.label, text: option.label }));
    });

    cargarPaises();
    cargarSucursales();

    $('.select2').select2({
        placeholder: 'Select an option',
        theme: 'bootstrap-5',
        width: '100%'
    });

    // Forzar la validación en Select2 al cambiar
    $('.select2').on('change', function () {
        $(this).valid();
    });

    $('#cbTipoVisa').select2({
        placeholder: 'Select an option',
        theme: 'bootstrap-5',
        width: '100%',
        templateResult: function (data) {
            if (!data.id) {
                return data.text;
            }
            var $option = $('<span>' + data.id + ' </span><small class="text-muted ms-2">' + data.element.dataset.proposito + '</small>');
            return $option;
        }
    });

    // Llenar el combo de tipos de visa
    tiposVisa.forEach(function (option) {
        var newOption = new Option(option['Tipo de Visa'], option['Tipo de Visa'], false, false);
        newOption.setAttribute('data-proposito', option['Propósito']);
        $('#cbTipoVisa').append(newOption).trigger('change');
    });

    $.ajax({
        url: 'https://restcountries.com/v3.1/all',
        type: 'GET',
        success: function (data) {
            data.forEach(function (country) {
                $('#cbNacionalidad').append($('<option>', { value: country.translations.spa.common, text: country.translations.spa.common }));
            });

            $('#cbNacionalidad').select2({
                placeholder: 'Select an option',
                theme: 'bootstrap-5',
                width: '100%'
            });
        },
        error: function (error) {
            console.log('Error al obtener los países: ', error);
        }
    });

    $('.flatpickr').flatpickr({
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'm-d-Y',
        allowInput: true
    });

    $('.muestraMasInformacion').on('change', function () {
        const $ck = $(this);
        const $target = $($ck.data('target'));
        const muestraInformacion = $ck.data('display');

        if (muestraInformacion === 1) {
            $target.attr('hidden', false);
        } else {
            $target.attr('hidden', true);
            $target.find('input, textarea').val('');
            $target.find('select').val('').trigger('change');
        }
    });

    $('#input-fechaNacimiento').on('change', function () {
        const fecha = $(this).val();
        const $viveConPapas = $('#container-menorEdad');
        if (esMenorDeEdad(fecha)) {
            $viveConPapas.attr('hidden', false);
        } else {
            $viveConPapas.attr('hidden', true);
        }
    });

    $('#frmIntake')
        .on('submit', async function (e) {
            e.preventDefault();
            const $frm = $(this);
            let formData = $frm.serializeObject();

            const sucursal_nombre = $('#cbSucursales option:selected').text();
            formData.sucursal_nombre = sucursal_nombre;

            if (!Array.isArray(formData.parientes)) {
                formData.parientes = [formData.parientes];
            }

            formData.parientes = formData.parientes.join(',');

            if (formData.fuente_informacion) {
                if ($.isArray(formData.fuente_informacion)) {
                    formData.fuente_informacion = formData.fuente_informacion.join('|');
                }
            } else {
                formData.fuente_informacion = '';
            }

            if (formData.cometido_crimen) {
                if ($.isArray(formData.cometido_crimen)) {
                    formData.cometido_crimen = formData.cometido_crimen.join(',');
                }
            } else {
                formData.cometido_crimen = '';
            }

            formData.beneficiario_nombre = `${formData.name1} ${formData.name2} ${formData.name3}`;

            const sexID = formData.beneficiario_genero == 'Masculino' ? 0 : 1;

            let dataCliente = {
                id_cliente: formData.id_cliente,
                //"clientID": 0,
                typeID: 0,
                //"statusID": 0,
                sexID: sexID,
                clientNumber: formData.a_number,
                //"externalClientNumber": "string",
                name1: formData.name1,
                name2: formData.name2,
                name3: formData.name3,
                //"maidenName": "string",
                //"title": "string",
                maritalStatus: formData.beneficiario_estado_civil,
                //"ssn": "string",
                //"alienNumber": "string",
                birthText: formData.beneficiario_fecha_nacimiento,
                birthCity: formData.beneficiario_ciudad,
                birthState: formData.direccion_estado,
                birthCountry: formData.beneficiario_pais,
                dayPhone: formData.direccion_telefono,
                eveningPhone: formData.direccion_telefono,
                cellPhone: formData.direccion_telefono,
                //"fax": "string",
                email: formData.direccion_email,
                nationality: formData.nationality,
                //"educationField": "string",
                //"educationDegree": "string",
                //"naicsNumber": "string",
                //"businessType": "string",
                //"establishmentYear": "string",
                //"employeesCount": "string",
                //"annualGrossIncome": "string",
                //"annualNetIncome": "string",
                //"blanketLPetitionReceiptNumber": "string",
                //"niStatus": "string",
                //"niStatusExpirationText": "string",
                //"niStatusMaximumExpirationText": "string",
                //"elisAccountNumber": "string",
                //"preferredName": "string",
                //"pronounID": 0,
                //"preferredContactMethod": "string",
                //"preferredLanguage": "string",
                //"householdSize": "string",
                //"householdIncome": "string",
                //"emergencyContactName": "string",
                //"emergencyContactBirthText": "string",
                //"emergencyContactRelationshipToClient": "string",
                //"emergencyContactPhone": "string"
                autoGenerateClientNumber: false,
                lawFirmLocationID: formData.sucursal
            };

            console.log({ dataCliente, formData });

            if ($frm.valid()) {
                guardarIntake(formData).then(async function (r) {
                    if (!r.success) {
                        swal.fire('¡Oops! Algo salió mal.', r.message, 'error');
                    } else {
                        const idPago = r.id_pago;

                        addClient(dataCliente, idPago);

                        $('#formContainer').hide();
                        $('#mensajeCorrecto').fadeIn();

                        const formDataFile = new FormData($frm[0]);
                        try {
                            const response = await subirArchivo(formDataFile);
                            if (response.success) {
                                showSweetAlert('success', 'Archivo subido exitosamente.');
                            } else {
                                showSweetAlert('error', response.message || 'Error al subir el archivo.');
                            }
                        } catch (error) {
                            showSweetAlert('error', 'Ocurrió un error inesperado al subir el archivo.');
                        }
                    }
                });
            }

            return false;
        })
        .validate({
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            errorElement: 'div',
            errorPlacement: function (error, element) {
                if (element.hasClass('select2') && element.next('.select2-container').length) {
                    error.addClass('invalid-feedback').insertAfter(element.next('.select2-container'));
                } else if (element.is('input[type="checkbox"]') || element.is('input[type="radio"]')) {
                    error.addClass('invalid-feedback').insertAfter(element.closest('div'));
                } else {
                    error.addClass('invalid-feedback').insertAfter(element);
                }
            },
            highlight: function (element, errorClass, validClass) {
                if ($(element).hasClass('select2')) {
                    $(element).next('.select2-container').find('.select2-selection').addClass(errorClass).removeClass(validClass);
                } else {
                    $(element).addClass(errorClass).removeClass(validClass);
                }
            },
            unhighlight: function (element, errorClass, validClass) {
                if ($(element).hasClass('select2')) {
                    $(element).next('.select2-container').find('.select2-selection').removeClass(errorClass).addClass(validClass);
                } else {
                    $(element).removeClass(errorClass).addClass(validClass);
                }
            }
        });

    //SerializeObject
    $.fn.serializeObject = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
});

function esMenorDeEdad(fechaString) {
    // Obtenemos la fecha actual
    var fechaActual = new Date();

    // Convertimos el string de fecha en un objeto Date
    var fechaNacimiento = new Date(fechaString);

    // Calculamos la diferencia en milisegundos entre la fecha actual y la fecha de nacimiento
    var diferenciaMilisegundos = fechaActual - fechaNacimiento;

    // Calculamos la edad dividiendo la diferencia en milisegundos entre el número de milisegundos en un año
    var edad = Math.floor(diferenciaMilisegundos / (1000 * 60 * 60 * 24 * 365.25));

    // Comprobamos si la edad es menor de 21 años
    return edad < 21;
}

function guardarIntake(data) {
    return $.ajax({
        type: 'post',
        url: baseUrl + 'intake/guardar',
        data: data,
        dataType: 'json'
    });
}

function addClient(dataCliente, idPago) {
    const lawFirmLocationID = dataCliente.lawFirmLocationID;

    $.ajax({
        url: `${baseUrl}api/addClient`,
        type: 'POST',
        data: JSON.stringify(dataCliente),
        dataType: 'json',
        contentType: 'application/json',
        success: function (r) {
            if (r.clientID) {
                actualizarClientID(dataCliente.id_cliente, r.clientID);
                createCase(r.clientID, lawFirmLocationID, idPago);
            } else {
                swal.fire('¡Oops! Algo salió mal.', 'Error al crear el cliente en eImmigration.', 'error');
            }
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function createCase(clientID, lawFirmLocationID, idPago) {
    var caseData = {
        autoGenerateCaseNumber: true,
        clientID: clientID,
        caseID: 0,
        applicationText: 'Aplicación inicial para revisión',
        caseCategoryID: null,
        caseName: 'Intake',
        caseNumber: `CONSULTA CN-${clientID}-001`,
        statusID: 0,
        processID: 167,
        areaOfPracticeID: 1,
        lawFirmLocationID: lawFirmLocationID,
        mainPartyID: clientID
    };

    $.ajax({
        url: `${baseUrl}api/createCase`,
        type: 'POST',
        contentType: 'application/json-patch+json',
        data: JSON.stringify(caseData),
        dataType: 'json',
        success: function (r) {
            if (r.caseID) {
                addCaseParty(r.caseID, clientID);

                // Actualizar la referencia del pago en pagos_consultas
                const referencia = `Case ID: ${r.caseID}`;
                actualizarPagoConsulta(idPago, referencia);
            } else {
                swal.fire('¡Oops! Algo salió mal.', 'Error al crear el caso en eImmigration.', 'error');
            }
        },
        error: function (error) {
            console.error('Error creating case:', error);
        }
    });
}

function addCaseParty(caseID, clientID) {
    var partyData = {
        clientID: clientID,
        caseID: caseID,
        clientTypeID: 0,
        isMainParty: true,
        roleID: 8,
        clientType: { typeID: 0, name: 'Individual' },
        role: { roleID: 8, name: 'Beneficiary' }
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

function actualizarPagoConsulta(idPago, referencia) {
    $.ajax({
        url: `${baseUrl}intake/actualizarPago/${idPago}`,
        type: 'POST',
        data: { referencia: referencia },
        success: function (r) {
            if (!r.success) {
                swal.fire('¡Oops! Algo salió mal.', r.message, 'error');
            }
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

// GeneralAPI
function cargarPaises() {
    $.ajax({
        url: `${baseUrl}api/worldCountries`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var $selectsPaisNacimiento = $('.comboPaises');

            $selectsPaisNacimiento.each(function () {
                var $select = $(this);
                $select.empty();

                $select.append($('<option>', { value: '', text: 'Seleccione un país' }));

                $.each(response, function (i, country) {
                    $select.append($('<option>', { value: country.name, text: country.name }));
                });

                $select.select2({
                    placeholder: 'Select an option',
                    theme: 'bootstrap-5',
                    width: '100%'
                });
            });
        },
        error: function (xhr, status, error) {
            console.error('Error al cargar los países: ' + error);
        }
    });
}

function cargarSucursales() {
    $.ajax({
        url: `${baseUrl}api/lawFirmLocations`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var $select = $('#cbSucursales');
            $select.empty();

            $select.append($('<option>', { value: '', text: 'Seleccione una sucursal' }));

            const data = response.totalCount > 0 ? response.data : [];

            $.each(data, function (i, option) {
                $select.append($('<option>', { value: option.lawFirmLocationID, text: option.name }));
            });

            $select.select2({
                placeholder: 'Select an option',
                theme: 'bootstrap-5',
                width: '100%'
            });
        },
        error: function (xhr, status, error) {
            console.error('Error al cargar las sucursales: ' + error);
        }
    });
}

function actualizarClientID(id_cliente, clientID) {
    const data = { id_cliente: id_cliente, clientID: clientID };

    return $.ajax({
        type: 'post',
        url: baseUrl + 'clientes/clientid',
        data: data,
        dataType: 'json'
    });
}

async function subirArchivo(formData) {
    return await ajaxCall({
        type: 'POST',
        url: `${baseUrl}clientes/subir-archivos-expediente/${Cliente.id_cliente}`,
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json'
    });
}
