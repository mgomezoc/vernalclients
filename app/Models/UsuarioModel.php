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
        'fecha_creacion'
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
        // Validar que $perfiles no esté vacío
        if (empty($perfiles)) {
            return [];
        }

        // Usar una consulta para obtener usuarios cuyos perfiles estén en el arreglo $perfiles
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
}
