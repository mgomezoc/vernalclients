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

    /** 📊 KPI - Total clientes nuevos por periodo (Prospecto o Intake) */
    public function getClientesNuevosPorPeriodo($inicio = null, $fin = null)
    {
        $builder = $this->db->table('clientes');
        $builder->whereIn('estatus', [1, 2]);
        if ($inicio) $builder->where('fecha_creado >=', $inicio);
        if ($fin) $builder->where('fecha_creado <=', $fin);
        return ['total' => $builder->countAllResults()];
    }

    /** 📊 KPI - Total casos activos */
    public function getTotalCasosActivos()
    {
        return ['activos' => $this->db->table('casos')->where('estatus', 3)->countAllResults()];
    }

    /** 📊 KPI - Total casos con corte próximo */
    public function getTotalCasosCorteProxima()
    {
        return ['total' => $this->db->table('casos')
            ->where('fecha_corte >=', date('Y-m-d'))
            ->where('fecha_corte <=', date('Y-m-d', strtotime('+30 days')))
            ->countAllResults()];
    }

    /** 📊 Formularios por sucursal por mes */
    public function getFormulariosPorSucursalMes($inicio = null, $fin = null)
    {
        $builder = $this->db->table('intake')
            ->select("sucursal_nombre AS sucursal, MONTH(fecha_consulta) AS mes, COUNT(*) AS total")
            ->groupBy('sucursal_nombre, mes')
            ->orderBy('mes');
        if ($inicio) $builder->where('fecha_consulta >=', $inicio);
        if ($fin) $builder->where('fecha_consulta <=', $fin);
        return $builder->get()->getResultArray();
    }

    /** 📊 Casos activos vs cerrados por tipo */
    public function getCasosActivosVsCerradosPorTipo()
    {
        return $this->db->table('casos c')
            ->select("t.nombre AS tipo, e.nombre AS estatus, COUNT(*) AS total")
            ->join('casos_tipos t', 'c.id_tipo_caso = t.id_tipo_caso')
            ->join('casos_estatus e', 'c.estatus = e.id_caso_estatus')
            ->groupBy('c.id_tipo_caso, c.estatus')
            ->get()
            ->getResultArray();
    }

    /** 📁 Casos con más comentarios */
    public function getCasosConMasComentarios()
    {
        return $this->db->table('comentarios_caso')
            ->select("id_caso AS caso, COUNT(*) AS total")
            ->groupBy('id_caso')
            ->orderBy('total', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    /** 📁 Casos con más documentos */
    public function getCasosConMasDocumentos()
    {
        return $this->db->table('documentos_caso')
            ->select("id_caso AS caso, COUNT(*) AS total")
            ->groupBy('id_caso')
            ->orderBy('total', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    /** 📁 Clientes con documentos sin caso */
    public function getClientesConDocumentosSinCaso()
    {
        return $this->db->table('expediente_cliente')
            ->select("id_cliente AS cliente, COUNT(*) AS total")
            ->where('id_caso IS NULL')
            ->groupBy('id_cliente')
            ->get()
            ->getResultArray();
    }

    /** 💰 Ingresos por forma de pago */
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

    /** 💰 Casos no pagados */
    public function getCasosNoPagados()
    {
        return $this->db->table('casos')
            ->select("id_caso AS caso, proceso, costo, pagado")
            ->where('pagado', 0)
            ->get()
            ->getResultArray();
    }

    /** 👤 Clientes con solicitudes de asilo */
    public function getClientesAsiloPendiente()
    {
        return $this->db->table('intake')
            ->select("id_cliente AS cliente, beneficiario_nombre, estatus_migratorio_actual")
            ->where('proceso', 'asilo')
            ->get()
            ->getResultArray();
    }

    /** 👤 Clientes con arrestos */
    public function getClientesConArrestos()
    {
        return $this->db->table('intake')
            ->select("id_cliente AS cliente, beneficiario_nombre, arrestado")
            ->where('arrestado', 'Si')
            ->get()
            ->getResultArray();
    }

    /** 👤 Clientes por visa y entrada */
    public function getClientesPorVisaYEntrada()
    {
        return $this->db->table('intake')
            ->select("tipo_visa, como_entro_eeuu, COUNT(*) AS total")
            ->groupBy('tipo_visa, como_entro_eeuu')
            ->get()
            ->getResultArray();
    }

    /** ⏱️ Tiempo promedio entre consulta y caso */
    public function getTiempoPromedioConsultaCaso()
    {
        return $this->db->query("
            SELECT AVG(DATEDIFF(c.fecha_creacion, f.fecha_consulta)) AS valor
            FROM casos c
            JOIN formulario_admision f ON c.id_cliente = f.id_cliente
        ")->getRowArray();
    }

    /** 👤 Clientes con proceso migratorio previo */
    public function getClientesConProcesoPrevio()
    {
        return $this->db->table('intake')
            ->select("id_cliente AS cliente, beneficiario_nombre, proceso_migracion_explicacion")
            ->where('proceso_migracion', 'Si')
            ->get()
            ->getResultArray();
    }

    /** 👤 Clientes por fuente */
    public function getClientesPorFuente()
    {
        $rawData = $this->db->table('intake')
            ->select("fuente_informacion")
            ->where("fuente_informacion IS NOT NULL")
            ->get()
            ->getResultArray();

        $fuentes = [];

        foreach ($rawData as $row) {
            $fuenteStr = $row['fuente_informacion'];
            $items = array_map('trim', explode('|', $fuenteStr));

            foreach ($items as $item) {
                if ($item !== '') {
                    $fuentes[$item] = isset($fuentes[$item]) ? $fuentes[$item] + 1 : 1;
                }
            }
        }

        arsort($fuentes);

        $result = [];
        foreach ($fuentes as $fuente => $total) {
            $result[] = ['fuente' => $fuente, 'total' => $total];
        }

        return $result;
    }


    /** 📌 Promedio de satisfacción */
    public function getPromedioSatisfaccion()
    {
        return $this->db->table('encuesta_respuestas')
            ->select("AVG(probabilidad_recomendacion) AS recomendacion, AVG(calificacion_servicio) AS servicio, AVG(profesionalismo_actitud) AS actitud, AVG(precio_valor_correspondencia) AS valor")
            ->get()
            ->getRowArray();
    }

    /** 📌 Respuestas negativas */
    public function getRespuestasNegativas()
    {
        return $this->db->table('encuesta_respuestas')
            ->select("COUNT(*) AS valor")
            ->where('tiempo_respuesta_adeuado', 'no')
            ->get()
            ->getRowArray();
    }

    /** 🔍 Casos con corte próximo */
    public function getCasosConFechaCorteProxima()
    {
        return $this->db->table('casos')
            ->select("id_caso AS caso, proceso, DATE_FORMAT(fecha_corte, '%m/%d/%Y') AS fecha_corte")
            ->where('fecha_corte >=', date('Y-m-d'))
            ->where('fecha_corte <=', date('Y-m-d', strtotime('+30 days')))
            ->orderBy('fecha_corte')
            ->get()
            ->getResultArray();
    }

    /** 🔍 Casos con límite vencido */
    public function getCasosConLimiteVencido()
    {
        return $this->db->table('casos')
            ->select("id_caso AS caso, proceso, DATE_FORMAT(limite_tiempo, '%m/%d/%Y') AS limite_tiempo")
            ->where('limite_tiempo <=', date('Y-m-d', strtotime('+7 days')))
            ->orderBy('limite_tiempo')
            ->get()
            ->getResultArray();
    }

    /** 🔍 Casos por abogado */
    public function getCasosPorAbogado()
    {
        return $this->db->table('cliente_abogado ca')
            ->select("CONCAT(u.nombre, ' ', u.apellido_paterno) AS abogado, COUNT(*) AS total")
            ->join('usuarios u', 'ca.id_usuario = u.id')
            ->groupBy('ca.id_usuario')
            ->get()
            ->getResultArray();
    }

    /** 📊 Ingresos mensuales */
    public function getIngresosMensualesComparativos()
    {
        return $this->db->query("
            SELECT 
                DATE_FORMAT(fecha_pago, '%m/%Y') AS mes, 
                SUM(monto) AS total
            FROM pagos_consultas
            WHERE estatus_pago = 'completado'
            GROUP BY mes
            ORDER BY mes DESC
            LIMIT 12
        ")->getResultArray();
    }

    /** 📊 Promedio duración caso */
    public function getPromedioTiempoCasoAbierto()
    {
        return $this->db->query("
            SELECT AVG(DATEDIFF(fecha_cierre, fecha_creacion)) AS valor
            FROM casos
            WHERE fecha_cierre IS NOT NULL
        ")->getRowArray();
    }

    /** 📊 Conversión por fuente */
    public function getFuentesClientesConConversion()
    {
        return $this->db->query("
            SELECT 
                fuente_informacion,
                COUNT(*) AS total,
                SUM(CASE WHEN id_cliente IN (SELECT DISTINCT id_cliente FROM casos) THEN 1 ELSE 0 END) AS convertidos
            FROM intake
            GROUP BY fuente_informacion
            ORDER BY total DESC
        ")->getResultArray();
    }

    /** ⚠️ Casos sin actualizar > 30 días */
    public function getCasosSinActualizar()
    {
        return [
            'total' => $this->db->table('casos')
                ->where('estatus', 3)
                ->where('fecha_actualizacion <', date('Y-m-d', strtotime('-30 days')))
                ->countAllResults()
        ];
    }
}
