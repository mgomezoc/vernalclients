<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\IntakeModel;
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
        $formularioAdmisionModel = new IntakeModel();
        $pagoConsultaModel = new PagoConsultaModel();

        $idCliente = $this->request->getPost('id_cliente');
        $nuevoEstatus = 2;

        // Extraer los datos enviados por el formulario
        $datosAdmision = [
            'id_cliente' => $idCliente,
            'proceso' => $this->request->getPost('proceso'),
            'a_number' => $this->request->getPost('a_number'),
            'contacto' => $this->request->getPost('contacto'),
            'sucursal' => $this->request->getPost('sucursal'),
            'arrestado' => $this->request->getPost('arrestado'),
            'arrestado_fecha_cargo' => $this->request->getPost('arrestado_fecha_cargo'),
            'arrestado_explicacion' => $this->request->getPost('arrestado_explicacion'),
            'tipo_visa' => $this->request->getPost('tipo_visa'),
            'nationality' => $this->request->getPost('nationality'),
            'direccion_cp' => $this->request->getPost('direccion_cp'),
            'direccion_pais' => $this->request->getPost('direccion_pais'),
            'motivo_visita' => $this->request->getPost('motivo_visita'),
            'direccion_calle_numero' => $this->request->getPost('direccion_calle_numero'),
            'direccion_ciudad' => $this->request->getPost('direccion_ciudad'),
            'direccion_telefono' => $this->request->getPost('direccion_telefono'),
            'direccion_email' => $this->request->getPost('direccion_email'),
            'beneficiario_nombre' => $this->request->getPost('beneficiario_nombre'),
            'beneficiario_genero' => $this->request->getPost('beneficiario_genero'),
            'beneficiario_fecha_nacimiento' => $this->request->getPost('beneficiario_fecha_nacimiento'),
            'beneficiario_estado_civil' => $this->request->getPost('beneficiario_estado_civil'),
            'estatus_migratorio_actual' => $this->request->getPost('estatus_migratorio_actual'),
            'fecha_ultima_entrada' => $this->request->getPost('fecha_ultima_entrada'),
            'solicitud_migratoria' => $this->request->getPost('solicitud_migratoria'),
            'solicitud_migratoria_explicacion' => $this->request->getPost('solicitud_migratoria_explicacion'),
            'proceso_migracion' => $this->request->getPost('proceso_migracion'),
            'proceso_migracion_explicacion' => $this->request->getPost('proceso_migracion_explicacion'),
            'fuente_informacion' => $this->request->getPost('fuente_informacion'),
            'parientes' => json_encode($this->request->getPost('parientes')),  // campo JSON
            'familiar_servicio' => $this->request->getPost('familiar_servicio'),
            'familiar_servicio_parentesco' => $this->request->getPost('familiar_servicio_parentesco'),
            'victima_crimen' => $this->request->getPost('victima_crimen'),
            'victima_crimen_info' => $this->request->getPost('victima_crimen_info'),
            'cometido_crimen' => json_encode($this->request->getPost('cometido_crimen')),  // campo JSON
            'proceso_relacion' => $this->request->getPost('proceso_relacion'),
            'beneficiario_vive_ambos_padres' => $this->request->getPost('beneficiario_vive_ambos_padres'),
            'fecha_consulta' => date('Y-m-d H:i:s'),
        ];

        // Guardar los datos del formulario de admisión
        if (!$formularioAdmisionModel->insertarFormularioAdmision($datosAdmision)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar el formulario de admisión.']);
        }

        // Actualizar el estatus del cliente
        if (!$clienteModel->actualizarEstatusCliente($idCliente, $nuevoEstatus)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al actualizar el estatus del cliente.']);
        }

        // Registrar un pago pendiente
        $pagoData = [
            'id_cliente' => $idCliente,
            'id_usuario' => 1, // Por defecto
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
