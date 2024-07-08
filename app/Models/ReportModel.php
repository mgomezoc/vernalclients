<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table = 'casos'; // Puedes cambiar esto si deseas establecer una tabla predeterminada

    // Informe de Casos por Estatus
    public function getCasosPorEstatus()
    {
        return $this->db->table('casos c')
            ->select('ce.nombre AS estatus, COUNT(c.id_caso) AS total_casos')
            ->join('casos_estatus ce', 'c.estatus = ce.id_caso_estatus')
            ->groupBy('ce.nombre')
            ->get()
            ->getResultArray();
    }

    // Informe de Casos por Tipo
    public function getCasosPorTipo()
    {
        return $this->db->table('casos c')
            ->select('ct.nombre AS tipo_caso, COUNT(c.id_caso) AS total_casos, SUM(c.costo) AS costo_total')
            ->join('casos_tipos ct', 'c.id_tipo_caso = ct.id_tipo_caso')
            ->groupBy('ct.nombre')
            ->get()
            ->getResultArray();
    }

    // Casos por Abogado
    public function getCasosPorAbogado()
    {
        return $this->db->table('casos c')
            ->select('u.nombre, COUNT(c.id_caso) AS total_casos')
            ->join('usuarios u', 'c.id_usuario = u.id')
            ->groupBy('u.nombre')
            ->get()
            ->getResultArray();
    }

    // Casos por Sucursal
    public function getCasosPorSucursal()
    {
        return $this->db->table('casos c')
            ->select('s.nombre AS sucursal, COUNT(c.id_caso) AS total_casos')
            ->join('usuarios u', 'c.id_usuario = u.id')
            ->join('abogados a', 'u.id = a.id_usuario')
            ->join('sucursales s', 'a.id_sucursal = s.id')
            ->groupBy('s.nombre')
            ->get()
            ->getResultArray();
    }

    // Casos Pagados vs No Pagados
    public function getCasosPagadosVsNoPagados()
    {
        return $this->db->table('casos')
            ->select("CASE WHEN pagado = 1 THEN 'Pagado' ELSE 'No Pagado' END AS estado_pago, COUNT(id_caso) AS total_casos")
            ->groupBy('pagado')
            ->get()
            ->getResultArray();
    }

    // Clientes por Sucursal
    public function getClientesPorSucursal()
    {
        return $this->db->table('clientes cl')
            ->select('s.nombre AS sucursal, COUNT(cl.id_cliente) AS total_clientes')
            ->join('sucursales s', 'cl.sucursal = s.id')
            ->groupBy('s.nombre')
            ->get()
            ->getResultArray();
    }

    // Clientes por Estatus
    public function getClientesPorEstatus()
    {
        return $this->db->table('clientes c')
            ->select('ce.nombre AS estatus, COUNT(c.id_cliente) AS total_clientes')
            ->join('clientes_estatus ce', 'c.estatus = ce.id_cliente_estatus')
            ->groupBy('ce.nombre')
            ->get()
            ->getResultArray();
    }

    // Comentarios por Caso
    public function getComentariosPorCaso()
    {
        return $this->db->table('comentarios_caso cc')
            ->select('c.proceso, COUNT(cc.id_comentario) AS total_comentarios')
            ->join('casos c', 'cc.id_caso = c.id_caso')
            ->groupBy('c.proceso')
            ->get()
            ->getResultArray();
    }

    // Encuestas de Satisfacción
    public function getEncuestasDeSatisfaccion()
    {
        return $this->db->table('encuesta_respuestas')
            ->select('calificacion_servicio, COUNT(id) AS total_respuestas')
            ->groupBy('calificacion_servicio')
            ->get()
            ->getResultArray();
    }

    // Ingresos por Tipo de Caso
    public function getIngresosPorTipoDeCaso()
    {
        return $this->db->table('casos c')
            ->select('ct.nombre AS tipo_caso, SUM(c.costo) AS ingresos_totales')
            ->join('casos_tipos ct', 'c.id_tipo_caso = ct.id_tipo_caso')
            ->where('c.pagado', 1)
            ->groupBy('ct.nombre')
            ->get()
            ->getResultArray();
    }

    // Ingresos por Sucursal
    public function getIngresosPorSucursal()
    {
        return $this->db->table('casos c')
            ->select('s.nombre AS sucursal, SUM(c.costo) AS ingresos_totales')
            ->join('usuarios u', 'c.id_usuario = u.id')
            ->join('abogados a', 'u.id = a.id_usuario')
            ->join('sucursales s', 'a.id_sucursal = s.id')
            ->where('c.pagado', 1)
            ->groupBy('s.nombre')
            ->get()
            ->getResultArray();
    }
}
