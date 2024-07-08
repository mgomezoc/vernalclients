<?php

namespace App\Controllers;

use App\Models\ReportModel;
use CodeIgniter\API\ResponseTrait;

class ReportController extends BaseController
{
    use ResponseTrait;

    protected $reportModel;

    public function __construct()
    {
        $this->reportModel = new ReportModel();
    }

    public function casosPorEstatus()
    {
        $data = $this->reportModel->getCasosPorEstatus();
        return $this->respond($data);
    }

    public function casosPorTipo()
    {
        $data = $this->reportModel->getCasosPorTipo();
        return $this->respond($data);
    }

    public function casosPorAbogado()
    {
        $data = $this->reportModel->getCasosPorAbogado();
        return $this->respond($data);
    }

    public function casosPorSucursal()
    {
        $data = $this->reportModel->getCasosPorSucursal();
        return $this->respond($data);
    }

    public function casosPagadosVsNoPagados()
    {
        $data = $this->reportModel->getCasosPagadosVsNoPagados();
        return $this->respond($data);
    }

    public function clientesPorSucursal()
    {
        $data = $this->reportModel->getClientesPorSucursal();
        return $this->respond($data);
    }

    public function clientesPorEstatus()
    {
        $data = $this->reportModel->getClientesPorEstatus();
        return $this->respond($data);
    }

    public function comentariosPorCaso()
    {
        $data = $this->reportModel->getComentariosPorCaso();
        return $this->respond($data);
    }

    public function encuestasDeSatisfaccion()
    {
        $data = $this->reportModel->getEncuestasDeSatisfaccion();
        return $this->respond($data);
    }

    public function ingresosPorTipoDeCaso()
    {
        $data = $this->reportModel->getIngresosPorTipoDeCaso();
        return $this->respond($data);
    }

    public function ingresosPorSucursal()
    {
        $data = $this->reportModel->getIngresosPorSucursal();
        return $this->respond($data);
    }
}
