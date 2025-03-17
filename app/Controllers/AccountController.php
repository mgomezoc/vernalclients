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
        $data = [];
        echo view('account/login', $data);
    }

    public function acceder()
    {
        $correoElectronico = $this->request->getPost('correo_electronico');
        $contrasena = $this->request->getPost('contrasena');

        if (is_array($correoElectronico) || is_array($contrasena)) {
            return redirect()->to(site_url('login'))->with('error', 'Datos de entrada no válidos.');
        }

        // Buscar usuario por correo electrónico
        $usuario = $this->usuarioModel->where('correo_electronico', $correoElectronico)->first();

        if (!$usuario) {
            // No existe el usuario con ese correo
            return redirect()->to(site_url('login'))->with('error', 'El correo electrónico no está registrado.');
        }

        // Verificar la contraseña
        if (!password_verify($contrasena, $usuario['contrasena'])) {
            // Registrar intento de inicio de sesión fallido
            registrarAccion($usuario['id'], 'login_failed', 'Intento de inicio de sesión fallido para el correo: ' . $correoElectronico);

            return redirect()->to(site_url('login'))->with('error', 'La contraseña ingresada es incorrecta.');
        }

        // Obtener perfil del usuario
        $perfil = $this->perfilModel->find($usuario['perfil']);

        // Iniciar sesión
        session()->set('usuario', $usuario);
        session()->set('perfil', $perfil['nombre']);

        // Registrar acción de inicio de sesión exitosa
        registrarAccion($usuario['id'], 'login', 'El usuario inició sesión.');

        return redirect()->to(site_url('/'))->with('success', '¡Bienvenido ' . $usuario['nombre'] . '!');
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
