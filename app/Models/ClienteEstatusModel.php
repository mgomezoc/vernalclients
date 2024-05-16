<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteEstatusModel extends Model
{
    protected $table      = 'clientes_estatus';
    protected $primaryKey = 'id_cliente_estatus';
    protected $allowedFields = ['nombre'];

    /**
     * Obtiene todos los estatus de los clientes.
     *
     * @return array
     */
    public function obtenerTodosEstatus()
    {
        return $this->findAll();
    }
}
