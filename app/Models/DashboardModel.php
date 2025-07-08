<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    /**
     * Obtiene la cantidad de clientes nuevos en un rango de fechas
     */
    public function getClientesNuevosPorPeriodo($inicio = null, $fin = null)
    {
        $builder = $this->db->table('clientes')->whereIn('estatus', [1, 2]);
        if ($inicio) $builder->where('fecha_creado >=', $inicio);
        if ($fin) $builder->where('fecha_creado <=', $fin);
        return ['total' => $builder->countAllResults()];
    }

    /**
     * Obtiene el total de formularios agrupado por sucursal y mes
     */
    public function getFormulariosPorSucursalMes($inicio = null, $fin = null)
    {
        $builder = $this->db->table('intake')
            ->select("TRIM(UPPER(sucursal_nombre)) AS sucursal, MONTH(fecha_consulta) AS mes, COUNT(*) AS total")
            ->groupBy(["TRIM(UPPER(sucursal_nombre))", "MONTH(fecha_consulta)"])
            ->orderBy('mes');
        if ($inicio) $builder->where('fecha_consulta >=', $inicio);
        if ($fin) $builder->where('fecha_consulta <=', $fin);
        return $builder->get()->getResultArray();
    }

    /**
     * Casos agrupados por tipo y estatus
     */
    public function getCasosActivosVsCerradosPorTipo()
    {
        return $this->db->table('casos c')
            ->select("TRIM(t.nombre) AS tipo, e.nombre AS estatus, COUNT(*) AS total")
            ->join('casos_tipos t', 'c.id_tipo_caso = t.id_tipo_caso')
            ->join('casos_estatus e', 'c.estatus = e.id_caso_estatus')
            ->groupBy(["TRIM(t.nombre)", "e.nombre"])
            ->get()
            ->getResultArray();
    }

    /**
     * Casos con más comentarios
     */
    public function getCasosConMasComentarios($inicio = null, $fin = null)
    {
        $builder = $this->db->table('comentarios_caso')
            ->select("id_caso AS caso, COUNT(*) AS total")
            ->groupBy('id_caso')
            ->orderBy('total', 'DESC')
            ->limit(10);
        if ($inicio) $builder->where('fecha_comentario >=', $inicio);
        if ($fin) $builder->where('fecha_comentario <=', $fin);
        return $builder->get()->getResultArray();
    }

    /**
     * Casos con más documentos subidos
     */
    public function getCasosConMasDocumentos($inicio = null, $fin = null)
    {
        $builder = $this->db->table('documentos_caso')
            ->select("id_caso AS caso, COUNT(*) AS total")
            ->groupBy('id_caso')
            ->orderBy('total', 'DESC')
            ->limit(10);
        if ($inicio) $builder->where('fecha_subida >=', $inicio);
        if ($fin) $builder->where('fecha_subida <=', $fin);
        return $builder->get()->getResultArray();
    }

    /**
     * Clientes que tienen documentos pero no tienen casos asociados
     */
    public function getClientesConDocumentosSinCaso($inicio = null, $fin = null)
    {
        $builder = $this->db->table('expediente_cliente')
            ->select("id_cliente AS cliente, COUNT(*) AS total")
            ->where('id_caso IS NULL')
            ->groupBy('id_cliente');
        if ($inicio) $builder->where('fecha_subida >=', $inicio);
        if ($fin) $builder->where('fecha_subida <=', $fin);
        return $builder->get()->getResultArray();
    }

    /**
     * Ingresos totales agrupados por forma de pago en un periodo
     */
    public function getIngresosPorFormaPago($inicio = null, $fin = null)
    {
        $builder = $this->db->table('pagos_consultas')
            ->select("forma_pago, SUM(monto) AS total")
            ->where('estatus_pago', 'completado')
            ->groupBy('forma_pago');
        if ($inicio) $builder->where('fecha_pago >=', $inicio);
        if ($fin) $builder->where('fecha_pago <=', $fin);
        return $builder->get()->getResultArray();
    }

    /**
     * Casos con saldo pendiente (no pagados o parcialmente pagados)
     */
    public function getCasosNoPagados($inicio = null, $fin = null)
    {
        $builder = $this->db->table('casos')
            ->select("id_caso AS caso, proceso, costo, pagado")
            ->where('pagado', 0);
        if ($inicio) $builder->where('fecha_creacion >=', $inicio);
        if ($fin) $builder->where('fecha_creacion <=', $fin);
        return $builder->get()->getResultArray();
    }

    /**
     * Clientes cuyo formulario indica que están en proceso de asilo
     */
    public function getClientesAsiloPendiente($inicio = null, $fin = null)
    {
        $builder = $this->db->table('intake')
            ->select("id_cliente AS cliente, beneficiario_nombre, estatus_migratorio_actual")
            ->where('proceso', 'asilo');
        if ($inicio) $builder->where('fecha_consulta >=', $inicio);
        if ($fin) $builder->where('fecha_consulta <=', $fin);
        return $builder->get()->getResultArray();
    }

    /**
     * Clientes con historial de arresto
     */
    public function getClientesConArrestos($inicio = null, $fin = null)
    {
        $builder = $this->db->table('intake')
            ->select("id_cliente AS cliente, beneficiario_nombre, arrestado")
            ->where('arrestado', 'Si');
        if ($inicio) $builder->where('fecha_consulta >=', $inicio);
        if ($fin) $builder->where('fecha_consulta <=', $fin);
        return $builder->get()->getResultArray();
    }

    /**
     * Clientes agrupados por tipo de visa y método de entrada a EEUU
     */
    public function getClientesPorVisaYEntrada($inicio = null, $fin = null)
    {
        $builder = $this->db->table('intake')
            ->select("tipo_visa, como_entro_eeuu, COUNT(*) AS total")
            ->groupBy(['tipo_visa', 'como_entro_eeuu']);
        if ($inicio) $builder->where('fecha_consulta >=', $inicio);
        if ($fin) $builder->where('fecha_consulta <=', $fin);
        return $builder->get()->getResultArray();
    }

    /**
     * Promedio de días entre consulta y creación del caso
     */
    public function getTiempoPromedioConsultaCaso($inicio = null, $fin = null)
    {
        $cond = '';
        if ($inicio) $cond .= " AND f.fecha_consulta >= " . $this->db->escape($inicio);
        if ($fin) $cond .= " AND f.fecha_consulta <= " . $this->db->escape($fin);

        return $this->db->query("
            SELECT AVG(DATEDIFF(c.fecha_creacion, f.fecha_consulta)) AS valor
            FROM casos c
            JOIN formulario_admision f ON c.id_cliente = f.id_cliente
            WHERE 1=1 $cond
        ")->getRowArray();
    }

    /**
     * Clientes que tuvieron procesos migratorios previos
     */
    public function getClientesConProcesoPrevio($inicio = null, $fin = null)
    {
        $builder = $this->db->table('intake')
            ->select("id_cliente AS cliente, beneficiario_nombre, proceso_migracion_explicacion")
            ->where('proceso_migracion', 'Si');
        if ($inicio) $builder->where('fecha_consulta >=', $inicio);
        if ($fin) $builder->where('fecha_consulta <=', $fin);
        return $builder->get()->getResultArray();
    }

    /**
     * Casos que llevan más de 30 días sin actualizarse
     */
    public function getCasosSinActualizar($inicio = null, $fin = null)
    {
        $builder = $this->db->table('casos')
            ->where('estatus', 3)
            ->where('fecha_actualizacion <', date('Y-m-d', strtotime('-30 days')));
        if ($inicio) $builder->where('fecha_actualizacion >=', $inicio);
        if ($fin) $builder->where('fecha_actualizacion <=', $fin);
        return ['total' => $builder->countAllResults()];
    }

    // Otros métodos como getPromedioSatisfaccion, getRespuestasNegativas,
    // getCasosPorAbogado, getCasosConFechaCorteProxima, getCasosConLimiteVencido, etc.,
    // no dependen de fechas históricas o tienen lógica específica y pueden mantenerse como están.
}
