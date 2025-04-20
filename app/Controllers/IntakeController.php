<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\IntakeModel;
use App\Models\SucursalModel;
use App\Models\PagoConsultaModel;

class IntakeController extends BaseController
{
    public function index($slug)
    {
        $clienteModel = new ClienteModel();
        $intakeModel = new IntakeModel(); // Añadido para verificar si ya existe un formulario

        // Buscar el cliente por el slug
        $cliente = $clienteModel->where('slug', $slug)->first();

        if (!$cliente) {
            return "Cliente no encontrado";
        }

        // Verificar si el cliente ya tiene un formulario de admisión completado
        $formularioExistente = $intakeModel->where('id_cliente', $cliente['id_cliente'])->first();

        if ($formularioExistente) {
            // Si el formulario ya existe, mostramos el mensaje con los datos completos
            return view('mensaje_formulario_existente', [
                'cliente' => $cliente,
                'formularioExistente' => $formularioExistente // Pasa el formulario a la vista
            ]);
        }

        // Obtener la información de la sucursal
        $sucursalModel = new SucursalModel();
        $sucursal = $sucursalModel->find($cliente['sucursal']);

        // Crear un objeto DateTime para la fecha actual en la zona horaria de Dallas
        $fechaActual = new \DateTime('now', new \DateTimeZone('America/Chicago'));

        // Formato mes-día-año
        $fechaSimple = $fechaActual->format('m-d-Y');

        // Crear el formateador de fechas con `IntlDateFormatter`
        $formatter = new \IntlDateFormatter(
            'es_ES',                     // Locale en español
            \IntlDateFormatter::FULL,     // Formato completo para la fecha
            \IntlDateFormatter::NONE,     // No necesitamos formato para la hora
            'America/Chicago',            // Zona horaria
            \IntlDateFormatter::GREGORIAN // Calendario
        );

        // Formatear la fecha descriptiva
        $fechaTitle = ucfirst($formatter->format($fechaActual)); // Primera letra en mayúsculas

        // Preparar los datos para la vista del formulario de admisión
        $data = [
            "title" => "Inicio",
            "cliente" => $cliente,
            "sucursal" => $sucursal,
            "fechaSimple" => $fechaSimple,
            "fechaTitle" => $fechaTitle
        ];

        return view("intake", $data);
    }

