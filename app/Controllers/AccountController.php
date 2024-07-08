<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\PerfilModel;
use CodeIgniter\Controller;

class AccountController extends Controller
{
    protected $usuarioModel;
    protected $perfilModel;

    public function __construct()
    {
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
            return redirect()->to(site_url('login'))->with('error', 'Invalid input data.');
        }

        $usuario = $this->usuarioModel->where('correo_electronico', $correoElectronico)->first();
        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            $perfil = $this->perfilModel->find($usuario['perfil']);
            session()->set('usuario', $usuario);
            session()->set('perfil', $perfil['nombre']);
            return redirect()->to(site_url('/'));
        } else {
            return redirect()->to(site_url('login'))->with('error', 'Invalid email or password.');
        }
    }

    public function salir()
    {
        session()->destroy();
        return redirect()->to(site_url('login'));
    }
}
