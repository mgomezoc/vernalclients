<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SessionAdmin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $usuario = session('usuario');
        $perfil = session('perfil');

        // Si no hay argumentos, se permite el acceso público
        if ($arguments === null || count($arguments) === 0) {
            return;
        }

        if (empty($usuario) || empty($perfil)) {
            return redirect()->to(base_url("login"));
        }

        // Combinar todos los argumentos en una sola cadena y dividir por comas
        $perfilesPermitidos = [];
        foreach ($arguments as $arg) {
            $perfilesPermitidos = array_merge($perfilesPermitidos, explode(',', $arg));
        }

        // Verificar si el perfil del usuario está en la lista de perfiles permitidos
        if (!in_array($perfil, $perfilesPermitidos)) {
            return redirect()->to(base_url("login"));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here if needed
    }
}
