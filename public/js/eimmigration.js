/**
 * EIMMIGRATION
 * Archivo para gestionar las interacciones con la API de eImmigration.
 * Implementa las funciones para consumir los endpoints de ApiController.
 */

const eimmigrationUrls = {
    getClients: `${baseUrl}api/getClients`,
    getClientInfo: (clientId) => `${baseUrl}api/getClientInfo/${clientId}`,
    addClient: `${baseUrl}api/addClient`,
    editClient: (clientId) => `${baseUrl}api/editClient/${clientId}`,
    deleteClient: (clientId) => `${baseUrl}api/deleteClient/${clientId}`,
    getInvoices: (tenant, clientId) => `${baseUrl}api/${tenant}/getInvoices/${clientId}`,
    createCase: `${baseUrl}api/createCase`,
    addCaseParty: (caseId) => `${baseUrl}api/addCaseParty/${caseId}`,
    getWorldCountries: `${baseUrl}api/worldCountries`,
    getLawFirmLocations: `${baseUrl}api/lawFirmLocations`,
    getCaseProcesses: `${baseUrl}api/caseProcesses`,
    updateCustomField: (caseId, customFieldId) => `${baseUrl}api/updateCustomField/${caseId}/${customFieldId}`
};

/**
 * Realiza una solicitud a la API de eImmigration.
 * @param {Object} options - Configuración para la solicitud AJAX.
 * @returns {Promise} Promesa que resuelve la respuesta de la API.
 */
async function apiRequest(options) {
    try {
        const response = await $.ajax(options);
        return response;
    } catch (error) {
        console.error(`Error en la solicitud: ${options.url}`, error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un problema al procesar la solicitud. Intente nuevamente.',
            confirmButtonText: 'Aceptar'
        });
        throw error;
    }
}

/**
 * Obtiene la lista de clientes.
 * @param {Object} params - Parámetros de la solicitud.
 * @returns {Promise<Object[]>} Lista de clientes.
 */
async function getClients(params = {}) {
    return apiRequest({
        url: eimmigrationUrls.getClients,
        type: 'GET',
        data: params,
        dataType: 'json'
    });
}

/**
 * Obtiene la información de un cliente específico.
 * @param {number} clientId - ID del cliente.
 * @returns {Promise<Object>} Información del cliente.
 */
async function getClientInfo(clientId) {
    return apiRequest({
        url: eimmigrationUrls.getClientInfo(clientId),
        type: 'GET',
        dataType: 'json'
    });
}

/**
 * Crea un nuevo cliente.
 * @param {Object} clientData - Datos del cliente.
 * @returns {Promise<Object>} Respuesta de la creación.
 */
async function addClient(clientData) {
    return apiRequest({
        url: eimmigrationUrls.addClient,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(clientData),
        dataType: 'json'
    });
}

/**
 * Edita un cliente existente.
 * @param {number} clientId - ID del cliente.
 * @param {Object} clientData - Datos actualizados del cliente.
 * @returns {Promise<Object>} Respuesta de la edición.
 */
async function editClient(clientId, clientData) {
    return apiRequest({
        url: eimmigrationUrls.editClient(clientId),
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(clientData),
        dataType: 'json'
    });
}

/**
 * Elimina un cliente.
 * @param {number} clientId - ID del cliente.
 * @returns {Promise<void>} Respuesta de la eliminación.
 */
async function deleteClient(clientId) {
    return apiRequest({
        url: eimmigrationUrls.deleteClient(clientId),
        type: 'DELETE',
        dataType: 'json'
    });
}

/**
 * Crea un nuevo caso.
 * @param {Object} caseData - Datos del caso.
 * @returns {Promise<Object>} Respuesta de la creación del caso.
 */
async function createCase(caseData) {
    return apiRequest({
        url: eimmigrationUrls.createCase,
        type: 'POST',
        contentType: 'application/json-patch+json',
        data: JSON.stringify(caseData),
        dataType: 'json'
    });
}

/**
 * Agrega una parte a un caso existente.
 * @param {number} caseId - ID del caso.
 * @param {Object} partyData - Datos de la parte.
 * @returns {Promise<Object>} Respuesta de la adición de la parte.
 */
async function addCaseParty(caseId, partyData) {
    return apiRequest({
        url: eimmigrationUrls.addCaseParty(caseId),
        type: 'POST',
        contentType: 'application/json-patch+json',
        data: JSON.stringify(partyData),
        dataType: 'json'
    });
}

/**
 * Obtiene los procesos de casos disponibles.
 * @returns {Promise<Object[]>} Lista de procesos de casos.
 */
async function getCaseProcesses() {
    return apiRequest({
        url: eimmigrationUrls.getCaseProcesses,
        type: 'GET',
        dataType: 'json'
    });
}

/**
 * Actualiza un campo personalizado en un caso.
 * @param {number} caseId - ID del caso.
 * @param {number} customFieldId - ID del campo personalizado.
 * @param {Object} customFieldData - Datos del campo personalizado.
 * @returns {Promise<Object>} Respuesta de la actualización.
 */
async function updateCustomField(caseId, customFieldId, customFieldData) {
    return apiRequest({
        url: eimmigrationUrls.updateCustomField(caseId, customFieldId),
        type: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(customFieldData),
        dataType: 'json'
    });
}

/**
 * Obtiene la lista de países.
 * @returns {Promise<Object[]>} Lista de países.
 */
async function getWorldCountries() {
    return apiRequest({
        url: eimmigrationUrls.getWorldCountries,
        type: 'GET',
        dataType: 'json'
    });
}

/**
 * Obtiene la lista de ubicaciones de firmas de abogados.
 * @returns {Promise<Object[]>} Lista de ubicaciones.
 */
async function getLawFirmLocations() {
    return apiRequest({
        url: eimmigrationUrls.getLawFirmLocations,
        type: 'GET',
        dataType: 'json'
    });
}

/**
 * Obtiene las facturas de un cliente específico.
 * @param {string} tenant - Nombre del tenant.
 * @param {number} clientId - ID del cliente.
 * @returns {Promise<Object[]>} Lista de facturas.
 */
async function getClientInvoices(tenant, clientId) {
    return apiRequest({
        url: eimmigrationUrls.getInvoices(tenant, clientId),
        type: 'GET',
        dataType: 'json'
    });
}
