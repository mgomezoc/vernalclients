<?php

namespace App\Controllers;

use App\Models\CasoModel;
use App\Models\ComentarioCasoModel;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class CasosController extends Controller
{
    use ResponseTrait;

    public function __construct()
    {
        helper('auditoria'); // Cargar el helper de auditoría
    }

    public function actualizarCaseID()
    {
        $request = \Config\Services::request();
        $casoModel = new CasoModel();

        // Obtener los datos del request
        $idCaso = $request->getPost('id_caso');
        $caseID = $request->getPost('caseID');

        // Validación básica
        if (!$idCaso || !$caseID) {
            return $this->failValidationErrors('Es necesario proporcionar el id_caso y el caseID.');
        }

        // Intentar actualizar el caseID
        if ($casoModel->actualizarCaseID($idCaso, $caseID)) {
            // Registrar acción de actualización de CaseID
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'update_caseID', "Actualizó el CaseID del caso con ID: $idCaso a $caseID.");
            }

            return $this->respondUpdated(['message' => 'CaseID actualizado correctamente.']);
        } else {
            return $this->failServerError('No se pudo actualizar el CaseID.');
        }
    }

    public function actualizarEstatus()
    {
        $casoModel = new CasoModel();

        // Obtén los datos del formulario o solicitud
        $idCaso = $this->request->getPost('id_caso');
        $nuevoEstatus = $this->request->getPost('nuevo_estatus');

        // Verifica si se proporcionaron todos los datos necesarios
        if (!$idCaso || !$nuevoEstatus) {
            // Si falta algún dato, devuelve un mensaje de error
            return $this->response->setJSON(['success' => false, 'message' => 'Faltan datos para actualizar el estatus.']);
        }

        // Intenta actualizar el estatus del caso
        if ($casoModel->actualizarEstatusCaso($idCaso, $nuevoEstatus)) {
            // Registrar acción de actualización de estatus
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'update_case_status', "Actualizó el estatus del caso con ID: $idCaso a $nuevoEstatus.");
            }

            // Si la actualización se realizó correctamente, devuelve un mensaje de éxito
            return $this->response->setJSON(['success' => true, 'message' => 'Estatus actualizado correctamente.']);
        } else {
            // Si ocurrió un error al actualizar, devuelve un mensaje de error
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo actualizar el estatus del caso.']);
        }
    }

    public function obtenerComentarios()
    {
        $idCaso = $this->request->getPost('id_caso');

        $comentariosModel = new ComentarioCasoModel();
        $comentarios = $comentariosModel->obtenerComentariosPorCaso($idCaso);

        // Registrar acción de visualización de comentarios
        $usuario = session()->get('usuario');
        if ($usuario) {
            registrarAccion($usuario['id'], 'view_case_comments', "Visualizó los comentarios del caso con ID: $idCaso.");
        }

        return $this->response->setJSON(['success' => true, 'data' => $comentarios]);
    }

    public function agregarComentario()
    {
        $comentariosModel = new ComentarioCasoModel();
        $id_caso = $this->request->getPost('id_caso');
        $id_usuario = $this->request->getPost('id_usuario');
        $comentario = $this->request->getPost('comentario');

        $data = [
            'id_caso' => $id_caso,
            'id_usuario' => $id_usuario,
            'comentario' => $comentario,
            'fecha_creacion' => date('Y-m-d H:i:s'),
        ];

        if ($comentariosModel->agregarComentario($data)) {
            // Registrar acción de agregar comentario
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'add_case_comment', "Agregó un comentario al caso con ID: $id_caso.");
            }

            $response['success'] = true;
            $response['message'] = 'Se creó el comentario correctamente.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Ocurrió un error al crear el comentario.';
        }

        return $this->response->setJSON($response);
    }

    public function editarCaso()
    {
        $casoModel = new CasoModel();
        $idCaso = $this->request->getPost('id_caso');

        // Obtener todos los datos de POST excepto 'id_caso'
        $postData = $this->request->getPost();
        unset($postData['id_caso']);  // Asegúrate de no incluir el id_caso en los datos a actualizar

        // Incluir la fecha de actualización
        $postData['fecha_actualizacion'] = date('Y-m-d H:i:s');

        if ($casoModel->editarCaso($idCaso, $postData)) {
            // Registrar acción de edición de caso
            $usuario = session()->get('usuario');
            if ($usuario) {
                registrarAccion($usuario['id'], 'edit_case', "Editó el caso con ID: $idCaso.");
            }

            $response['success'] = true;
            $response['message'] = 'Se actualizó el caso correctamente.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Ocurrió un error al actualizar el caso.';
        }

        return $this->response->setJSON($response);
    }
}
