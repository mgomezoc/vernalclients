<?php

namespace App\Controllers;

use App\Models\AbogadoModel;
use App\Models\CasoModel;
use App\Models\CasosTiposModel;
use App\Models\ClienteAbogadoModel;
use App\Models\ClienteEstatusModel;
use App\Models\ClienteModel;
use App\Models\FormularioAdmisionModel;
use App\Models\SucursalModel;
use App\Models\UsuarioModel;

class ClientesController extends BaseController
{
    public function __construct()
    {
        helper('auditoria'); // Cargar el helper de auditoría para registrar acciones
    }

    public function index()
    {
        $data["title"] = "Clientes";

        $abogadoModel = new AbogadoModel();
        $usuarioModel = new UsuarioModel();
        $sucursalModel = new SucursalModel();
        $estatusModel = new ClienteEstatusModel();

        $data['abogados'] = $abogadoModel->obtenerAbogadosConInfo();
        $data['paralegales'] = $usuarioModel->getUsuariosPorPerfiles([3]);
        $data['sucursales'] = $sucursalModel->obtenerTodas();
        $data['estatus'] = $estatusModel->obtenerTodosEstatus();

        // Registrar acción de visualización de clientes
        $usuario = session()->get('usuario');
        if ($usuario) {
            registrarAccion($usuario['id'], 'view_clients', 'El usuario visualizó la lista de clientes.');
        }

        $data['renderBody'] = $this->render("clientes/index", $data);

        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">';

        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/flatpickr'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/clientes.js") . "'></script>";

        return $this->render('shared/layout', $data);
    }

    public function recepcion()
    {
        $data["title"] = "Clientes";

        // Cargar modelos
        $abogadoModel = new AbogadoModel();
        $usuarioModel = new UsuarioModel();
        $sucursalModel = new SucursalModel();
        $estatusModel = new ClienteEstatusModel();

        // Obtener datos necesarios
        $data['abogados'] = $abogadoModel->obtenerAbogadosConInfo();
        $data['paralegales'] = $usuarioModel->getUsuariosPorPerfiles([3]);
        $data['sucursales'] = $sucursalModel->obtenerTodas();
        $data['estatus'] = $estatusModel->obtenerTodosEstatus();

        // Registrar acción de visualización de clientes en recepción
        $usuario = session()->get('usuario');
        if ($usuario) {
            registrarAccion($usuario['id'], 'view_clients_reception', 'El usuario visualizó la lista de clientes en recepción.');
        }

        // Renderizar la vista de recepción
        $data['renderBody'] = $this->render("clientes/recepcion", $data);

        // Incluir estilos necesarios
        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">';

        // Incluir scripts necesarios
        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/flatpickr'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/clientes_recepcion.js") . "'></script>";

        return $this->render('shared/layout', $data);
    }


    public function obtenerClientes()
    {
        $clienteModel = new ClienteModel();
        $postData = json_decode($this->request->getBody(), true);

        $limit = $postData['limit'] ?? 10;
        $offset = $postData['offset'] ?? 0;
        $filtros = [
            'tipo' => $postData['tipo'] ?? '',
            'sucursal' => $postData['sucursal'] ?? '',
            'estatus' => $postData['estatus'] ?? '',
            'periodo' => $postData['periodo'] ?? ''
        ];

        $result = $clienteModel->obtenerClientesPaginados($limit, $offset, $filtros);

        // Agregar lógica para determinar si puede crear un caso
        $estatusPermitidos = [2, 3, 8]; // Intake, Asignado, Por Asignar

        foreach ($result['rows'] as &$cliente) {
            $cliente['puedeCrearCaso'] = in_array($cliente['estatus'], $estatusPermitidos);
        }

        return $this->response->setJSON($result);
    }


    public function obtenerClientesRecepcion()
    {
        $clienteModel = new ClienteModel();
        $postData = json_decode($this->request->getBody(), true);

        $limit = $postData['limit'] ?? 10;
        $offset = $postData['offset'] ?? 0;
        $filtros = [
            'tipo' => $postData['tipo'] ?? '',
            'sucursal' => $postData['sucursal'] ?? '',
            'estatus' => $postData['estatus'] !== '' ? $postData['estatus'] : [2, 4, 8], // Si 'estatus' está vacío, usar [2, 4, 8]
            'periodo' => $postData['periodo'] ?? ''
        ];

        $result = $clienteModel->obtenerClientesPaginados($limit, $offset, $filtros);

        return $this->response->setJSON($result);
    }



