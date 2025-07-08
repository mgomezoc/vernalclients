<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('home/index', [
            'usuario' => session()->get('usuario'),
            'perfil' => session()->get('perfil')
        ]);
    }

    function encuesta()
    {
        return $this->render("home/encuesta", []);
    }
}