    public function indexEng($slug)
    {
        $clienteModel = new ClienteModel();
        $intakeModel = new IntakeModel();

        $cliente = $clienteModel->where('slug', $slug)->first();

        if (!$cliente) {
            return "Client not found.";
        }

        $formularioExistente = $intakeModel->where('id_cliente', $cliente['id_cliente'])->first();

        if ($formularioExistente) {
            return view('mensaje_formulario_existente_eng', [
                'cliente' => $cliente,
                'formularioExistente' => $formularioExistente
            ]);
        }

        $sucursalModel = new SucursalModel();
        $sucursal = $sucursalModel->find($cliente['sucursal']);

        $fechaActual = new \DateTime('now', new \DateTimeZone('America/Chicago'));
        $fechaSimple = $fechaActual->format('m-d-Y');

        $formatter = new \IntlDateFormatter('en_US', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE, 'America/Chicago', \IntlDateFormatter::GREGORIAN);
        $fechaTitle = ucfirst($formatter->format($fechaActual));

        $data = [
            "title" => "Intake Form",
            "cliente" => $cliente,
            "sucursal" => $sucursal,
            "fechaSimple" => $fechaSimple,
            "fechaTitle" => $fechaTitle
        ];

        return view("intake_eng", $data);
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
            'posee_a_number' => $this->request->getPost('posee_a_number'),
            'a_number' => $this->request->getPost('a_number'),
            'contacto' => $this->request->getPost('contacto'),
            'horario_contacto' => $this->request->getPost('horario_contacto'),
            'sucursal' => $this->request->getPost('sucursal'),
            'sucursal_nombre' => $this->request->getPost('sucursal_nombre'),
            'es_primera_consulta' => $this->request->getPost('es_primera_consulta'),
            'fecha_ultima_consulta' => $this->request->getPost('fecha_ultima_consulta') ?: null,  // Corrección aquí
            'arrestado' => $this->request->getPost('arrestado'),
            'arrestado_fecha_cargo' => $this->request->getPost('arrestado_fecha_cargo'),
            'arrestado_explicacion' => $this->request->getPost('arrestado_explicacion'),
            'como_entro_eeuu' => $this->request->getPost('como_entro_eeuu'),
            'tipo_visa' => $this->request->getPost('tipo_visa'),
            'nationality' => $this->request->getPost('nationality'),
            'radio-nacionalidad' => $this->request->getPost('radio-nacionalidad'),
            'segunda_nacionalidad' => $this->request->getPost('segunda_nacionalidad'),
            'direccion_cp' => $this->request->getPost('direccion_cp'),
            'direccion_pais' => $this->request->getPost('direccion_pais'),
            'motivo_visita' => $this->request->getPost('motivo_visita'),
            'direccion_calle_numero' => $this->request->getPost('direccion_calle_numero'),
            'direccion_ciudad' => $this->request->getPost('direccion_ciudad'),
            'direccion_estado' => $this->request->getPost('direccion_estado'),
            'direccion_telefono' => $this->request->getPost('direccion_telefono'),
            'direccion_email' => $this->request->getPost('direccion_email'),
            'beneficiario_nombre' => $this->request->getPost('beneficiario_nombre'),
            'beneficiario_ciudad' => $this->request->getPost('beneficiario_ciudad'),
            'beneficiario_estado' => $this->request->getPost('beneficiario_estado'),
            'beneficiario_pais' => $this->request->getPost('beneficiario_pais'),
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
            'parientes' => $this->request->getPost('parientes'),
            'familiar_servicio' => $this->request->getPost('familiar_servicio'),
            'familiar_servicio_parentesco' => $this->request->getPost('familiar_servicio_parentesco'),
            'victima_crimen' => $this->request->getPost('victima_crimen'),
            'victima_crimen_info' => $this->request->getPost('victima_crimen_info'),
            'cometido_crimen' => $this->request->getPost('cometido_crimen'),
            'proceso_relacion' => $this->request->getPost('proceso_relacion'),
            'beneficiario_vive_ambos_padres' => $this->request->getPost('beneficiario_vive_ambos_padres'),
            'peticionario_nombre' => $this->request->getPost('peticionario_nombre'),
            'peticionario_telefono' => $this->request->getPost('peticionario_telefono'),
            'peticionario_relacion' => $this->request->getPost('peticionario_relacion'),
            'peticionario_direccion' => $this->request->getPost('peticionario_direccion'),
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

    public function actualizar()
    {
        $intakeModel = new IntakeModel();
        $clienteModel = new ClienteModel();

        // Obtener el ID del cliente
        $idCliente = $this->request->getPost('id_cliente');

        // Verificar si el cliente existe
        if (!$clienteModel->find($idCliente)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cliente no encontrado.'
            ]);
        }

        // Filtrar solo los campos permitidos (los que se definieron en el modelo IntakeModel)
        $allowedFields = $intakeModel->allowedFields;
        $datosActualizados = $this->request->getPost(array_intersect(array_keys($this->request->getPost()), $allowedFields));

        // Verificar si la fecha_ultima_consulta viene vacía y asignar null si es necesario
        if (isset($datosActualizados['fecha_ultima_consulta']) && empty($datosActualizados['fecha_ultima_consulta'])) {
            $datosActualizados['fecha_ultima_consulta'] = null;
        }

        // Verificar si hay datos para actualizar
        if (empty($datosActualizados)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se proporcionaron datos para actualizar.'
            ]);
        }

        // Intentar actualizar los datos en la base de datos
        $actualizado = $intakeModel->actualizarFormularioPorCliente($idCliente, $datosActualizados);

        if ($actualizado) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Formulario de admisión actualizado correctamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al actualizar el formulario de admisión.'
            ]);
        }
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
