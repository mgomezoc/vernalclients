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

class ClientesController extends BaseController
{
    public function index()
    {
        $data["title"] = "Clientes";
        $sucursalModel = new SucursalModel();
        $estatusModel = new ClienteEstatusModel();

        $estatus = $estatusModel->obtenerTodosEstatus();

        $data['sucursales'] = $sucursalModel->obtenerTodas();
        $data['estatus'] = $estatus;


        $data['renderBody'] = $this->render("clientes/index", $data);

        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">';

        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/clientes.js") . "'></script>";


        return $this->render('shared/layout', $data);
    }

    public function recepcion()
    {
        $data["title"] = "Clientes";
        $abogadoModel = new AbogadoModel();
        $data['abogados'] = $abogadoModel->obtenerAbogadosConInfo();


        $data['renderBody'] = $this->render("clientes/recepcion", $data);

        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">';

        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/clientes_recepcion.js") . "'></script>";


        return $this->render('shared/layout', $data);
    }

    public function obtenerClientes()
    {
        $clienteModel = new ClienteModel();
        $clientes = $clienteModel->obtenerTodosClientes();

        return $this->response->setJSON($clientes);
    }

    public function obtenerClientesRecepcion()
    {
        $clienteModel = new ClienteModel();
        $clientesIntake = $clienteModel->obtenerTodosClientesConEstatus(2);
        $clientesViable = $clienteModel->obtenerTodosClientesConEstatus(4);

        $clientes = array_merge($clientesIntake, $clientesViable);

        return $this->response->setJSON($clientes);
    }

    public function obtenerClientesAbogado()
    {
        $usuario = session("usuario");
        $data['usuario'] = $usuario;

        $idAbogado = $usuario["id"];

        $clienteModel = new ClienteModel();
        $clientes = $clienteModel->obtenerTodosClientesAbogado($idAbogado);

        return $this->response->setJSON($clientes);
    }

    public function asignarAbogado()
    {
        $clienteModel = new ClienteModel();
        $clienteAbogadoModel = new ClienteAbogadoModel();

        $idCliente = $this->request->getPost('id_cliente');
        $idAbogado = $this->request->getPost('id_abogado');
        $nuevoEstatus = 3;

        if ($clienteModel->actualizarEstatusCliente($idCliente, $nuevoEstatus)) {
            // Si se actualizó el estatus del cliente, procedemos a guardar la relación
            $data = [
                'id_cliente' => $idCliente,
                'id_usuario' => $idAbogado,
                'fecha_asignacion' => date('Y-m-d H:i:s'),
                'estatus_relacion' => 1
            ];

            if ($clienteAbogadoModel->guardarRelacion($data)) {
                $response['success'] = true;
                $response['message'] = 'Se actualizó correctamente el estatus del cliente y se asignó el abogado.';
            } else {
                $response['success'] = false;
                $response['message'] = 'Ocurrió un error al asignar el abogado al cliente.';
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Ocurrió un error al actualizar el estatus del cliente.';
        }

        return $this->response->setJSON($response);
    }


    public function insertarCliente()
    {
        $nombre = $this->request->getPost('nombre');
        $telefono = $this->request->getPost('telefono');
        $sucursal = $this->request->getPost('sucursal');

        $clienteModel = new ClienteModel();

        $slug = $this->safeBase64UrlEncode($nombre . $telefono);
        $data = [
            'nombre' => $nombre,
            'telefono' => $telefono,
            'sucursal' => $sucursal,
            'slug'     => $slug,
            'estatus'  => 1,
            'fecha_ultima_actualizacion' => date('Y-m-d H:i:s')
        ];

        if ($clienteModel->insert($data)) {
            $response['success'] = true;
            $response['message'] = 'Se creo correctamente el cliente.';
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
            // La actualización fue exitosa.
            return $this->response->setJSON(['success' => true, 'message' => 'ClientID actualizado correctamente.']);
        } else {
            // Hubo un error al actualizar.
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo actualizar el ClientID.']);
        }
    }

    public function actualizarEstatus()
    {
        $clienteModel = new ClienteModel();

        $idCliente = $this->request->getPost('id_cliente');
        $estatus = $this->request->getPost('estatus');

        if ($clienteModel->actualizarEstatusCliente($idCliente, $estatus)) {
            return $this->response->setJSON(['success' => true, 'message' => 'estatus actualizado correctamente.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo actualizar el estatus.']);
        }
    }
}
