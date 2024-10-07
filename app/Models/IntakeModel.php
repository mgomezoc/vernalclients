<?php

namespace App\Models;

use CodeIgniter\Model;

class IntakeModel extends Model
{
    protected $table = 'intake';
    protected $primaryKey = 'id';

    // Lista de campos permitidos para inserciones y actualizaciones
    protected $allowedFields = [
        'id_cliente',
        'fecha_consulta',
        'proceso',
        'a_number',
        'contacto',
        'horario_contacto',
        'sucursal',
        'sucursal_nombre',
        'es_primera_consulta',
        'fecha_ultima_consulta',
        'arrestado',
        'como_entro_eeuu',
        'tipo_visa',
        'nationality',
        'radio-nacionalidad',
        'segunda_nacionalidad',
        'direccion_cp',
        'direccion_pais',
        'motivo_visita',
        'direccion_calle_numero',
        'direccion_ciudad',
        'direccion_telefono',
        'direccion_email',
        'beneficiario_nombre',
        'beneficiario_genero',
        'beneficiario_fecha_nacimiento',
        'beneficiario_estado_civil',
        'estatus_migratorio_actual',
        'fecha_ultima_entrada',
        'solicitud_migratoria',
        'solicitud_migratoria_explicacion',
        'proceso_migracion',
        'proceso_migracion_explicacion',
        'fuente_informacion',
        'arrestado_fecha_cargo',
        'arrestado_explicacion',
        'parientes',
        'familiar_servicio',
        'familiar_servicio_parentesco',
        'victima_crimen',
        'victima_crimen_info',
        'cometido_crimen',
        'proceso_relacion',
        'beneficiario_vive_ambos_padres',
        'peticionario_nombre',
        'peticionario_telefono',
        'peticionario_relacion',
        'peticionario_direccion'
    ];

    /**
     * Método para insertar un formulario de admisión
     *
     * @param array $data
     * @return bool|int
     */
    public function insertarFormularioAdmision(array $data)
    {
        return $this->insert($data);
    }

    /**
     * Obtener formulario de admisión por id_cliente
     *
     * @param int $id_cliente
     * @return array|null
     */
    public function obtenerFormularioPorCliente(int $id_cliente)
    {
        return $this->where('id_cliente', $id_cliente)->first();
    }

    /**
     * Actualizar formulario de admisión por id_cliente
     *
     * @param int $id_cliente
     * @param array $data
     * @return bool
     */
    public function actualizarFormularioPorCliente(int $id_cliente, array $data)
    {
        // Verifica si el registro existe antes de actualizar
        if ($this->where('id_cliente', $id_cliente)->first()) {
            return $this->where('id_cliente', $id_cliente)->set($data)->update();
        }

        return false;
    }

    /**
     * Eliminar formulario de admisión por id_cliente
     *
     * @param int $id_cliente
     * @return bool
     */
    public function eliminarFormularioPorCliente(int $id_cliente)
    {
        return $this->where('id_cliente', $id_cliente)->delete();
    }
}
