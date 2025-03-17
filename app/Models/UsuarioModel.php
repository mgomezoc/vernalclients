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
        'contrasena',
        'fecha_creacion',
        'reset_token',
        'reset_expiration'
    ];

    public function agregarUsuario($data)
    {
        $existingUser = $this->where('correo_electronico', $data['correo_electronico'])->first();

        if ($existingUser) {
            return false;
        }

        return $this->insert($data);
    }

    public function getUsuariosPerfil2()
    {
        return $this->select('id, nombre, apellido_paterno, apellido_materno, correo_electronico')
            ->where('perfil', 6)
            ->findAll();
    }

    public function editarUsuario($id, $data)
    {
        return $this->update($id, $data);
    }

    public function borrarUsuario($id)
    {
        return $this->delete($id);
    }

    public function getUsuariosPorPerfiles(array $perfiles)
    {
        if (empty($perfiles)) {
            return [];
        }

        return $this->select('id, nombre, apellido_paterno, apellido_materno, correo_electronico, perfil')
            ->whereIn('perfil', $perfiles)
            ->findAll();
    }

    public function obtenerUsuariosOrdenados()
    {
        return $this->orderBy('fecha_creacion', 'DESC')->findAll();
    }

    public function obtenerUsuariosNoAbogados()
    {
        $builder = $this->db->table('usuarios u');
        $builder->select('u.id, u.nombre, u.apellido_paterno, u.apellido_materno, u.correo_electronico');
        $builder->join('abogados a', 'u.id = a.id_usuario', 'left');
        $builder->where('a.id_usuario IS NULL');

        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene un usuario por su token de recuperación.
     */
    public function getUsuarioPorToken($token)
    {
        return $this->where('reset_token', $token)
            ->where('reset_expiration >=', date('Y-m-d H:i:s'))
            ->first();
    }

    /**
     * Guarda el token y su fecha de expiración para recuperación de contraseña.
     */
    public function guardarTokenRecuperacion($idUsuario, $token, $expiration)
    {
        return $this->update($idUsuario, [
            'reset_token' => $token,
            'reset_expiration' => $expiration
        ]);
    }

    /**
     * Limpia el token después de que la contraseña haya sido restablecida.
     */
    public function limpiarTokenRecuperacion($idUsuario)
    {
        return $this->update($idUsuario, [
            'reset_token' => null,
            'reset_expiration' => null
        ]);
    }
}
