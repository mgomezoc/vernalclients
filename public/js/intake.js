/***
 *
 * INTAKE
 *
 */

const tiposVisa = [
    {
        Propósito: 'Atletas, artistas, animadores',
        'Tipo de Visa': 'P'
    },
    {
        Propósito: 'Trabajador australiano – especialidad profesional',
        'Tipo de Visa': 'E-3'
    },
    {
        Propósito: 'Tarjeta de Cruce de Frontera: México',
        'Tipo de Visa': 'BCC'
    },
    {
        Propósito: 'Visitantes de negocios',
        'Tipo de Visa': 'B-1'
    },
    {
        Propósito: 'Tripulación (en servicio a bordo de un barco o un avión en los Estados Unidos)',
        'Tipo de Visa': 'D'
    },
    {
        Propósito: 'Diplomáticos y funcionarios de un gobierno extranjero',
        'Tipo de Visa': 'A'
    },
    {
        Propósito: 'Empleados domésticos o niñeras (deben ir acompañando a un empleador extranjero)',
        'Tipo de Visa': 'B-1'
    },
    {
        Propósito: 'Empleados de una organización internacional designada y OTAN',
        'Tipo de Visa': 'G1-G5, NATO'
    },
    {
        Propósito: 'Visitantes de Intercambio',
        'Tipo de Visa': 'J'
    },
    {
        Propósito: 'Visitantes de intercambio - au pairs',
        'Tipo de Visa': 'J-1'
    },
    {
        Propósito: 'Visitantes de intercambio – hijos (menores de 21 años) o cónyuge del titular de una visa J-1',
        'Tipo de Visa': 'J-2'
    },
    {
        Propósito: 'Visitantes de intercambio – profesores, investigadores, maestros',
        'Tipo de Visa': 'J-1'
    },
    {
        Propósito: 'Visitantes de intercambio – intercambio cultural',
        'Tipo de Visa': 'J, Q'
    },
    {
        Propósito: 'Prometido(a)',
        'Tipo de Visa': 'K-1'
    },
    {
        Propósito: 'Personal militar y extranjero emplazados en los Estados Unidos',
        'Tipo de Visa': 'A-2, NATO1-6'
    },
    {
        Propósito:
            'Ciudadanos extranjeros con habilidad extraordinaria en las ciencias, las artes, educación, negocios o atletismo',
        'Tipo de Visa': 'O-1'
    },
    {
        Propósito: 'Profesionales del Tratado de Libre Comercio (TLC): Chile',
        'Tipo de Visa': 'H-1B1'
    },
    {
        Propósito: 'Profesionales del Tratado de Libre Comercio (TLC): Singapur',
        'Tipo de Visa': 'H-1B1'
    },
    {
        Propósito: 'Representante de información de medios de comunicación (medios de comunicación, periodistas)',
        'Tipo de Visa': 'I'
    },
    {
        Propósito: 'Transferencia de empleados de una compañía',
        'Tipo de Visa': 'L'
    },
    {
        Propósito: 'Tratamiento Médico',
        'Tipo de Visa': 'B-2'
    },
    {
        Propósito: 'Trabajadores profesionalesTLCAN (NAFTA): México, Canadá',
        'Tipo de Visa': 'TN/TD'
    },
    {
        Propósito: 'Enfermeras que viajan a áreas con escasez de profesionales de la salud',
        'Tipo de Visa': 'H-1C'
    },
    {
        Propósito: 'Médicos',
        'Tipo de Visa': 'J-1, H-1B'
    },
    {
        Propósito: 'Trabajadores religiosos',
        'Tipo de Visa': 'R'
    },
    {
        Propósito: 'Ocupaciones especializadas en campos que requieren un alto conocimiento especializado',
        'Tipo de Visa': 'H-1B'
    },
    {
        Propósito: 'Estudiantes – estudiantes académicos y de idioma',
        'Tipo de Visa': 'F-1'
    },
    {
        Propósito: 'Dependientes de estudiantes – dependiente del titular de una visa F-1',
        'Tipo de Visa': 'F-2'
    },
    {
        Propósito: 'Estudiantes - vocacional',
        'Tipo de Visa': 'M-1'
    },
    {
        Propósito: 'Dependientes de estudiantes – dependiente del titular de una visa M-1',
        'Tipo de Visa': 'M-2'
    },
    {
        Propósito: 'Trabajadores agrícolas temporales – estacionales',
        'Tipo de Visa': 'H-2A'
    },
    {
        Propósito: 'Trabajadores temporales – no agrícolas',
        'Tipo de Visa': 'H-2B'
    },
    {
        Propósito: 'Visitantes por turismo, vacaciones, placer',
        'Tipo de Visa': 'B-2'
    },
    {
        Propósito: 'Entrenamiento en un programa sin fines de empleo',
        'Tipo de Visa': 'H-3'
    },
    {
        Propósito: 'Inversionistas',
        'Tipo de Visa': 'E-2'
    },
    {
        Propósito: 'Comerciantes',
        'Tipo de Visa': 'E-1'
    },
    {
        Propósito: 'En tránsito en los Estados Unidos',
        'Tipo de Visa': 'C'
    },
    {
        Propósito: 'Víctimas del tráfico de personas',
        'Tipo de Visa': 'T-1'
    },
    {
        Propósito: 'Renovaciones de visa en los Estados Unidos - A, G, y OTAN',
        'Tipo de Visa': 'A1-2, G1-4, NATO1-6'
    }
];

