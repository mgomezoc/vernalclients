<?php
// app/Filters/UserInfoFilter.php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserInfoFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Obtener la información del usuario desde la sesión
        $usuario = session('usuario'); // Aquí obtienes los datos guardados en la sesión

        // Establecer la información del usuario en "shared data"
        view()->setVar('usuario', $usuario);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No necesitamos realizar acciones después de la solicitud
    }
}
