<?php

namespace App\Models;

use CodeIgniter\Model;

class CasoModel extends Model
{
    protected $table = 'casos';
    protected $primaryKey = 'id_caso';

    protected $allowedFields = ['id_cliente', 'id_usuario', 'comentarios', 'costo', 'fecha_creacion', 'fecha_actualizacion'];

    // Crear un nuevo caso
    public function crearCaso($data)
    {
        return $this->insert($data);
    }

    // Editar un caso existente
    public function editarCaso($id, $data)
    {
        return $this->update($id, $data);
    }

    // Eliminar un caso
    public function eliminarCaso($id)
    {
        return $this->delete($id);
    }

    // Obtener casos por ID de cliente
    public function obtenerCasosPorCliente($idCliente)
    {
        return $this->where('id_cliente', $idCliente)->findAll();
    }
}
