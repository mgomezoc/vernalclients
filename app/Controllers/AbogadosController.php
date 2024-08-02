<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AbogadoModel;
use App\Models\SucursalModel;
use App\Models\UsuarioModel;

class AbogadosController extends BaseController
{
    public function __construct()
    {
        helper('auditoria'); // Cargar el helper de auditoría para registrar acciones
    }

    public function index()
    {
        $usuarioModel = new UsuarioModel();
        $abogadoModel = new AbogadoModel();

        // Obtener IDs de usuarios que ya son abogados
        $usuariosAbogados = $abogadoModel->select('id_usuario')->findAll();
        $usuariosAbogadosIds = array_column($usuariosAbogados, 'id_usuario');

        // Obtener usuarios que no son abogados
        $data['usuarios'] = $usuarioModel->whereNotIn('id', $usuariosAbogadosIds)->findAll();

        $sucursalModel = new SucursalModel();
        $data['sucursales'] = $sucursalModel->obtenerTodas();

        $data["csrfToken"] = csrf_token();
        $data['renderBody'] = view('abogados/index', $data);

        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">';

        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/abogados.js") . "'></script>";

        echo $this->render('shared/layout', $data);
    }

    public function obtenerAbogados()
    {
        $abogadoModel = new AbogadoModel();
        $data = $abogadoModel->obtenerAbogadosConInfo();

        // Registrar acción de visualización de abogados
        $usuario = session()->get('usuario');
        if ($usuario) {
            registrarAccion($usuario['id'], 'view_lawyers', 'El usuario visualizó la lista de abogados.');
        }

        return $this->response->setJSON($data);
    }

    public function agregarAbogado()
    {
        $abogadoModel = new AbogadoModel();
        $idUsuario = $this->request->getVar('id_usuario');

        // Verificar si el usuario ya es abogado
        $abogadoExistente = $abogadoModel->where('id_usuario', $idUsuario)->first();

        if ($abogadoExistente) {
            return $this->response->setJSON(['success' => false, 'message' => 'El usuario seleccionado ya está registrado como abogado.']);
        }

        $data = [
            'id_usuario' => $idUsuario,
            'id_sucursal' => $this->request->getVar('id_sucursal'),
            'especialidad' => $this->request->getVar('especialidad'),
            'telefono' => $this->request->getVar('telefono'),
        ];

        if ($abogadoModel->agregarAbogado($data)) {
            // Registrar acción de creación de abogado
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'create_lawyer', "El usuario agregó un nuevo abogado con ID de usuario {$data['id_usuario']}.");
            }

            $response['success'] = true;
            $response['message'] = 'Abogado agregado exitosamente.';
        } else {
            $response['success'] = false;
            $response['message'] = 'No se pudo agregar el abogado.';
        }

        return $this->response->setJSON($response);
    }


    public function editarAbogado()
    {
        $id = $this->request->getVar('abogado_id');
        $idUsuario = $this->request->getVar('id_usuario');

        // Verificar que el usuario existe
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($idUsuario);

        if (!$usuario) {
            return $this->response->setJSON(['success' => false, 'message' => 'El usuario especificado no existe.']);
        }

        $abogadoModel = new AbogadoModel();
        $data = [
            'id_usuario' => $idUsuario,
            'id_sucursal' => $this->request->getVar('id_sucursal'),
            'especialidad' => $this->request->getVar('especialidad'),
            'telefono' => $this->request->getVar('telefono'),
        ];

        if ($abogadoModel->editarAbogado($id, $data)) {
            // Registrar acción de edición de abogado
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'edit_lawyer', "El usuario editó al abogado con ID $id.");
            }

            $response['success'] = true;
            $response['message'] = 'Abogado actualizado exitosamente.';
        } else {
            $response['success'] = false;
            $response['message'] = 'No se pudo actualizar el abogado.';
        }

        return $this->response->setJSON($response);
    }

    public function eliminarAbogado()
    {
        $abogadoModel = new AbogadoModel();
        $id = $this->request->getVar("id");

        if ($abogadoModel->eliminarAbogado($id)) {
            // Registrar acción de eliminación de abogado
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'delete_lawyer', "El usuario eliminó al abogado con ID $id.");
            }

            $response['success'] = true;
            $response['message'] = 'Abogado eliminado exitosamente.';
        } else {
            $response['success'] = false;
            $response['message'] = 'No se pudo eliminar el abogado.';
        }

        return $this->response->setJSON($response);
    }
}
