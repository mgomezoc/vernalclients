<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaModel extends Model
{
    protected $table = 'auditoria';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_usuario', 'accion', 'detalle', 'fecha'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha';
    protected $updatedField  = '';

    public function obtenerAuditoriaPaginada($limit, $offset, $filtros)
    {
        $builder = $this->db->table($this->table);
        $builder->join('usuarios', 'usuarios.id = auditoria.id_usuario');
        $builder->select('auditoria.*, usuarios.nombre as usuario');

        if (!empty($filtros['usuario'])) {
            $builder->where('auditoria.id_usuario', $filtros['usuario']);
        }

        if (!empty($filtros['accion'])) {
            $builder->like('auditoria.accion', $filtros['accion']);
        }

        if (!empty($filtros['periodo'])) {
            $periodo = explode(' to ', $filtros['periodo']);
            if (count($periodo) === 2) {
                $fechaInicio = date('Y-m-d', strtotime($periodo[0]));
                $fechaFin = date('Y-m-d', strtotime($periodo[1]));
                $builder->where('auditoria.fecha >=', $fechaInicio);
                $builder->where('auditoria.fecha <=', $fechaFin);
            }
        }

        $builder->orderBy('auditoria.fecha', 'desc');
        $builder->limit($limit, $offset);

        $result = $builder->get()->getResultArray();

        $countQuery = clone $builder;
        $countQuery->select("COUNT(*) as total");
        $total = $countQuery->get()->getRow()->total;

        return [
            'total' => $total,
            'rows' => $result
        ];
    }
}