    public function obtenerClientesAbogado()
    {
        $usuario = session("usuario");
        $data['usuario'] = $usuario;

        $idAbogado = $usuario["id"];

        $clienteModel = new ClienteModel();
        $clientes = $clienteModel->obtenerTodosClientesAbogado($idAbogado);

        // Registrar acción de visualización de clientes asignados al abogado
        if ($usuario) {
            registrarAccion($usuario['id'], 'view_assigned_clients', 'El abogado visualizó la lista de clientes asignados.');
        }

        return $this->response->setJSON($clientes);
    }

    public function asignarAbogado()
    {
        $clienteModel = new ClienteModel();
        $clienteAbogadoModel = new ClienteAbogadoModel();

        $idCliente = $this->request->getPost('id_cliente');
        $idAbogado = $this->request->getPost('id_abogado');
        $nuevoEstatus = 3; // Establecer el estatus como "Asignado"

        // Validar que el cliente y el abogado/usuario existan
        $cliente = $clienteModel->find($idCliente);
        $abogado = $this->obtenerUsuarioPorId($idAbogado); // Método que busca al abogado/usuario por ID

        if (!$cliente) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cliente no encontrado.'
            ]);
        }

        if (!$abogado) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Abogado o usuario no encontrado.'
            ]);
        }

        // Iniciar la transacción para asegurar atomicidad
        $db = \Config\Database::connect();
        $db->transStart();

        // Eliminar todas las relaciones previas del cliente
        $clienteAbogadoModel->where('id_cliente', $idCliente)->delete();

        // Asignar la nueva relación
        $data = [
            'id_cliente' => $idCliente,
            'id_usuario' => $idAbogado,
            'fecha_asignacion' => date('Y-m-d H:i:s'),
            'estatus_relacion' => 1
        ];

        if ($clienteAbogadoModel->insert($data)) {
            // Actualizar el estatus del cliente
            $clienteModel->actualizarEstatusCliente($idCliente, $nuevoEstatus);

            // Completar la transacción
            $db->transComplete();

            if ($db->transStatus() === false) {
                // Error en la transacción, revertir
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ocurrió un error durante la asignación. Por favor, intente de nuevo.'
                ]);
            }

            // Registrar acción de asignación de abogado
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'assign_lawyer', "El usuario asignó al abogado ID $idAbogado al cliente ID $idCliente.");
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Se actualizó correctamente el estatus del cliente y se asignó el abogado.'
            ]);
        } else {
            // Error al guardar la nueva relación
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Ocurrió un error al asignar el abogado al cliente.'
            ]);
        }
    }

    /**
     * Función auxiliar para obtener un usuario (abogado) por ID
     *
     * @param int $idAbogado
     * @return array|null
     */
    private function obtenerUsuarioPorId($idAbogado)
    {
        $usuarioModel = new UsuarioModel();
        return $usuarioModel->find($idAbogado);
    }



    public function insertarCliente()
    {
        $nombre = $this->request->getPost('nombre');
        $telefono = $this->request->getPost('telefono');
        $sucursal = $this->request->getPost('sucursal');
        $tipo_consulta = $this->request->getPost('tipo_consulta');
        $meet_url = $tipo_consulta === 'online' ? $this->request->getPost('meet_url') : null;

        $clienteModel = new ClienteModel();

        $slug = $this->safeBase64UrlEncode($nombre . $telefono);
        $estatus = $tipo_consulta === 'online' ? 8 : 1;
        $data = [
            'nombre' => $nombre,
            'telefono' => $telefono,
            'sucursal' => $sucursal,
            'slug' => $slug,
            'estatus' => $estatus,
            'tipo_consulta' => $tipo_consulta,
            'meet_url' => $meet_url,
            'fecha_ultima_actualizacion' => date('Y-m-d H:i:s')
        ];

        if ($clienteModel->insert($data)) {
            // Registrar acción de creación de cliente
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'create_client', "El usuario creó un nuevo cliente con nombre $nombre.");
            }

            $response['success'] = true;
            $response['message'] = 'Se creó correctamente el cliente.';
            $response['slug'] = $slug;
        } else {
            $response['success'] = false;
            $response['message'] = 'Ocurrió un error al agregar el cliente.';
        }

        return $this->response->setJSON($response);
    }

    function safeBase64UrlEncode($string)
    {
        // Codifica la cadena en base64
        $base64 = base64_encode($string);

        // Reemplaza los caracteres especiales
        $safeBase64 = strtr($base64, '+/', '-_');

        // Elimina los signos de igual al final, que son utilizados para el relleno
        $safeBase64 = rtrim($safeBase64, '=');

        return $safeBase64;
    }

    public function abogado()
    {
        $data["title"] = "Clientes";
        $abogadoModel = new AbogadoModel();
        $tiposCasosModel = new CasosTiposModel();
        $data['abogados'] = $abogadoModel->obtenerAbogadosConInfo();
        $data['tiposCasos'] = $tiposCasosModel->obtenerTodos();

        $data['renderBody'] = $this->render("clientes/abogado", $data);

        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">';

        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/flatpickr'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/clientes_abogado.js") . "'></script>";

        return $this->render('shared/layout', $data);
    }

    public function nuevoCaso()
    {
        $id_cliente = $this->request->getPost('id_cliente');
        $id_usuario = $this->request->getPost('id_usuario');
        $comentarios = $this->request->getPost('comentarios');
        $costo = $this->request->getPost('costo');
        $procesos_adicionales = $this->request->getPost('procesos_adicionales');
        $estatus = $this->request->getPost('estatus');
        $id_tipo_caso = $this->request->getPost('id_tipo_caso');
        $proceso = $this->request->getPost('proceso');
        $fecha_corte = $this->request->getPost('fecha_corte');

        if ($estatus == "4") {
            $casoModel = new CasoModel();

            $data = [
                'id_cliente' => $id_cliente,
                'id_usuario' => $id_usuario,
                'id_tipo_caso' => $id_tipo_caso,
                'proceso' => $proceso,
                'comentarios' => $comentarios,
                'costo' => $costo,
                'procesos_adicionales' => $procesos_adicionales,
                'fecha_corte' => $fecha_corte,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ];

            $crearCaso = $casoModel->crearCaso($data);

            $response['data'] = $data;
            $response['crearCaso'] = $crearCaso;
        }

        $clienteModel = new ClienteModel();

        $actualizarEstatus = $clienteModel->actualizarEstatusCliente($id_cliente, $estatus);

        // Registrar acción de actualización de estatus y creación de caso si aplica
        $usuario = session()->get('usuario');
        if ($usuario) {
            registrarAccion($usuario['id'], 'update_client_status', "El usuario actualizó el estatus del cliente ID $id_cliente a $estatus.");
            if (isset($crearCaso) && $crearCaso) {
                registrarAccion($usuario['id'], 'create_case', "El usuario creó un caso para el cliente ID $id_cliente con el estatus $estatus.");
            }
        }

        $response['success'] = true;
        $response['estatus'] = $estatus;
        $response['actualizarEstatus'] = $actualizarEstatus;

        return $this->response->setJSON($response);
    }

    public function verCliente($idCliente)
    {
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($idCliente);

        if (!$cliente) {
            return "Cliente no encontrado " . $idCliente;
        }

        $casoModel = new CasoModel();
        $casos = $casoModel->obtenerCasosPorCliente($idCliente);

        $formularioAdmisionModel = new FormularioAdmisionModel();
        $formulario = $formularioAdmisionModel->obtenerPorIdCliente($idCliente);

        $sucursalModel = new SucursalModel();
        $data['sucursales'] = $sucursalModel->obtenerTodas();

        $data["title"] = "Cliente";
        $data['cliente'] = $cliente;
        $data['casos'] = $casos;
        $data['formulario'] = $formulario;
        $data['renderBody'] = $this->render("clientes/cliente", $data);

        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">';

        $data['scripts'] = "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/cliente.js") . "'></script>";

        // Registrar acción de visualización de un cliente específico
        $usuario = session()->get('usuario');
        if ($usuario) {
            registrarAccion($usuario['id'], 'view_client', "El usuario visualizó la información del cliente ID $idCliente.");
        }

        return $this->render('shared/layout', $data);
    }

    public function obtenerCasosPorCliente()
    {
        $casoModel = new CasoModel();
        $idCliente = $this->request->getPost('id_cliente');
        $casos = $casoModel->obtenerCasosPorCliente($idCliente);

        $response['casos'] = $casos;

        return $this->response->setJSON($response);
    }

    public function crearCaso()
    {
        $clienteModel = new ClienteModel();
        $casoModel = new CasoModel();

        $idCliente = $this->request->getPost('id_cliente');
        $idUsuario = $this->request->getPost('id_usuario');
        $comentarios = $this->request->getPost('comentarios');
        $costo = $this->request->getPost('costo');

        $data = [
            'id_cliente' => $idCliente,
            'id_usuario' => $idUsuario,
            'comentarios' => $comentarios,
            'costo' => $costo,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'fecha_actualizacion' => date('Y-m-d H:i:s')
        ];

        if ($casoModel->crearCaso($data)) {
            // Registrar acción de creación de caso
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'create_case', "El usuario creó un nuevo caso para el cliente ID $idCliente.");
            }

            $response['success'] = true;
            $response['message'] = 'Se creó el caso correctamente.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Ocurrió un error al crear el caso.';
        }

        return $this->response->setJSON($response);
    }

    public function actualizarClientID()
    {
        $clienteModel = new ClienteModel();

        $idCliente = $this->request->getPost('id_cliente');
        $nuevoClientID = $this->request->getPost('clientID');

        if ($clienteModel->actualizarClientID($idCliente, $nuevoClientID)) {
            // Registrar acción de actualización de ClientID
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'update_client_id', "El usuario actualizó el ClientID del cliente ID $idCliente.");
            }

            return $this->response->setJSON(['success' => true, 'message' => 'ClientID actualizado correctamente.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo actualizar el ClientID.']);
        }
    }

    public function actualizarEstatus()
    {
        $clienteModel = new ClienteModel();

        $idCliente = $this->request->getPost('id_cliente');
        $estatus = $this->request->getPost('estatus');
        $tipo_consulta = $this->request->getPost('tipo_consulta');
        $meet_url = $tipo_consulta === 'online' ? $this->request->getPost('meet_url') : null;

        $data = [
            'estatus' => $estatus,
            'tipo_consulta' => $tipo_consulta,
            'meet_url' => $meet_url,
            'fecha_ultima_actualizacion' => date('Y-m-d H:i:s')
        ];

        if ($clienteModel->update($idCliente, $data)) {
            // Registrar acción de actualización de estatus
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'update_client_status', "El usuario actualizó el estatus del cliente ID $idCliente a $estatus.");
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Estatus actualizado correctamente.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo actualizar el estatus.']);
        }
    }

    public function actualizarCliente()
    {
        $clienteModel = new ClienteModel();

        $idCliente = $this->request->getPost('id_cliente');
        $nombre = $this->request->getPost('nombre');
        $telefono = $this->request->getPost('telefono');
        $sucursal = $this->request->getPost('sucursal');
        $tipo_consulta = $this->request->getPost('tipo_consulta');
        $meet_url = $tipo_consulta === 'online' ? $this->request->getPost('meet_url') : null;

        $data = [
            'nombre' => $nombre,
            'telefono' => $telefono,
            'sucursal' => $sucursal,
            'tipo_consulta' => $tipo_consulta,
            'meet_url' => $meet_url,
            'fecha_ultima_actualizacion' => date('Y-m-d H:i:s')
        ];

        if ($clienteModel->update($idCliente, $data)) {
            // Registrar acción de actualización de cliente
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'update_client_info', "El usuario actualizó la información del cliente ID $idCliente.");
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Información del cliente actualizada correctamente.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo actualizar la información del cliente.']);
        }
    }

    //CALL CENTER
    public function callcenter()
    {
        $data["title"] = "Clientes";
        $sucursalModel = new SucursalModel();
        $estatusModel = new ClienteEstatusModel();

        $estatus = $estatusModel->obtenerTodosEstatus();

        $data['sucursales'] = $sucursalModel->obtenerTodas();
        $data['estatus'] = $estatus;

        // Registrar acción de visualización de clientes del call center
        $usuario = session()->get('usuario');
        if ($usuario) {
            registrarAccion($usuario['id'], 'view_callcenter_clients', 'El usuario visualizó la lista de clientes en el call center.');
        }

        $data['renderBody'] = $this->render("clientes/call_center", $data);

        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">';

        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/clientes_call.js") . "'></script>";

        return $this->render('shared/layout', $data);
    }

    public function obtenerClientesCallCenter()
    {
        $clienteModel = new ClienteModel();
        $clientes = $clienteModel->obtenerClientesPorEstatus([1, 2, 8]);

        return $this->response->setJSON($clientes);
    }

    public function insertarClienteCallCenter()
    {
        $nombre = $this->request->getPost('nombre');
        $telefono = $this->request->getPost('telefono');
        $sucursal = $this->request->getPost('sucursal');
        $tipo_consulta = $this->request->getPost('tipo_consulta');
        $meet_url = $tipo_consulta === 'online' ? $this->request->getPost('meet_url') : null;

        $clienteModel = new ClienteModel();

        $slug = $this->safeBase64UrlEncode($nombre . $telefono);
        $estatus = $tipo_consulta === 'online' ? 8 : 1;
        $data = [
            'nombre' => $nombre,
            'telefono' => $telefono,
            'sucursal' => $sucursal,
            'slug' => $slug,
            'estatus' => $estatus,
            'tipo_consulta' => $tipo_consulta,
            'meet_url' => $meet_url,
            'fecha_ultima_actualizacion' => date('Y-m-d H:i:s')
        ];

        if ($clienteModel->insert($data)) {
            // Registrar acción de creación de cliente en call center
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'create_client_callcenter', "El usuario creó un nuevo cliente en el call center con nombre $nombre.");
            }

            $response['success'] = true;
            $response['message'] = 'Se creó correctamente el cliente.';
            $response['slug'] = $slug;
        } else {
            $response['success'] = false;
            $response['message'] = 'Ocurrió un error al agregar el cliente.';
        }

        return $this->response->setJSON($response);
    }

    public function clientesAsignados()
    {
        $data["title"] = "Clientes Asignados";

        // Obtener datos del usuario (abogado) desde la sesión
        $usuario = session("usuario");
        $idAbogado = $usuario["id"];

        // Cargar modelos
        $sucursalModel = new SucursalModel();
        $estatusModel = new ClienteEstatusModel();

        // Obtener datos necesarios
        $data['sucursales'] = $sucursalModel->obtenerTodas();
        $data['estatus'] = $estatusModel->obtenerTodosEstatus();

        // Registrar acción de visualización de clientes asignados
        if ($usuario) {
            registrarAccion($usuario['id'], 'view_assigned_clients', 'El abogado visualizó la lista de clientes asignados.');
        }

        // Renderizar la vista de clientes asignados
        $data['renderBody'] = $this->render("clientes/clientes_asignados", $data);

        // Incluir estilos necesarios
        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">';

        // Incluir scripts necesarios
        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/flatpickr'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/clientes_asignados.js") . "'></script>";

        return $this->render('shared/layout', $data);
    }


    public function obtenerClientesAsignados()
    {
        $usuario = session("usuario");
        $idAbogado = $usuario["id"];

        $clienteModel = new ClienteModel();
        $postData = json_decode($this->request->getBody(), true);

        $limit = $postData['limit'] ?? 10;
        $offset = $postData['offset'] ?? 0;
        $filtros = [
            'tipo' => $postData['tipo'] ?? '',
            'sucursal' => $postData['sucursal'] ?? '',
            'estatus' => $postData['estatus'] ?? '',
            'periodo' => $postData['periodo'] ?? ''
        ];

        $result = $clienteModel->obtenerClientesAsignadosPaginados($idAbogado, $limit, $offset, $filtros);

        return $this->response->setJSON($result);
    }
}
