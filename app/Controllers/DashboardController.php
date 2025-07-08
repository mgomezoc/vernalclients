<?php

namespace App\Controllers;

use App\Models\DashboardModel;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    protected DashboardModel $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Dashboard',
            'renderBody' => $this->render('dashboard/index', []),
            'styles' => '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">',
            'scripts' => "
                <script src='https://cdn.jsdelivr.net/npm/flatpickr'></script>
                <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
                <script src='https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels'></script>
                <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js'></script>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script src='" . base_url('js/dashboard.js') . "'></script>
            "
        ];

        return view('dashboard/index', []);
    }

    private function isValidDate(?string $date, string $format = 'Y-m-d'): bool
    {
        if (!$date) return false;
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    private function getFechaParams(): array
    {
        $inicio = $this->request->getGet('inicio');
        $fin = $this->request->getGet('fin');

        if (!$this->isValidDate($inicio)) $inicio = null;
        if (!$this->isValidDate($fin)) $fin = null;

        return [$inicio, $fin];
    }

    // === API ===

    public function apiClientesNuevos(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getClientesNuevosPorPeriodo($inicio, $fin));
    }

    public function apiFormulariosPorSucursal(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getFormulariosPorSucursalMes($inicio, $fin));
    }

    public function apiCasosPorTipo(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getCasosActivosVsCerradosPorTipo($inicio, $fin));
    }

    public function apiCasosConMasComentarios(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getCasosConMasComentarios($inicio, $fin));
    }

    public function apiCasosConMasDocumentos(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getCasosConMasDocumentos($inicio, $fin));
    }

    public function apiClientesSinCaso(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getClientesConDocumentosSinCaso($inicio, $fin));
    }

    public function apiIngresosPorFormaPago(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getIngresosPorFormaPago($inicio, $fin));
    }

    public function apiCasosNoPagados(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getCasosNoPagados($inicio, $fin));
    }

    public function apiClientesAsiloPendiente(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getClientesAsiloPendiente($inicio, $fin));
    }

    public function apiClientesConArrestos(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getClientesConArrestos($inicio, $fin));
    }

    public function apiClientesPorVisaYEntrada(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getClientesPorVisaYEntrada($inicio, $fin));
    }

    public function apiTiempoPromedioConsultaCaso(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getTiempoPromedioConsultaCaso($inicio, $fin));
    }

    public function apiClientesConProcesoPrevio(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getClientesConProcesoPrevio($inicio, $fin));
    }

    public function apiClientesPorFuente(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getClientesPorFuente($inicio, $fin));
    }

    public function apiPromedioSatisfaccion(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getPromedioSatisfaccion($inicio, $fin));
    }

    public function apiRespuestasNegativas(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getRespuestasNegativas($inicio, $fin));
    }

    public function apiCasosCorteProxima(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getCasosConFechaCorteProxima($inicio, $fin));
    }

    public function apiCasosLimiteVencido(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getCasosConLimiteVencido($inicio, $fin));
    }

    public function apiCasosPorAbogado(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getCasosPorAbogado($inicio, $fin));
    }

    public function apiIngresosMensuales(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getIngresosMensualesComparativos($inicio, $fin));
    }

    public function apiConversionFuentes(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getFuentesClientesConConversion($inicio, $fin));
    }

    public function apiPromedioTiempoCasoAbierto(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getPromedioTiempoCasoAbierto($inicio, $fin));
    }

    public function apiCasosSinActualizar(): ResponseInterface
    {
        [$inicio, $fin] = $this->getFechaParams();
        return $this->response->setJSON($this->dashboardModel->getCasosSinActualizar($inicio, $fin));
    }
}
