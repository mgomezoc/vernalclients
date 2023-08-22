<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo_electronico',
        'perfil',
        'contrasena'
    ];

    public function agregarUsuario($data)
    {
        // Verificar si ya existe un usuario con el mismo correo electrónico
        $existingUser = $this->where('correo_electronico', $data['correo_electronico'])->first();

        if ($existingUser) {
            // Ya existe un usuario con el mismo correo electrónico
            return false;
        }

        // Si no existe, agregar el nuevo usuario
        return $this->insert($data);
    }


    public function editarUsuario($id, $data)
    {
        return $this->update($id, $data);
    }

    public function borrarUsuario($id)
    {
        return $this->delete($id);
    }
}
