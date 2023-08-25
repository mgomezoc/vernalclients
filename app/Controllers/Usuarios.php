<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Usuarios extends Controller
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        // Obtener todos los usuarios desde el modelo
        $usuarios = $this->usuarioModel->findAll();

        $data = [
            "usuarios" => $usuarios,
            "title" => "Usuarios",
            "renderBody" => view('usuarios/index', ["usuarios" => $usuarios])
        ];

        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">';

        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/usuarios.js") . "'></script>";

        return view('shared/layout', $data);
    }

    public function obtenerUsuarios()
    {
        $usuarios = $this->usuarioModel->findAll();

        return $this->response->setJSON($usuarios);
    }

    public function obtenerUsuarioPorId($id)
    {
        $usuario = $this->usuarioModel->find($id);

        if ($usuario) {
            // Excluir la contraseña y la fecha de creación del usuario
            unset($usuario['contrasena']);
            unset($usuario['fecha_creacion']);

            return $this->response->setJSON($usuario);
        } else {
            $data["success"] = false;
            $data["message"] = "Usuario no encontrado.";
            return $this->response->setJSON($data);
        }
    }

    public function agregarUsuario()
    {
        $nombre = $this->request->getPost("nombre");
        $apellidoPaterno = $this->request->getPost("apellido_paterno");
        $apellidoMaterno = $this->request->getPost("apellido_materno");
        $correoElectronico = $this->request->getPost("correo_electronico");
        $perfil = $this->request->getPost("perfil");
        $contrasena = $this->request->getPost("contrasena");
        $contrasena_db = password_hash($contrasena, PASSWORD_DEFAULT);

        $data = [];

        // Verificar si ya existe un usuario con el mismo correo electrónico
        $existingUser = $this->usuarioModel->where('correo_electronico', $correoElectronico)->first();
        if ($existingUser) {
            $data["success"] = false;
            $data["message"] = "Ya existe un usuario con el mismo correo electrónico.";
            return $this->response->setJSON($data);
        }

        if (!empty($nombre) && !empty($apellidoPaterno) && !empty($correoElectronico) && !empty($perfil) && !empty($contrasena)) {
            $usuarioData = [
                "nombre" => $nombre,
                "apellido_paterno" => $apellidoPaterno,
                "apellido_materno" => $apellidoMaterno,
                "correo_electronico" => $correoElectronico,
                "perfil" => $perfil,
                "contrasena" => $contrasena_db
            ];

            $this->usuarioModel->insert($usuarioData);

            $data["success"] = true;
            $data["message"] = "Usuario agregado exitosamente.";
        } else {
            $data["success"] = false;
            $data["message"] = "Todos los campos son obligatorios.";
        }

        return $this->response->setJSON($data);
    }


    public function editarUsuario()
    {
        $usuarioId = $this->request->getPost("id");
        $nombre = $this->request->getPost("nombre");
        $apellidoPaterno = $this->request->getPost("apellido_paterno");
        $apellidoMaterno = $this->request->getPost("apellido_materno");
        $correoElectronico = $this->request->getPost("correo_electronico");
        $perfil = $this->request->getPost("perfil");

        $data = [];

        // Obtén el usuario actual de la base de datos
        $usuarioActual = $this->usuarioModel->find($usuarioId);

        // Si el correo electrónico ha cambiado
        if ($usuarioActual['correo_electronico'] !== $correoElectronico) {
            // Verificar si ya existe un usuario con el nuevo correo electrónico
            $existingUser = $this->usuarioModel->where('correo_electronico', $correoElectronico)->first();
            if ($existingUser) {
                $data["success"] = false;
                $data["message"] = "Ya existe un usuario con el mismo correo electrónico.";
                return $this->response->setJSON($data);
            }
        }

        if ($usuarioId && !empty($nombre) && !empty($apellidoPaterno)) {
            $usuarioData = [
                "nombre" => $nombre,
                "apellido_paterno" => $apellidoPaterno,
                "apellido_materno" => $apellidoMaterno,
                "correo_electronico" => $correoElectronico,
                "perfil" => $perfil
            ];

            $updated = $this->usuarioModel->editarUsuario($usuarioId, $usuarioData);

            if ($updated) {
                $data["success"] = true;
                $data["message"] = "Usuario actualizado exitosamente.";
            } else {
                $data["success"] = false;
                $data["message"] = "No se pudo actualizar el usuario.";
            }
        } else {
            $data["success"] = false;
            $data["message"] = "Campos requeridos incompletos.";
        }

        return $this->response->setJSON($data);
    }



    public function borrarUsuario()
    {
        $usuarioId = $this->request->getPost("id");
        $data = [];

        if ($usuarioId) {
            $deleted = $this->usuarioModel->borrarUsuario($usuarioId);

            if ($deleted) {
                $data["success"] = true;
                $data["message"] = "Usuario eliminado exitosamente.";
            } else {
                $data["success"] = false;
                $data["message"] = "No se pudo eliminar el usuario.";
            }
        } else {
            $data["success"] = false;
            $data["message"] = "ID de usuario no proporcionado.";
        }

        return $this->response->setJSON($data);
    }
}
