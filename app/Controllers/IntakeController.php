<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\FormularioAdmisionModel;
use App\Models\SucursalModel;

class IntakeController extends BaseController
{
    function  index($slug)
    {
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->where('slug', $slug)->first();

        if (!$cliente) {
            return  "Cliente no encontrado";
        }

        $sucursalModel = new SucursalModel();
        $sucursal = $sucursalModel->find($cliente['sucursal']);

        $fechaActual = (new \DateTime())->format('d-m-Y');

        $data["title"] = "Inicio";
        $data["cliente"] = $cliente;
        $data["sucursal"] = $sucursal;
        $data["fechaActual"] = $fechaActual;

        return view("intake", $data);
    }

    function guardar()
    {
        $clienteModel = new ClienteModel();
        $formularioAdmisionModel = new FormularioAdmisionModel();

        $idCliente = $this->request->getPost('id_cliente');
        $nuevoEstatus = 2;
        $datosAdmision = $this->request->getPost();

        $insertData = [
            'id_cliente' => $idCliente,
            'datos_admision' => json_encode($datosAdmision)  // Convertir a JSON si la columna es de tipo JSON
        ];

        $formularioAdmisionModel->insertarFormularioAdmision($insertData);

        if ($clienteModel->actualizarEstatusCliente($idCliente, $nuevoEstatus)) {
            $response['success'] = true;
            $response['message'] = 'Se actualizó correctamente el estatus del cliente.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Ocurrió un error al actualizar el estatus del cliente.';
        }

        return $this->response->setJSON($response);
    }
}
