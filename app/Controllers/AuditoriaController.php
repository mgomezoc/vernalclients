<?php

namespace App\Controllers;

use App\Models\AuditoriaModel;
use App\Models\UsuarioModel;

class AuditoriaController extends BaseController
{
    public function index()
    {
        $data["title"] = "Auditoría";

        $usuarioModel = new UsuarioModel();
        $data['usuarios'] = $usuarioModel->findAll();

        $data['renderBody'] = $this->render("auditoria/auditoria", $data);

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
        $data['scripts'] .= "<script src='" . base_url("js/auditoria.js") . "'></script>";

        return $this->render('shared/layout', $data);
    }

    public function obtenerAuditoria()
    {
        $auditoriaModel = new AuditoriaModel();
        $postData = json_decode($this->request->getBody(), true);

        $limit = $postData['limit'] ?? 10;
        $offset = $postData['offset'] ?? 0;
        $filtros = [
            'usuario' => $postData['usuario'] ?? '',
            'accion'  => $postData['accion'] ?? '',
            'periodo' => $postData['periodo'] ?? ''
        ];

        $result = $auditoriaModel->obtenerAuditoriaPaginada($limit, $offset, $filtros);

        return $this->response->setJSON($result);
    }
}
