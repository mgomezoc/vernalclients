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

    /**
     * Obtiene los pagos de consulta con filtros y paginación.
     *
     * @param int $limit Límite de resultados por página
     * @param int $offset Desplazamiento de resultados
     * @param array $filters Filtros aplicables (cliente, usuario, periodo, estatus, etc.)
     * @return array Resultados de la consulta
     */
    public function obtenerPagos(int $limit = 10, int $offset = 0, array $filters = [])
    {
        $this->select('pagos_consultas.*, clientes.nombre AS nombre_cliente, usuarios.nombre AS nombre_usuario')
            ->join('clientes', 'clientes.id_cliente = pagos_consultas.id_cliente')
            ->join('usuarios', 'usuarios.id = pagos_consultas.id_usuario')
            ->limit($limit, $offset)
            ->orderBy('fecha_pago', 'DESC');

        // Aplicar filtros
        if (!empty($filters['cliente'])) {
            $this->where('pagos_consultas.id_cliente', $filters['cliente']);
        }

        if (!empty($filters['usuario'])) {
            $this->where('pagos_consultas.id_usuario', $filters['usuario']);
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

        // Ejecutar la consulta y devolver resultados
        return $this->findAll();
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
