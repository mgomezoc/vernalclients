<?php

namespace App\Models;

use CodeIgniter\Model;

class CasoModel extends Model
{
    protected $table = 'casos';
    protected $primaryKey = 'id_caso';

    protected $allowedFields = ['id_cliente', 'id_usuario', 'id_tipo_caso', 'proceso', 'comentarios', 'costo', 'fecha_creacion', 'fecha_actualizacion', 'estatus', 'caseID', 'procesos_adicionales', 'fecha_corte', 'pagado', 'forma_pago'];

    // Crear un nuevo caso
    public function crearCaso($data)
    {
        $this->insert($data);

        return $this->getInsertID();
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

    public function actualizarCaseID($id_caso, $caseID)
    {
        $data = ['caseID' => $caseID];
        return $this->update($id_caso, $data);
    }

    public function actualizarEstatusCaso($idCaso, $nuevoEstatus)
    {
        // Define los datos a actualizar
        $data = [
            'estatus' => $nuevoEstatus,
            'fecha_actualizacion' => date('Y-m-d H:i:s')
        ];

        // Busca el caso por su ID y actualiza el estatus
        $this->where('id_caso', $idCaso);

        if ($this->update($idCaso, $data)) {
            return true; // La actualización se realizó correctamente.
        } else {
            return false; // Ocurrió un error al actualizar.
        }
    }

    public function buscarCasos($term)
    {
        return $this->like('proceso', $term)
            ->orLike('caseID', $term)
            ->orderBy('fecha_actualizacion', 'DESC')
            ->limit(10)
            ->findAll();
    }
}
