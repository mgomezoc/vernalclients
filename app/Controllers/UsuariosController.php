<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Usuarios extends BaseController
{
    public function index()
    {
        // Cargar el modelo de usuarios
        $model = new UsuarioModel();

        // Obtener todos los usuarios desde la base de datos
        $data['usuarios'] = $model->findAll();

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

        // Cargar el modelo de usuarios
        $model = new UsuarioModel();

        // Insertar los datos en la base de datos
        $model->insert($data);

        // Redirigir a la página de lista de usuarios
        return redirect()->to('/usuarios');
    }
}
