<?php

namespace App\Models;

use CodeIgniter\Model;

class EncuestaRespuestaModel extends Model
{
    protected $table      = 'encuesta_respuestas'; // Nombre de la tabla
    protected $primaryKey = 'id'; // Clave primaria

    protected $useAutoIncrement = true; // Usar autoincremento para la clave primaria

    protected $returnType     = 'array'; // Tipo de datos a devolver
    protected $useSoftDeletes = false; // No usar borrado suave

    protected $allowedFields = [ // Campos permitidos para insertar y actualizar
        'slug_cliente',
        'probabilidad_recomendacion',
        'calificacion_servicio',
        'tiempo_respuesta_adeuado',
        'profesionalismo_actitud',
        'precio_valor_correspondencia',
        'comentarios_sugerencias'
    ];

    protected $useTimestamps = true; // Usar campos de timestamp
    protected $createdField  = 'fecha_creacion'; // Campo para timestamp de creación
    protected $updatedField  = ''; // No se define campo de actualización
    protected $deletedField  = ''; // No se define campo de borrado

    // Reglas de validación
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getRegistros()
    {
        return $this->findAll();
    }

    public function obtenerTablaEncuestas()
    {
        $builder = $this->db->table('encuesta_respuestas');
        $builder->select('encuesta_respuestas.*, clientes.nombre as nombre_cliente');
        $builder->join('clientes', 'clientes.slug = encuesta_respuestas.slug_cliente');
        return $builder->get()->getResultArray();
    }
}
