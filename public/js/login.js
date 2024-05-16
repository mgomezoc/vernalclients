/**
 * 
 * LOGIN
 * 
 */

// Inicializa reCAPTCHA con tu clave de sitio
grecaptcha.ready(function () {
    grecaptcha.execute('6Lec0ccnAAAAAKFUlFpz2MPD2ZjV2YKC14-0l0KV', { action: 'login' })
        .then(function (token) {
            // Agrega el token a un campo oculto en el formulario
            document.getElementById('recaptchaToken').value = token;
        });
});


$(function () {
    $("#frmLogin").validate();
});

let DATA;
function GetClients(data) {
    var skip = 1000;
    var take = 100;
    var orderBy = '';
    var name1 = '';
    var name2 = '';
    var name3 = '';
    var fullName = '';
    var email = '';
    var ssn = '';
    var dayphone = '';
    var birthDate = '';
    var aNumber = '';
    var lawFirmLocationID = 1;
    var typeID = 0;
    var statusID = 0;
    var creationDateGte = '';
    var creationDateLte = '';
    var updateDateGte = '';
    var updateDateLte = '';
    var createdBy = '';
    var lastUpdatedBy = '';

    return $.ajax({
        url: `${baseUrl}api/getClients`,
        type: 'GET',
        data: data,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            DATA = data;
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });

}

