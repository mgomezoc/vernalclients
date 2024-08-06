<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\FormularioAdmisionModel;
use App\Models\SucursalModel;
use App\Models\PagoConsultaModel;

class IntakeController extends BaseController
{
    function index($slug)
    {
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->where('slug', $slug)->first();

        if (!$cliente) {
            return "Cliente no encontrado";
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
        $pagoConsultaModel = new PagoConsultaModel();

        $idCliente = $this->request->getPost('id_cliente');
        $nuevoEstatus = 2;
        $datosAdmision = $this->request->getPost();

        $insertData = [
            'id_cliente' => $idCliente,
            'datos_admision' => json_encode($datosAdmision)
        ];

        // Guardar el formulario de admisión
        $formularioAdmisionModel->insertarFormularioAdmision($insertData);

        // Actualizar el estatus del cliente
        if (!$clienteModel->actualizarEstatusCliente($idCliente, $nuevoEstatus)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al actualizar el estatus del cliente.']);
        }

        // Crear registro en pagos_consultas
        $pagoData = [
            'id_cliente' => $idCliente,
            'id_usuario' => 1,
            'monto' => 1934.68,
            'forma_pago' => 'otro',
            'estatus_pago' => 'pendiente',
        ];
        $idPago = $pagoConsultaModel->agregarPago($pagoData);

        if (!$idPago) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al registrar el pago de la consulta.']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Se actualizó correctamente el estatus del cliente.', 'id_pago' => $idPago]);
    }

    public function actualizarPago($idPago)
    {
        // Obtener la referencia del request
        $referencia = $this->request->getPost('referencia');

        // Verificar que la referencia no esté vacía
        if (!$referencia) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Referencia no proporcionada.'
            ]);
        }

        // Instanciar el modelo de pagos
        $pagoConsultaModel = new PagoConsultaModel();

        // Actualizar el registro
        $data = [
            'referencia' => $referencia,
        ];

        $resultado = $pagoConsultaModel->update($idPago, $data);

        // Verificar si la actualización fue exitosa
        if ($resultado) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pago actualizado correctamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al actualizar el pago.'
            ]);
        }
    }
}
