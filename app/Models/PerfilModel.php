<?php

namespace App\Models;

use CodeIgniter\Model;

class PerfilModel extends Model
{
    protected $table = 'perfiles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre'];

    public function getPerfilByName($name)
    {
        return $this->where('nombre', $name)->first();
    }
}
