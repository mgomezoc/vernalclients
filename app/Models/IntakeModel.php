<?php

namespace App\Models;

use CodeIgniter\Model;

class IntakeModel extends Model
{
    protected $table = 'intake';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_cliente',
        'proceso',
        'a_number',
        'contacto',
        'sucursal',
        'arrestado',
        'tipo_visa',
        'nationality',
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
        'proceso_migracion',
        'fuente_informacion',
        'arrestado_fecha_cargo',
        'arrestado_explicacion',
        'parientes',
        'familiar_servicio',
        'familiar_servicio_parentesco',
        'proceso_migracion_explicacion',
        'solicitud_migratoria_explicacion',
        'victima_crimen',
        'victima_crimen_info',
        'cometido_crimen',
        'proceso_relacion',
        'beneficiario_vive_ambos_padres',
        'fecha_consulta'
    ];

    // Método para insertar un formulario de admisión
    public function insertarFormularioAdmision(array $data)
    {
        return $this->insert($data);
    }
}
