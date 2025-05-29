<?php

namespace App\Controllers;

use App\Models\DashboardModel;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    protected $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }

    /** Vista principal del dashboard */
    public function index()
    {
        $data["title"] = "Dashboard";
        $data['renderBody'] = $this->render("dashboard/index", []);

        $data["styles"] = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">';
        $data["scripts"] = "
            <script src='https://cdn.jsdelivr.net/npm/flatpickr'></script>
            <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
            <script src='https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js'></script>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script src='" . base_url("js/dashboard.js") . "'></script>
        ";

        return $this->render('shared/layout', $data);
    }

    /** Valida y retorna fechas desde el request */
    private function getFechaParams()
    {
        $inicio = $this->request->getGet('inicio');
        $fin = $this->request->getGet('fin');

        helper('date');

        if ($inicio && !validateDate($inicio, 'Y-m-d')) $inicio = null;
        if ($fin && !validateDate($fin, 'Y-m-d')) $fin = null;

        return [$inicio, $fin];
    }

    // -- API endpoints para AJAX --

    public function apiClientesNuevos()
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getClientesNuevosPorPeriodo($inicio, $fin));
    }

    public function apiFormulariosPorSucursal()
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getFormulariosPorSucursalMes($inicio, $fin));
    }

    public function apiCasosPorTipo()
    {
        return $this->response->setJSON($this->dashboardModel->getCasosActivosVsCerradosPorTipo());
    }

    public function apiCasosConMasComentarios()
    {
        return $this->response->setJSON($this->dashboardModel->getCasosConMasComentarios());
    }

    public function apiCasosConMasDocumentos()
    {
        return $this->response->setJSON($this->dashboardModel->getCasosConMasDocumentos());
    }

    public function apiClientesSinCaso()
    {
        return $this->response->setJSON($this->dashboardModel->getClientesConDocumentosSinCaso());
    }

    public function apiIngresosPorFormaPago()
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getIngresosPorFormaPago($inicio, $fin));
    }

    public function apiCasosNoPagados()
    {
        return $this->response->setJSON($this->dashboardModel->getCasosNoPagados());
    }

    public function apiClientesAsiloPendiente()
    {
        return $this->response->setJSON($this->dashboardModel->getClientesAsiloPendiente());
    }

    public function apiClientesConArrestos()
    {
        return $this->response->setJSON($this->dashboardModel->getClientesConArrestos());
    }

    public function apiClientesPorVisaYEntrada()
    {
        return $this->response->setJSON($this->dashboardModel->getClientesPorVisaYEntrada());
    }

    public function apiTiempoPromedioConsultaCaso()
    {
        return $this->response->setJSON($this->dashboardModel->getTiempoPromedioConsultaCaso());
    }

    public function apiClientesConProcesoPrevio()
    {
        return $this->response->setJSON($this->dashboardModel->getClientesConProcesoPrevio());
    }

    public function apiClientesPorFuente()
    {
        return $this->response->setJSON($this->dashboardModel->getClientesPorFuente());
    }

    public function apiPromedioSatisfaccion()
    {
        return $this->response->setJSON($this->dashboardModel->getPromedioSatisfaccion());
    }

    public function apiRespuestasNegativas()
    {
        return $this->response->setJSON($this->dashboardModel->getRespuestasNegativas());
    }

    public function apiCasosCorteProxima()
    {
        return $this->response->setJSON($this->dashboardModel->getCasosConFechaCorteProxima());
    }

    public function apiCasosLimiteVencido()
    {
        return $this->response->setJSON($this->dashboardModel->getCasosConLimiteVencido());
    }

    public function apiCasosPorAbogado()
    {
        return $this->response->setJSON($this->dashboardModel->getCasosPorAbogado());
    }
}
