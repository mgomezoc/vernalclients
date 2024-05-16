<?php

namespace App\Controllers;

class Home extends BaseController
{
    function  index()
    {
        $data["title"] = "Inicio";
        $data['renderBody'] = $this->render("home/index", []);

        $data["styles"] = '<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">';
        $data['scripts'] = "<script src='https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js'></script>";

        $data['scripts'] .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js'></script>";
        $data['scripts'] .= "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        $data['scripts'] .= '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
        $data['scripts'] .= '<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>';
        $data['scripts'] .= "<script src='" . base_url("js/inicio.js") . "'></script>";


        return $this->render('shared/layout', $data);
    }

    function encuesta()
    {
        return $this->render("home/encuesta", []);
    }
}
