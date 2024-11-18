<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoConsultaModel extends Model
{
    protected $table = 'pagos_consultas';             // Nombre de la tabla
    protected $primaryKey = 'id_pago';                // Llave primaria
    protected $useAutoIncrement = true;               // Utilizar autoincremento
    protected $returnType = 'array';                  // Tipo de datos que retorna
    protected $useSoftDeletes = false;                // Soft Deletes no utilizado

    // Campos asignables
    protected $allowedFields = [
        'id_cliente',
        'id_usuario',
        'monto',
        'fecha_pago',
        'forma_pago',
        'estatus_pago',
        'referencia',
        'notas'
    ];

    // Habilitar timestamps (opcional, si se utilizan en los allowedFields)
    protected $useTimestamps = false;

    /**
     * Agrega un nuevo pago de consulta.
     *
     * @param array $data Datos del pago
     * @return int|bool ID del pago creado o false en caso de error
     */
    public function agregarPago(array $data)
    {
        $this->insert($data);
        return $this->getInsertID();
    }

    /**
     * Elimina un pago de consulta específico.
     *
     * @param int $idPago ID del pago
     * @return bool True si se eliminó correctamente, False en caso contrario
     */
    public function eliminarPago(int $idPago)
    {
        return $this->delete($idPago);
    }

    public function obtenerPagosPaginados(int $limit, int $offset, array $filters)
    {
        $builder = $this->db->table($this->table);

        // Join con las tablas relacionadas
        $builder->join('clientes', 'clientes.id_cliente = pagos_consultas.id_cliente', 'left');
        $builder->join('usuarios', 'usuarios.id = pagos_consultas.id_usuario', 'left');

        // Seleccionar columnas necesarias con alias
        $builder->select('pagos_consultas.*, 
                      clientes.nombre AS nombre_cliente, 
                      usuarios.nombre AS nombre_usuario');

        // Aplicar filtros
        if (!empty($filters['cliente'])) {
            $builder->where('pagos_consultas.id_cliente', $filters['cliente']);
        }

        if (!empty($filters['usuario'])) {
            $builder->where('pagos_consultas.id_usuario', $filters['usuario']);
        }

        if (!empty($filters['periodo'])) {
            $periodo = explode(' to ', $filters['periodo']);
            if (count($periodo) === 2) {
                $builder->where('pagos_consultas.fecha_pago >=', $periodo[0]);
                $builder->where('pagos_consultas.fecha_pago <=', $periodo[1]);
            }
        }

        if (!empty($filters['forma_pago'])) {
            $builder->where('pagos_consultas.forma_pago', $filters['forma_pago']);
        }

        if (!empty($filters['estatus_pago'])) {
            $builder->where('pagos_consultas.estatus_pago', $filters['estatus_pago']);
        }

        // Filtro de búsqueda
        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('clientes.nombre', $filters['search'])
                ->orLike('pagos_consultas.id_pago', $filters['search'])
                ->orLike('pagos_consultas.referencia', $filters['search'])
                ->groupEnd();
        }

        // Clonar el builder para calcular el total antes de aplicar límites
        $countQuery = clone $builder;
        $total = $countQuery->countAllResults(false);

        // Aplicar paginación
        $builder->limit($limit, $offset);
        $builder->orderBy('pagos_consultas.fecha_pago', 'desc');

        // Obtener resultados paginados
        $rows = $builder->get()->getResultArray();

        return [
            'total' => $total,  // Total de registros antes de aplicar límites
            'rows' => $rows     // Registros con paginación aplicada
        ];
    }


    /**
     * Obtiene el total de pagos según los filtros aplicados.
     *
     * @param array $filters Filtros aplicables
     * @return int Cantidad total de resultados
     */
    public function contarPagos(array $filters = []): int
    {
        $this->select('id_pago');

        // Aplicar los mismos filtros que en `obtenerPagos`
        if (!empty($filters['cliente'])) {
            $this->where('id_cliente', $filters['cliente']);
        }

        if (!empty($filters['usuario'])) {
            $this->where('id_usuario', $filters['usuario']);
        }

        if (!empty($filters['periodo'])) {
            $this->where('fecha_pago >=', $filters['periodo']['inicio'])
                ->where('fecha_pago <=', $filters['periodo']['fin']);
        }

        if (!empty($filters['forma_pago'])) {
            $this->where('forma_pago', $filters['forma_pago']);
        }

        if (!empty($filters['estatus_pago'])) {
            $this->where('estatus_pago', $filters['estatus_pago']);
        }

        return $this->countAllResults();
    }
}
