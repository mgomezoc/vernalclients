<?php

namespace App\Models;

use CodeIgniter\Model;

class AbogadoModel extends Model
{
    protected $table      = 'abogados';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_usuario', 'id_sucursal', 'especialidad', 'telefono'];

    public function obtenerAbogadosConInfo()
    {
        return $this->db->table('abogados a')
            ->select('a.id AS abogado_id, u.id AS usuario_id, u.nombre AS usuario_nombre, u.apellido_paterno AS usuario_apellido_paterno, u.apellido_materno AS usuario_apellido_materno, u.correo_electronico AS correo_electronico, s.id AS sucursal_id, s.nombre AS sucursal_nombre, a.especialidad, a.telefono, a.fecha_creacion AS abogado_fecha_creacion')
            ->join('usuarios u', 'a.id_usuario = u.id')
            ->join('sucursales s', 'a.id_sucursal = s.id')
            ->get()
            ->getResultArray();
    }

    public function agregarAbogado($data)
    {
        return $this->insert($data);
    }

    public function editarAbogado($id, $data)
    {
        return $this->update($id, $data);
    }

    public function eliminarAbogado($id)
    {
        return $this->delete($id);
    }
}
