<?php

namespace App\Models;

use CodeIgniter\Model;

class SucursalModel extends Model
{
    protected $table = 'sucursales';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre',
        'direccion',
        'telefono',
        'url_google_maps',
        'imagen',
        'fecha_creacion'
    ];

    public function obtenerTodas()
    {
        return $this->findAll();
    }

    public function agregarSucursal($data)
    {
        return $this->insert($data);
    }

    public function editarSucursal($id, $data)
    {
        return $this->update($id, $data);
    }

    public function eliminarSucursal($id)
    {
        return $this->delete($id);
    }
}
