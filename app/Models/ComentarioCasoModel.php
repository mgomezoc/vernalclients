<?php

namespace App\Models;

use CodeIgniter\Model;

class ComentarioCasoModel extends Model
{
    protected $table = 'comentarios_caso'; // Nombre de la tabla
    protected $primaryKey = 'id_comentario'; // Llave primaria

    protected $useAutoIncrement = true; // Utilizar autoincremento

    protected $returnType     = 'array'; // Tipo de datos que retorna
    protected $useSoftDeletes = false; // Soft Deletes no utilizado

    protected $allowedFields = ['id_caso', 'id_usuario', 'comentario', 'fecha_creacion']; // Campos asignables

    protected $useTimestamps = true; // Habilitar timestamps
    protected $createdField  = 'fecha_creacion'; // Campo para timestamp al crear
    protected $updatedField  = ''; // No se usa campo de actualización
    protected $deletedField  = ''; // No se usa campo de eliminación

    // Reglas de validación
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Obtiene todos los comentarios de un caso específico junto con el nombre del usuario que los creó.
     *
     * @param int $idCaso ID del caso
     * @return array
     */
    public function obtenerComentariosPorCaso($idCaso)
    {
        return $this->select('comentarios_caso.*, usuarios.nombre AS nombre_usuario')
            ->join('usuarios', 'comentarios_caso.id_usuario = usuarios.id', 'left')
            ->where('comentarios_caso.id_caso', $idCaso)
            ->findAll();
    }

    /**
     * Agrega un nuevo comentario a un caso.
     *
     * @param array $data Datos del comentario
     * @return bool|int ID del comentario creado o false en caso de error
     */
    public function agregarComentario($data)
    {
        $this->insert($data);

        return $this->getInsertID();
    }

    /**
     * Actualiza un comentario específico.
     *
     * @param int $idComentario ID del comentario
     * @param array $data Datos a actualizar
     * @return bool
     */
    public function actualizarComentario($idComentario, $data)
    {
        return $this->update($idComentario, $data);
    }

    /**
     * Elimina un comentario específico.
     *
     * @param int $idComentario ID del comentario
     * @return bool
     */
    public function eliminarComentario($idComentario)
    {
        return $this->delete($idComentario);
    }
}
