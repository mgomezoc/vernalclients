<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\PerfilModel;
use App\Services\EmailService;
use CodeIgniter\Controller;

class AccountController extends Controller
{
    protected $usuarioModel;
    protected $perfilModel;

    public function __construct()
    {
        helper('auditoria'); // Cargar el helper de auditoría

        $this->usuarioModel = new UsuarioModel();
        $this->perfilModel = new PerfilModel();
    }

    public function login()
    {
        // Enviar correo de bienvenida
        $emailService = new EmailService();
        $to = '0013zkr@gmail.com';
        $subject = 'Bienvenido a Vernal Clients';
        $message = "<p>Hola Cesar</p><p>Gracias por registrarte.</p>";

        $emailService->sendEmail($to, $subject, $message);

        $data = [];
        echo view('account/login', $data);
    }

    public function acceder()
    {
        $correoElectronico = $this->request->getPost('correo_electronico');
        $contrasena = $this->request->getPost('contrasena');

        if (is_array($correoElectronico) || is_array($contrasena)) {
            return redirect()->to(site_url('login'))->with('error', 'Invalid input data.');
        }

        $usuario = $this->usuarioModel->where('correo_electronico', $correoElectronico)->first();
        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            $perfil = $this->perfilModel->find($usuario['perfil']);
            session()->set('usuario', $usuario);
            session()->set('perfil', $perfil['nombre']);

            // Registrar acción de inicio de sesión
            registrarAccion($usuario['id'], 'login', 'El usuario inició sesión.');

            return redirect()->to(site_url('/'));
        } else {
            // Registrar intento de inicio de sesión fallido
            registrarAccion(null, 'login_failed', 'Intento de inicio de sesión fallido para el correo: ' . $correoElectronico);

            return redirect()->to(site_url('login'))->with('error', 'Invalid email or password.');
        }
    }

    public function salir()
    {
        $usuario = session()->get('usuario');

        // Registrar acción de cierre de sesión
        if ($usuario) {
            registrarAccion($usuario['id'], 'logout', 'El usuario cerró sesión.');
        }

        session()->destroy();
        return redirect()->to(site_url('login'));
    }
}
