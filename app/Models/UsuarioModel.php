<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios'; // Nombre de la tabla
    protected $primaryKey = 'id'; // Clave primaria
    protected $allowedFields = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo_electronico',
        'perfil',
        'contrasena',
        'fecha_creacion'
    ]; // Campos permitidos para inserción y actualización
    protected $useTimestamps = true; // Indica si se utilizan timestamps automáticos
}
