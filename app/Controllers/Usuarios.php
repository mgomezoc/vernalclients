<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

use CodeIgniter\Controller;

class Usuarios extends Controller
{
    function  index()
    {
        // Cargar el modelo de usuarios
        $model = new UsuarioModel();

        // Obtener todos los usuarios desde la base de datos
        $data['usuarios'] = $model->findAll();

        $data['renderBody'] = view('usuarios/index', $data);

        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";

        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js'></script>";
        $data['scripts'] .= "<script src='" . base_url("js/usuarios.js") . "'></script>";

        echo view('shared/layout', $data);
    }
}
