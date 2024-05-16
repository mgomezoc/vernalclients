<?php

namespace App\Controllers;

use App\Models\ClienteModel;

class EncuestaController extends BaseController
{
    public function index($slugCliente)
    {
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->where('slug', $slugCliente)->first();

        if (!$cliente) {
            return "Cliente no encontrado";
        }

        $data["title"] = "Encuesta para Cliente";
        $data["cliente"] = $cliente;

        return $this->render("home/encuesta", $data);
    }
}
