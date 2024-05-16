<?php

namespace App\Controllers;

use App\Models\EncuestaRespuestaModel;
use CodeIgniter\Controller;

class EncuestaRespuestaController extends Controller
{
    public function guardarRespuestaEncuesta()
    {
        $model = new EncuestaRespuestaModel();

        $data = [
            'slug_cliente'                => $this->request->getPost('slug_cliente'),
            'probabilidad_recomendacion'  => $this->request->getPost('probabilidad_recomendacion'),
            'calificacion_servicio'       => $this->request->getPost('calificacion_servicio'),
            'tiempo_respuesta_adeuado'    => $this->request->getPost('tiempo_respuesta_adeuado'),
            'profesionalismo_actitud'     => $this->request->getPost('profesionalismo_actitud'),
            'precio_valor_correspondencia' => $this->request->getPost('precio_valor_correspondencia'),
            'comentarios_sugerencias'     => $this->request->getPost('comentarios_sugerencias')
        ];

        if ($model->insert($data)) {
            $response = [
                'success' => true,
                'message' => 'Respuesta de encuesta guardada correctamente.'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Ocurrió un error al guardar la respuesta de la encuesta.'
            ];
        }

        return $this->response->setJSON($response);
    }

    public function obtenerRegistros()
    {
        $model = new EncuestaRespuestaModel();

        $registros = $model->findAll();

        return $this->response->setJSON($registros);
    }

    public function obtenerTablaEncuestas()
    {
        $model = new EncuestaRespuestaModel();

        $registros = $model->obtenerTablaEncuestas();

        return $this->response->setJSON($registros);
    }
}
