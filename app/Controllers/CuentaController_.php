<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class CuentaController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        // Obtener el ID del usuario logueado
        $session = session();
        $userId = $session->get('usuario')['id'];

        // Obtener la información del usuario
        $data['usuario'] = $this->usuarioModel->find($userId);

        // Renderizar la vista con el layout
        return $this->render('cuenta/index', $data);
    }

    public function actualizar()
    {
        // Obtener el ID del usuario logueado
        $session = session();
        $userId = $session->get('usuario')['id'];

        // Obtener los datos del formulario
        $data = $this->request->getPost();

        // Verificar si se proporciona una nueva contraseña
        if (!empty($data['contrasena'])) {
            // Encriptar la nueva contraseña
            $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);
        } else {
            // No actualizar la contraseña si no se proporciona una nueva
            unset($data['contrasena']);
        }

        // Actualizar la información del usuario
        $this->usuarioModel->update($userId, $data);

        // Redirigir con un mensaje de éxito
        return redirect()->to('/cuenta')->with('mensaje', 'Información actualizada correctamente');
    }
}