function addClient() {
    let data = {
        "typeID": 0,
        "name1": "Mya",
        "name2": "Nallely",
        "name3": "Galarza",
        "sexID": 1,
        autoGenerateClientNumber: false
    };

    return $.ajax({
        url: `${baseUrl}api/addClient`,
        type: 'POST',
        data: JSON.stringify(data),
        dataType: 'json',
        contentType: 'application/json',
        success: function (data) {
            console.log(data);
            DATA = data;
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function deleteClient(clientID) {
    return $.ajax({
        url: `${baseUrl}api/deleteClient/${clientID}`,
        type: 'DELETE',
        dataType: 'json',
        success: function (data) {
            console.log('Cliente eliminado exitosamente');
            // Agrega aquí la lógica para actualizar la interfaz de usuario si es necesario
        },
        error: function (error) {
            console.error('Error al eliminar el cliente:', error);
            // Agrega aquí la lógica para manejar errores y mostrar mensajes al usuario si es necesario
        }
    });
}

function editarCliente(clienteID, datosDelCliente) {
    return $.ajax({
        url: `${baseUrl}/api/editClient/${clienteID}`,
        type: 'POST', // Usamos POST aquí
        data: JSON.stringify(datosDelCliente),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function (response) {
            console.log(response); // Manejar la respuesta exitosa
        },
        error: function (xhr, status, error) {
            console.error(error); // Manejar errores
        }
    });
}

function getClientInvoices(clientID) {
    const tenant = "VFMLaw";
    return $.ajax({
        url: `${baseUrl}/api/${tenant}/getInvoices/${clientID}`,
        type: 'GET',
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function (response) {
            console.log(response); // Manejar la respuesta exitosa
        },
        error: function (xhr, status, error) {
            console.error(error); // Manejar errores
        }
    });
}


function CreateCase(caseData) {
    return $.ajax({
        url: `${baseUrl}api/createCase`,
        type: 'POST',
        contentType: 'application/json-patch+json', // Asegúrate de que este contentType coincida con lo requerido por tu API
        data: JSON.stringify(caseData),
        dataType: 'json', // Esperamos recibir una respuesta JSON
        success: function (data) {
            console.log('Case created successfully:', data);
            // Aquí puedes implementar lo que desees hacer con la respuesta exitosa
        },
        error: function (error) {
            console.error('Error creating case:', error);
        }
    });
}

var caseData = {
    "autoGenerateCaseNumber": true,
    "clientID": "42644",
    "caseID": 0,
    "applicationText": "Aplicación inicial para revisión",
    "caseCategoryID": null,
    "caseName": "Intake",
    "caseNumber": "CN-42644-001",
    //"creationDate": "2024-03-26T18:46:47.217Z",
    "denialText": null,
    "expirationText": null,
    "externalCaseID": null,
    "externalCaseNumber": null,
    "filingTypeID": null,
    "physicalDocumentLocationID": 1,
    "processID": 167,
    "areaOfPracticeID": 1,
    "processingText": null,
    "statusChangeComment": null,
    //"statusChangeDate": "2024-03-26T18:46:47.217Z",
    "statusID": 0,
    //"updateDate": "2024-03-26T18:46:47.217Z",
    "incidentText": null,
    "statuteOfLimitationText": null,
    "incidentLocation": null,
    "note": null,
    "case_Client": 42644,
    "lawFirmLocationID": 1,
    "mainPartyID": 42644,

};

var caseData2 = {
    "caseID": 0,
    "applicationText": null,
    "caseCategoryID": null,
    "caseName": null,
    "caseNumber": "11226",
    "createdBy": "Alejandro",
    "denialText": null,
    "expirationText": null,
    "externalCaseID": null,
    "externalCaseNumber": null,
    "filingTypeID": null,
    "physicalDocumentLocationID": null,
    "processID": 167,
    "areaOfPracticeID": 1,
    "processingText": null,
    "statusChangeComment": null,
    "statusID": 0,
    "lastUpdatedBy": "Alejandro",
    "incidentText": null,
    "statuteOfLimitationText": null,
    "incidentLocation": null,
    "note": null,
    "process": {
        "processID": 167,
        "disabled": false,
        "name": "Consultation / Cita",
        "orderNumber": 0
    },
    "status": {
        "statusID": 0,
        "name": "Active"
    }
};

const caseData3 = {
    "applicationText": "Consulta inicial para evaluación de caso",
    "caseCategoryID": null,
    "caseName": "Consulta Legal para Mya Nallely Viera GALARZA",
    "caseNumber": null,
    "creationDate": "2024-04-01T13:21:25.873Z",
    "createdBy": "Alejandro",
    "denialText": null,
    "expirationText": null,
    "externalCaseID": null,
    "externalCaseNumber": null,
    "filingTypeID": null,
    "physicalDocumentLocationID": null,
    "processID": 167,
    "areaOfPracticeID": 1,
    "processingText": null,
    "statusChangeComment": "Caso abierto para revisión inicial",
    "statusChangeDate": "2024-04-01T13:21:25.873Z",
    "statusID": 0,
    "updateDate": "2024-04-01T13:21:25.873Z",
    "lastUpdatedBy": "Alejandro",
    "incidentText": null,
    "statuteOfLimitationText": null,
    "incidentLocation": null,
    "note": "Cliente interesado en evaluación de opciones legales para inmigración.",
    "caseCategory": null,
    "filingType": null,
    "physicalDocumentLocation": null,
    "process": {
        "processID": 167,
        "disabled": false,
        "name": "Consultation / Cita",
        "orderNumber": 0,
        "updateDate": "2023-02-18T00:27:04.643",
        "areaOfPracticeID": 1,
        "areaOfPractice": null
    },
    "status": {
        "statusID": 0,
        "name": "Active"
    }
};



function addCaseParty(caseID, partyData) {
    return $.ajax({
        url: `${baseUrl}api/addCaseParty/${caseID}`,
        type: 'POST',
        contentType: 'application/json-patch+json',
        data: JSON.stringify(partyData),
        dataType: 'json',
        success: function (data) {
            console.log('Case created successfully:', data);
        },
        error: function (error) {
            console.error('Error creating case:', error);
        }
    });
}

// Ejemplo de cómo utilizar la función addCaseParty
var partyData = {
    "clientID": 42644,
    "caseID": 28942,
    "clientName": "Mya Nallely Viera GALARZA",
    "clientTypeID": 0,
    "isMainParty": true,
    "roleID": 8,
    "addressID": null,
    "address": "",
    "signatoryID": null,
    "signatory": "",
    "clientType": {
        "typeID": 0,
        "name": "Individual"
    },
    "role": {
        "roleID": 8,
        "name": "Beneficiary"
    }
};

//addCaseParty(28826, partyData);



