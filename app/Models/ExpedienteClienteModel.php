<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpedienteClienteModel extends Model
{
    protected $table = 'expediente_cliente';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_cliente',
        'id_caso',
        'nombre_documento',
        'path_documento',
        'tipo_documento',
        'tamano_documento',
        'fecha_subida',
        'subido_por'
    ];
}
