<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Usuarios extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        helper('auditoria'); // Cargar el helper de auditoría

        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        exit("test");
        // Obtener todos los usuarios desde la base de datos
        $data['usuarios'] = $this->usuarioModel->findAll();

        // Registrar acción de visualización de lista de usuarios
        $usuario = session()->get('usuario');
        if ($usuario) {
            registrarAccion($usuario['id'], 'view_users', 'El usuario visualizó la lista de usuarios.');
        }

        // Cargar la vista para mostrar la lista de usuarios
        return "x"; //view('usuarios/index', $data);
    }

    public function crear()
    {
        // Cargar la vista para el formulario de creación de usuario
        return view('usuarios/crear');
    }

    public function guardar()
    {
        // Obtener los datos del formulario
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellido_paterno' => $this->request->getPost('apellido_paterno'),
            'apellido_materno' => $this->request->getPost('apellido_materno'),
            'correo_electronico' => $this->request->getPost('correo_electronico'),
            'perfil' => $this->request->getPost('perfil'),
            'contrasena' => password_hash($this->request->getPost('contrasena'), PASSWORD_DEFAULT),
        ];

        // Insertar los datos en la base de datos
        $this->usuarioModel->insert($data);

        // Registrar acción de creación de usuario
        $usuario = session()->get('usuario');
        if ($usuario) {
            registrarAccion($usuario['id'], 'create_user', 'El usuario creó un nuevo usuario: ' . $data['correo_electronico']);
        }

        // Redirigir a la página de lista de usuarios
        return redirect()->to('/usuarios');
    }
}
