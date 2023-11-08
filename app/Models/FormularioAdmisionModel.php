<?php

namespace App\Models;

use CodeIgniter\Model;

class FormularioAdmisionModel extends Model
{
    protected $table      = 'formulario_admision';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id_cliente', 'fecha_consulta', 'datos_admision'];

    // Función para insertar un nuevo registro
    public function insertarFormularioAdmision($data)
    {
        return $this->save($data);
    }

    // Función para editar un formulario de admisión existente
    public function editarFormularioAdmision($id, $data)
    {
        return $this->update($id, $data);
    }

    // Función para eliminar un formulario de admisión
    public function eliminarFormularioAdmision($id)
    {
        return $this->delete($id);
    }

    // Función para buscar un formulario de admisión por id_cliente
    public function obtenerPorIdCliente($id_cliente)
    {
        return $this->where('id_cliente', $id_cliente)->first();
    }
}