const Parentescos = [
    { label: 'Hijo/a' },
    { label: 'Esposo/a' },
    { label: 'Padre/Madre' },
    { label: 'Hermano/a' },
    { label: 'Abuelo/a' },
    { label: 'Nieto/a' },
    { label: 'Tío/a' },
    { label: 'Sobrino/a' },
    { label: 'Primo/a' },
    { label: 'Yerno/Nuera' },
    { label: 'Suegro/a' },
    { label: 'Padrastro/Madrastra' },
    { label: 'Hermanastro/a' },
    { label: 'Amigo/a' },
    { label: 'Colega' },
    { label: 'Vecino/a' },
    { label: 'Pareja (no casados)' },
    { label: 'Novio/a' },
    { label: 'Compañero/a de cuarto' },
    { label: 'Otro' }
];

const EstatusMigratorio = [
    { label: 'Ciudadano/a' },
    { label: 'Residente Permanente' },
    { label: 'Visa de Trabajo' },
    { label: 'Visa de Estudiante' },
    { label: 'Refugiado/a o Asilado/a' },
    { label: 'Sin Documentos' },
    { label: 'En Proceso de Naturalización' },
    { label: 'Otro Estatus Migratorio' },
    { label: 'Desconocido' }
];

$(function () {
    Parentescos.forEach(function (option) {
        $('.cbParentescos').append(
            $('<option>', {
                value: option.label,
                text: option.label
            })
        );
    });

    EstatusMigratorio.forEach(function (option) {
        $('.cbEstatusMigratorio').append(
            $('<option>', {
                value: option.label,
                text: option.label
            })
        );
    });

    cargarPaises();

    cargarSucursales();

    $('.select2').select2({
        placeholder: 'Seleccione una opción',
        theme: 'bootstrap-5',
        width: '100%'
    });

    // Forzar la validación en Select2 al cambiar
    $('.select2').on('change', function () {
        $(this).valid();
    });

    $('#cbTipoVisa').select2({
        placeholder: 'Seleccione una opción',
        theme: 'bootstrap-5',
        width: '100%',
        templateResult: function (data) {
            if (!data.id) {
                return data.text;
            }
            var $option = $(
                '<span>' +
                    data.id +
                    ' </span><small class="text-muted ms-2">' +
                    data.element.dataset.proposito +
                    '</small>'
            );
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
                $('#cbNacionalidad').append(
                    $('<option>', {
                        value: country.translations.spa.common,
                        text: country.translations.spa.common
                    })
                );
            });

            $('#cbNacionalidad').select2({
                placeholder: 'Seleccione una opción',
                theme: 'bootstrap-5',
                width: '100%'
            });
        },
        error: function (error) {
            console.log('Error al obtener los países: ', error);
        }
    });

    $('.flatpickr').flatpickr();

    $('.muestraMasInformacion').on('change', function () {
        const $ck = $(this);
        const $target = $($ck.data('target'));
        const muestraInformacion = $ck.data('display');

        if (muestraInformacion === 1) {
            $target.attr('hidden', false);
        } else {
            $target.attr('hidden', true);
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
        .on('submit', function (e) {
            e.preventDefault();
            const $frm = $(this);
            let formData = $frm.serializeObject();

            if (formData.fuente_informacion) {
                if ($.isArray(formData.fuente_informacion)) {
                    formData.fuente_informacion = formData.fuente_informacion.join('|');
                }
            } else {
                formData.fuente_informacion = '';
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
                birthState: formData.beneficiario_estado,
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

            console.log(dataCliente, formData);

            if ($frm.valid()) {
                guardarIntake(formData).then(function (r) {
                    if (!r.success) {
                        swal.fire('¡Oops! Algo salió mal.', r.message, 'error');
                    } else {
                        addClient(dataCliente);

                        $('#formContainer').hide();
                        $('#mensajeCorrecto').fadeIn();
                    }
                });
            }

            return false;
        })
        .validate();

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
    if (edad < 21) {
        return true;
    } else {
        return false;
    }
}

function guardarIntake(data) {
    return $.ajax({
        type: 'post',
        url: baseUrl + 'intake/guardar',
        data: data,
        dataType: 'json'
    });
}

function addClient(data) {
    const lawFirmLocationID = data.lawFirmLocationID;

    return $.ajax({
        url: `${baseUrl}api/addClient`,
        type: 'POST',
        data: JSON.stringify(data),
        dataType: 'json',
        contentType: 'application/json',
        success: function (r) {
            actualizarClientID(data.id_cliente, r.clientID);
            createCase(r.clientID, lawFirmLocationID);
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function createCase(clientID, lawFirmLocationID) {
    var caseData = {
        autoGenerateCaseNumber: true,
        clientID: clientID,
        caseID: 0,
        applicationText: 'Aplicación inicial para revisión',
        caseCategoryID: null,
        caseName: 'Intake',
        caseNumber: `CONSULTA CN-${clientID}-001`,
        //"creationDate": "2024-03-26T18:46:47.217Z",
        denialText: null,
        expirationText: null,
        externalCaseID: null,
        externalCaseNumber: null,
        filingTypeID: null,
        physicalDocumentLocationID: null,
        processID: 167,
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
            addCaseParty(r.caseID, clientID);
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
        clientName: clientName,
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

//GeneralAPI
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

                $select.append(
                    $('<option>', {
                        value: '',
                        text: 'Seleccione un país'
                    })
                );

                $.each(response, function (i, country) {
                    $select.append(
                        $('<option>', {
                            value: country.name,
                            text: country.name
                        })
                    );
                });

                $select.select2({
                    placeholder: 'Seleccione una opción',
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

            $select.append(
                $('<option>', {
                    value: '',
                    text: 'Seleccione una sucursal'
                })
            );

            const data = response.totalCount > 0 ? response.data : [];

            $.each(data, function (i, option) {
                $select.append(
                    $('<option>', {
                        value: option.lawFirmLocationID,
                        text: option.name
                    })
                );
            });

            $select.select2({
                placeholder: 'Seleccione una opción',
                theme: 'bootstrap-5',
                width: '100%'
            });
        },
        error: function (xhr, status, error) {
            console.error('Error al cargar los países: ' + error);
        }
    });
}

function actualizarClientID(id_cliente, clientID) {
    const data = {
        id_cliente: id_cliente,
        clientID: clientID
    };

    return $.ajax({
        type: 'post',
        url: baseUrl + 'clientes/clientid',
        data: data,
        dataType: 'json'
    });
}
