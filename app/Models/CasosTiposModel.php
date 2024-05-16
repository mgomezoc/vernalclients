<?php

namespace App\Models;

use CodeIgniter\Model;

class CasosTiposModel extends Model
{
    protected $table = 'casos_tipos'; // Define el nombre de la tabla
    protected $primaryKey = 'id_tipo_caso'; // Establece la clave primaria

    protected $useAutoIncrement = true; // Utiliza el autoincremento del ID
    protected $returnType     = 'array'; // Tipo de datos que retorna
    protected $useSoftDeletes = false; // Si se requiere, para borrado lógico

    protected $allowedFields = ['nombre', 'costo']; // Campos asignables

    // Reglas de validación
    protected $validationRules = [
        'nombre' => 'required|max_length[255]',
        'costo' => 'required|decimal'
    ];

    // Mensajes de validación personalizados (opcional)
    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre del tipo de caso es obligatorio',
            'max_length' => 'El nombre no puede exceder los 255 caracteres'
        ],
        'costo' => [
            'required' => 'El costo del tipo de caso es obligatorio',
            'decimal' => 'El costo debe ser un número decimal válido'
        ]
    ];

    // Protección contra asignación masiva
    protected $protectFields = true;

    // Métodos para la manipulación de la base de datos

    // Obtener todos los tipos de casos
    public function obtenerTodos()
    {
        return $this->findAll();
    }

    // Agregar un nuevo tipo de caso
    public function agregar($data)
    {
        return $this->insert($data);
    }

    // Editar un tipo de caso existente
    public function editar($id, $data)
    {
        return $this->update($id, $data);
    }

    // Eliminar un tipo de caso
    public function eliminar($id)
    {
        return $this->delete($id);
    }
}
