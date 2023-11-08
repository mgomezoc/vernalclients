<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteAbogadoModel extends Model
{
    protected $table = 'cliente_abogado';
    protected $primaryKey = 'id';

    // Nota: Cambié 'id_abogado' por 'id_usuario'
    protected $allowedFields = ['id_cliente', 'id_usuario', 'fecha_asignacion', 'estatus_relacion'];

    // Guardar una nueva relación cliente-abogado
    public function guardarRelacion($data)
    {
        return $this->insert($data);
    }

    // Editar una relación existente cliente-abogado
    public function editarRelacion($id, $data)
    {
        return $this->update($id, $data);
    }

    // Eliminar una relación cliente-abogado
    public function eliminarRelacion($id)
    {
        return $this->delete($id);
    }

    // Obtener relaciones por cliente
    public function obtenerRelacionesPorCliente($idCliente)
    {
        return $this->where('id_cliente', $idCliente)->findAll();
    }

    // Obtener relaciones por usuario (anteriormente por abogado)
    // Nota: Cambié 'id_abogado' por 'id_usuario'
    public function obtenerRelacionesPorUsuario($idUsuario)
    {
        return $this->where('id_usuario', $idUsuario)->findAll();
    }
}
