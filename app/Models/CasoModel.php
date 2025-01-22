<?php

namespace App\Models;

use CodeIgniter\Model;

class CasoModel extends Model
{
    protected $table = 'casos';
    protected $primaryKey = 'id_caso';

    protected $allowedFields = [
        'id_cliente',
        'id_usuario',
        'id_tipo_caso',
        'proceso',
        'comentarios',
        'costo',
        'fecha_creacion',
        'fecha_actualizacion',
        'estatus',
        'caseID',
        'procesos_adicionales',
        'fecha_corte',
        'limite_tiempo',
        'pagado',
        'forma_pago'
    ];

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
        return $this->where('id_cliente', $idCliente)
            ->orderBy('fecha_creacion', 'DESC')
            ->findAll();
    }

    // Actualizar CaseID
    public function actualizarCaseID($id_caso, $caseID)
    {
        $data = ['caseID' => $caseID];
        return $this->update($id_caso, $data);
    }

    // Actualizar Estatus de Caso
    public function actualizarEstatusCaso($idCaso, $nuevoEstatus)
    {
        $data = [
            'estatus' => $nuevoEstatus,
            'fecha_actualizacion' => date('Y-m-d H:i:s')
        ];

        $this->where('id_caso', $idCaso);

        return $this->update($idCaso, $data);
    }

    // Buscar casos
    public function buscarCasos($term)
    {
        return $this->like('proceso', $term)
            ->orLike('caseID', $term)
            ->orLike('id_caso', $term)
            ->orderBy('fecha_actualizacion', 'DESC')
            ->limit(10)
            ->findAll();
    }
}
