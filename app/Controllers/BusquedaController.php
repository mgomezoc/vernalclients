<?php

namespace App\Controllers;

use App\Models\CasoModel;
use App\Models\ClienteModel;
use CodeIgniter\Controller;

class BusquedaController extends Controller
{
    public function buscar()
    {
        $searchTerm = $this->request->getGet('term');

        $casoModel = new CasoModel();
        $clienteModel = new ClienteModel();

        $casos = $casoModel->buscarCasos($searchTerm);
        $clientes = $clienteModel->buscarClientes($searchTerm);

        return $this->response->setJSON(['casos' => $casos, 'clientes' => $clientes]);
    }
}
