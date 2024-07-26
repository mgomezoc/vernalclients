<?php

namespace App\Controllers;

use App\Models\SucursalModel;
use CodeIgniter\Controller;

class Sucursales extends BaseController
{
    protected $sucursalModel;

    public function __construct()
    {
        $this->sucursalModel = new SucursalModel();
    }

    public function index()
    {
        $sucursales = $this->sucursalModel->obtenerTodas();

        $data = [
            "sucursales" => $sucursales,
            "title" => "Sucursales",
            "renderBody" => view('sucursales/index', ["sucursales" => $sucursales])
        ];

        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_es.min.js'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/sucursales.js") . "'></script>";

        return $this->render('shared/layout', $data);
    }

    public function obtenerSucursales()
    {
        $sucursales = $this->sucursalModel->obtenerTodas();
        return $this->response->setJSON($sucursales);
    }

    public function agregarSucursal()
    {
        $data = $this->request->getPost();

        // Validaciones
        if (!$this->validate([
            'nombre' => 'required|min_length[3]',
            'direccion' => 'required|min_length[5]',
            'telefono' => 'permit_empty|numeric|exact_length[10]',
            'url_google_maps' => 'required|valid_url'
        ])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $this->validator->getErrors()
            ]);
        }

        $insertedId = $this->sucursalModel->agregarSucursal($data);

        if ($insertedId) {
            $data["success"] = true;
            $data["message"] = "Sucursal agregada exitosamente.";
            $data["id"] = $insertedId;
        } else {
            $data["success"] = false;
            $data["message"] = "No se pudo agregar la sucursal.";
        }

        return $this->response->setJSON($data);
    }

    public function editarSucursal()
    {
        $id = $this->request->getPost("id");
        $data = $this->request->getPost();

        // Validaciones
        if (!$this->validate([
            'nombre' => 'required|min_length[3]',
            'direccion' => 'required|min_length[5]',
            'telefono' => 'permit_empty|numeric|exact_length[10]',
            'url_google_maps' => 'required|valid_url'
        ])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $this->validator->getErrors()
            ]);
        }

        $updated = $this->sucursalModel->editarSucursal($id, $data);

        if ($updated) {
            $data["success"] = true;
            $data["message"] = "Sucursal actualizada exitosamente.";
        } else {
            $data["success"] = false;
            $data["message"] = "No se pudo actualizar la sucursal.";
        }

        return $this->response->setJSON($data);
    }

    public function eliminarSucursal()
    {
        $sucursalId = $this->request->getPost("id");
        $data = [];

        if ($sucursalId) {
            $deleted = $this->sucursalModel->eliminarSucursal($sucursalId);

            if ($deleted) {
                $data["success"] = true;
                $data["message"] = "Sucursal eliminada exitosamente.";
            } else {
                $data["success"] = false;
                $data["message"] = "No se pudo eliminar la sucursal.";
            }
        } else {
            $data["success"] = false;
            $data["message"] = "ID de sucursal no proporcionado.";
        }

        return $this->response->setJSON($data);
    }
}
