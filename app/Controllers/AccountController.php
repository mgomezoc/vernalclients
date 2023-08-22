<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class AccountController extends Controller
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function login()
    {
        $data = [];
        echo view('account/login', $data);
    }

    public function acceder()
    {
        $correoElectronico = $this->request->getPost('correo_electronico');
        $contrasena = $this->request->getPost('contrasena');

        // Obtén el usuario por su correo electrónico desde la base de datos
        $usuario = $this->usuarioModel->where('correo_electronico', $correoElectronico)->first();
        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {

            // Credenciales válidas, crea la sesión y redirige a la página de inicio
            session()->set('usuario', $usuario);

            return redirect()->to(site_url('/'));
        } else {
            // Credenciales inválidas, redirige nuevamente al formulario de inicio de sesión
            return redirect()->to(site_url('login'));
        }
    }

    public function salir()
    {
        // Destruye la sesión
        session()->destroy();

        // Redirige al formulario de inicio de sesión
        return redirect()->to(site_url('login'));
    }
}
