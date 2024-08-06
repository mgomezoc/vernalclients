<?php

namespace App\Controllers;

use App\Models\PagoConsultaModel;
use App\Models\ClienteModel;
use App\Models\UsuarioModel;

class PagosConsultasController extends BaseController
{
    public function index()
    {
        $data["title"] = "Pagos de Consultas";

        $clienteModel = new ClienteModel();
        $usuarioModel = new UsuarioModel();
        $data['clientes'] = $clienteModel->findAll();
        $data['usuarios'] = $usuarioModel->findAll();

        $data['renderBody'] = $this->render("pagos/pagos_consultas", $data);

        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">';
        $data["styles"] .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">';

        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdn.jsdelivr.net/npm/flatpickr'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/pagos_consultas.js") . "'></script>";

        return $this->render('shared/layout', $data);
    }

    public function obtenerPagosConsultas()
    {
        $pagoConsultaModel = new PagoConsultaModel();
        $postData = json_decode($this->request->getBody(), true);

        $limit = $postData['limit'] ?? 10;
        $offset = $postData['offset'] ?? 0;
        $filtros = [
            'cliente' => $postData['cliente'] ?? '',
            'usuario' => $postData['usuario'] ?? '',
            'periodo' => $postData['periodo'] ?? '',
            'forma_pago' => $postData['forma_pago'] ?? '',
            'estatus_pago' => $postData['estatus_pago'] ?? '',
        ];

        $result = $pagoConsultaModel->obtenerPagos($limit, $offset, $filtros);
        $total = $pagoConsultaModel->contarPagos($filtros);

        // Formatear respuesta para paginación de Bootstrap Table
        $response = [
            'total' => $total,
            'rows' => $result,
        ];

        return $this->response->setJSON($response);
    }

    public function marcar_pagado()
    {
        $pagoConsultaModel = new PagoConsultaModel();

        $idPago = $this->request->getPost('id_pago');
        $formaPago = $this->request->getPost('forma_pago');
        $nota = $this->request->getPost('nota');

        // Obtener el pago actual
        $pago = $pagoConsultaModel->find($idPago);

        if (!$pago || $pago['estatus_pago'] === 'completado') {
            return $this->response->setJSON(['success' => false, 'message' => 'Este pago ya está completado o no existe.']);
        }

        $data = [
            'forma_pago' => $formaPago,
            'estatus_pago' => 'completado',
            'notas' => $nota
        ];

        $result = $pagoConsultaModel->update($idPago, $data);

        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'Pago marcado como completado.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo marcar el pago.']);
        }
    }
}
