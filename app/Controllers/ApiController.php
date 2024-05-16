<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class ApiController extends Controller
{
    use ResponseTrait;

    private function getToken()
    {
        $client = \Config\Services::curlrequest();

        $data = [
            'username' => 'Alejandro',
            'password' => 'Agijon1',
        ];

        $response = $client->request('POST', 'https://www.eimmigration.com/vfmlaw/api/Account/token', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data,
        ]);

        if ($response->getStatusCode() !== 200) {
            return $this->failServerError('Error al obtener el token: ' . $response->getBody());
        }

        return json_decode($response->getBody(), true);
    }

    public function getClients()
    {
        $tokenData = $this->getToken();

        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        $token = $tokenData['token'];

        $client = \Config\Services::curlrequest();

        // Recoger los parámetros de la URL
        $params = $this->request->getGet();

        $response = $client->request('GET', 'https://www.eimmigration.com/VFMLaw/api/v1/Clients', [
            'headers' => [
                'Content-Type' => 'text/plain',
                'Authorization' => 'Bearer ' . $token,
            ],
            'query' => $params, // Añadir los parámetros a la solicitud
        ]);

        if ($response->getStatusCode() !== 200) {
            return $this->failServerError('Error al obtener la lista de clientes: ' . $response->getBody());
        }

        return $this->respond(json_decode($response->getBody(), true));
    }

    public function getClientInfo($clientId)
    {
        // Obtener el token utilizando la función privada
        $tokenData = $this->getToken();

        // Verificar la existencia de la clave 'token'
        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        // Obtener el token
        $token = $tokenData['token'];

        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'https://www.eimmigration.com/VFMLaw/api/v1/Clients/' . $clientId, [
            'headers' => [
                'Content-Type' => 'text/plain',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        // Devolver la respuesta según el estado de la solicitud
        if ($response->getStatusCode() !== 200) {
            return $this->failServerError('Error al obtener la información del cliente: ' . $response->getBody());
        }

        return $this->respond(json_decode($response->getBody(), true));
    }

    public function addClient()
    {
        $tokenData = $this->getToken();

        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        $token = $tokenData['token'];
        $clientData = $this->request->getJSON(true);

        if (empty($clientData)) {
            return $this->failValidationError('Los datos del cliente no pueden estar vacíos');
        }

        $client = \Config\Services::curlrequest();
        $autoGenerateClientNumber = false;

        $response = $client->request('POST', 'https://www.eimmigration.com/VFMLaw/api/v1/Clients?autoGenerateClientNumber=' . $autoGenerateClientNumber, [
            'headers' => [
                'Content-Type' => 'application/json-patch+json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => $clientData,
        ]);


        if ($response->getStatusCode() === 201) {
            $clientCreatedData = json_decode($response->getBody(), true);
            $clientID = $clientCreatedData['clientID'] ?? null;

            // Verificamos si hay un lawFirmLocationID en los datos enviados
            if (isset($clientData['lawFirmLocationID']) && $clientID) {
                // Si existe, llamamos a addLawFirmLocationToClient
                return $this->addLawFirmLocationToClient($clientID, $clientData['lawFirmLocationID']);
            }

            // Si no hay lawFirmLocationID o no se creó el cliente, devolvemos la respuesta del cliente creado
            return $this->respond($clientCreatedData);
        } else {

            return $this->failServerError('Error al agregar el cliente: ' . $response->getBody());
        }
    }


    public function addLawFirmLocationToClient($clientID, $lawFirmLocationID)
    {
        $tokenData = $this->getToken();

        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        $token = $tokenData['token'];
        $client = \Config\Services::curlrequest();

        $requestData = ['lawFirmLocationID' => $lawFirmLocationID];

        $response = $client->request('POST', "https://www.eimmigration.com/VFMLaw/api/v1/Clients/{$clientID}/LawFirmLocation", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json-patch+json',
                'Accept' => 'text/plain',
            ],
            'json' => $requestData,
        ]);

        if ($response->getStatusCode() === 201) {
            return $this->respond(json_decode($response->getBody(), true));
        } elseif (in_array($response->getStatusCode(), [400, 401, 403, 404, 409])) {
            return $this->fail($response->getBody(), $response->getStatusCode());
        } else {
            return $this->failServerError('Estatus: ' . $response->getStatusCode() . ' Error desconocido al añadir la ubicación de la firma de abogados al cliente: ' . $response->getBody());
        }
    }

    public function editClient($clientID)
    {
        // Obtener el token utilizando la función privada
        $tokenData = $this->getToken();

        // Verificar la existencia de la clave 'token'
        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        // Obtener el token
        $token = $tokenData['token'];

        // Obtener los datos actualizados del cliente del cuerpo de la solicitud
        $clientData = $this->request->getJSON(true);

        // Asegurarse de que los datos del cliente no estén vacíos
        if (empty($clientData)) {
            return $this->failValidationError('Los datos del cliente no pueden estar vacíos');
        }

        $client = \Config\Services::curlrequest();

        $response = $client->request('PUT', "https://www.eimmigration.com/VFMLaw/api/v1/Clients/{$clientID}", [
            'headers' => [
                'Content-Type' => 'application/json-patch+json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => $clientData,
        ]);

        echo json_encode($clientID);
        exit();
        // Devolver la respuesta según el estado de la solicitud
        if ($response->getStatusCode() !== 200) {
            // Manejar el error de manera más detallada
            $errorDetails = json_decode($response->getBody(), true);
            return $this->failServerError('Error al editar el cliente: ' . $errorDetails['message']);
        }

        return $this->respond(json_decode($response->getBody(), true));
    }

    public function deleteClient($clientID)
    {
        $tokenData = $this->getToken();

        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        $token = $tokenData['token'];

        $client = \Config\Services::curlrequest();

        $response = $client->request('DELETE', 'https://www.eimmigration.com/VFMLaw/api/v1/Clients/' . $clientID, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        echo "<pre>" . print_r($response, true) . "</pre>";
        exit("test");

        if ($response->getStatusCode() === 204) {
            // Cliente eliminado exitosamente
            return $this->respondDeleted();
        } elseif ($response->getStatusCode() === 404) {
            // Cliente no encontrado
            return $this->failNotFound('Cliente no encontrado');
        } elseif ($response->getStatusCode() === 403) {
            // No autorizado para eliminar el cliente
            return $this->failForbidden('No autorizado para eliminar el cliente');
        } else {
            // Otro error
            return $this->failServerError('Error al eliminar el cliente: ' . $response->getBody());
        }
    }

    public function getClientInvoices($tenant, $clientID)
    {
        // Obtener el token utilizando la función privada
        $tokenData = $this->getToken();

        // Verificar la existencia de la clave 'token'
        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        // Obtener el token
        $token = $tokenData['token'];

        $client = \Config\Services::curlrequest();

        // Construir la URL para la solicitud GET
        $url = "https://www.eimmigration.com/{$tenant}/api/v1/Clients/{$clientID}/Invoices";

        // Realizar la solicitud GET
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
        ]);

        // Verificar el código de estado de la respuesta
        if ($response->getStatusCode() === 200) {
            // La solicitud fue exitosa, devolver las facturas del cliente
            return $this->respond(json_decode($response->getBody(), true));
        } elseif ($response->getStatusCode() === 404) {
            // No se encontró el cliente
            return $this->failNotFound('Cliente no encontrado');
        } elseif ($response->getStatusCode() === 403) {
            // El usuario no tiene derechos de acceso
            return $this->failForbidden('Acceso denegado');
        } else {
            // Otro código de estado, manejar como error del servidor
            return $this->failServerError('Error al obtener las facturas del cliente: ' . $response->getBody());
        }
    }

    public function createCase($caseData)
    {
        // Asegurar que tenemos un token válido
        $tokenData = $this->getToken();
        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        // Asegurar que el payload del caso no está vacío
        $clientData = $this->request->getJSON(true);

        if (empty($clientData)) {
            return $this->failValidationError('Los datos del caso no pueden estar vacíos');
        }

        // Preparar el cliente HTTP
        $client = \Config\Services::curlrequest();
        $token = $tokenData['token'];
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json-patch+json', // Asegurar el Content-Type adecuado
            'Accept' => 'text/plain' // Aceptar respuesta como texto plano según la doc
        ];

        // Realizar la solicitud POST al endpoint de la API para crear un caso
        try {
            $response = $client->request('POST', "https://www.eimmigration.com/VFMLaw/api/v1/Cases", [
                'headers' => $headers,
                'json' => $clientData,
            ]);

            // Verificar el código de estado HTTP para determinar el resultado de la solicitud
            if ($response->getStatusCode() === 201) {
                return $this->respondCreated(json_decode($response->getBody(), true)); // Caso creado con éxito
            } else {
                // Manejar otros códigos de estado HTTP según sea necesario
                return $this->failServerError('Error al crear el caso: ' . $response->getBody());
            }
        } catch (\Exception $e) {
            // Capturar y manejar excepciones, como problemas de red o de configuración
            return $this->failServerError('Excepción al crear el caso: ' . $e->getMessage());
        }
    }

    public function addCaseParty($caseID)
    {
        $tokenData = $this->getToken();
        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        $token = $tokenData['token'];
        $tenant = 'VFMLaw'; // Valor fijo para tenant

        // Asumiendo que recibes los datos de la parte del caso en el cuerpo de la petición
        $partyData = $this->request->getJSON(true);

        if (empty($partyData)) {
            return $this->failValidationError('Los datos de la parte del caso no pueden estar vacíos');
        }

        $client = \Config\Services::curlrequest();

        $response = $client->request('POST', "https://www.eimmigration.com/{$tenant}/api/v1/Cases/{$caseID}/Parties", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json-patch+json',
                'Accept' => 'text/plain',
            ],
            'json' => $partyData,
        ]);

        if ($response->getStatusCode() === 200 || $response->getStatusCode() === 201) {
            return $this->respondCreated(json_decode($response->getBody(), true));
        } else {
            return $this->failServerError('Error al crear la parte del caso: ' . $response->getBody());
        }
    }
    //Lista de países 
    public function getWorldCountries()
    {
        $tokenData = $this->getToken();

        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        $token = $tokenData['token'];

        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'https://www.eimmigration.com/VFMLaw/api/v1/WorldCountries', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json', // Asegúrate de aceptar JSON
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            return $this->failServerError('Error al obtener la lista de países: ' . $response->getBody());
        }

        return $this->respond(json_decode($response->getBody(), true));
    }

    //Sucursales
    public function getLawFirmLocations()
    {
        $tokenData = $this->getToken();

        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        $token = $tokenData['token'];

        $client = \Config\Services::curlrequest();

        // Aquí puedes ajustar los parámetros según necesites
        $params = [
            'skip' => 0,
            'take' => 100,
            'orderBy' => 'Name ASC, City ASC',
            // 'name' => 'opcional', // Si necesitas filtrar por nombre
            // 'city' => 'opcional', // Si necesitas filtrar por ciudad
        ];

        $response = $client->request('GET', 'https://www.eimmigration.com/VFMLaw/api/v1/LawFirmLocations', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'text/plain',
            ],
            'query' => $params,
        ]);

        if ($response->getStatusCode() !== 200) {
            return $this->failServerError('Error al obtener las ubicaciones de la firma de abogados: ' . $response->getBody());
        }

        return $this->respond(json_decode($response->getBody(), true));
    }
    //Lista de procesos de casos
    public function getCaseProcesses()
    {
        $tokenData = $this->getToken();

        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        $client = \Config\Services::curlrequest();
        $token = $tokenData['token'];

        $queryParams = [
            'skip' => 0,
            'take' => 200
        ];


        $response = $client->request('GET', 'https://www.eimmigration.com/VFMLaw/api/v1/CaseProcesses', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
            'query' => $queryParams
        ]);

        if ($response->getStatusCode() === 200) {
            return $this->respond(json_decode($response->getBody(), true));
        } else {
            return $this->failServerError('Error al obtener los procesos de casos: ' . $response->getBody());
        }
    }

    // Nuevo método para actualizar un campo personalizado de un caso
    public function updateCustomField($caseID, $customFieldID)
    {
        $tokenData = $this->getToken();

        if (!isset($tokenData['token'])) {
            return $this->failServerError('Error al obtener el token');
        }

        $token = $tokenData['token'];

        $client = \Config\Services::curlrequest();

        $customFieldData = $this->request->getJSON(true);

        if (empty($customFieldData)) {
            return $this->failValidationError('Los datos del campo personalizado no pueden estar vacíos');
        }

        $response = $client->request('PUT', "https://www.eimmigration.com/VFMLaw/api/v1/Cases/{$caseID}/CustomFields/{$customFieldID}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json-patch+json',
                'Accept' => 'text/plain',
            ],
            'json' => $customFieldData,
        ]);
        echo print_r($response);
        exit();

        // Verificar el código de estado de la respuesta
        if ($response->getStatusCode() === 200) {
            // La actualización fue exitosa
            return $this->respond(json_decode($response->getBody(), true));
        } else {
            // Otro código de estado, manejar como error del servidor
            return $this->failServerError('Error al actualizar el campo personalizado: ' . $response->getBody());
        }
    }
}
