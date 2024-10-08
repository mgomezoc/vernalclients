<?php

namespace App\Controllers;

use App\Models\FormularioAdmisionModel;
use App\Models\IntakeModel;
use App\Models\ClienteModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MigracionController extends BaseController
{
    public function migrarFormularios()
    {
        $formularioAdmisionModel = new FormularioAdmisionModel();
        $intakeModel = new IntakeModel();
        $clienteModel = new ClienteModel();

        // Mapeo de IDs de sucursal a nombres de sucursales
        $sucursalesMap = [
            "0" => "The Law Office of Vernal Farnum Mejia (Fort Worth)",
            "1" => "The Law Office of Vernal Farnum Mejia (Dallas)",
            "2" => "THE LAW OFFICE OF VERNAL FARNUM MEJIA (Houston)",
            "3" => "The Law Office of Vernal Farnum Mejia (Austin)",
            "4" => "The Law Firm of Vernal Farnum Mejia (Digital)"
        ];

        // Obtener todos los registros de la tabla formulario_admision
        $formularios = $formularioAdmisionModel->findAll();

        // Contadores y almacenamiento de errores
        $successfulInserts = 0;
        $failedInserts = 0;
        $errors = [];

        foreach ($formularios as $formulario) {
            $datosAdmision = json_decode($formulario['datos_admision'], true);

            // Validar que datos_admision sea un array y tenga información
            if (!is_array($datosAdmision) || empty($datosAdmision)) {
                $errors[] = "El registro con ID {$formulario['id']} contiene datos_admision inválidos.";
                $failedInserts++;
                continue;
            }

            // Validar la existencia de id_cliente en la tabla clientes
            $idCliente = $formulario['id_cliente'];
            $cliente = $clienteModel->find($idCliente);
            if (!$cliente) {
                $errors[] = "El cliente con ID {$idCliente} no existe en la tabla clientes.";
                $failedInserts++;
                continue;
            }

            // Determinar el valor de "como_entro_eeuu" basado en el valor que ya exista o "tipo_visa" si es null
            $comoEntroEEUU = $datosAdmision['como_entro_eeuu'] ?? null;
            if (empty($comoEntroEEUU)) {
                $tipoVisa = $datosAdmision['tipo_visa'] ?? null;
                $comoEntroEEUU = $tipoVisa ? 'Con Visa' : 'Sin Visa';
            }

            // Mapeo y validación de datos
            $sucursalId = $datosAdmision['sucursal'] ?? null;
            $sucursalNombre = $sucursalId !== null && isset($sucursalesMap[$sucursalId])
                ? $sucursalesMap[$sucursalId]
                : null;

            // Validar que 'nationality' no esté vacío y asignar un valor predeterminado si es necesario
            $nationality = $datosAdmision['nationality'] ?? null;
            if (empty($nationality)) {
                $errors[] = "El registro con ID {$formulario['id']} no tiene una nacionalidad válida.";
                $failedInserts++;
                continue;
            }

            // Asignar el estado civil por defecto si no está presente
            $estadoCivil = $datosAdmision['beneficiario_estado_civil'] ?? 'Single';

            // Determinar el valor de "fecha_ultima_consulta" limpiando si viene como una cadena vacía
            $fechaUltimaConsulta = !empty($datosAdmision['fecha_ultima_consulta']) ? $datosAdmision['fecha_ultima_consulta'] : null;

            // Determinar el valor de "es_primera_consulta" basado en "fecha_ultima_consulta"
            $esPrimeraConsulta = $fechaUltimaConsulta ? 'No' : 'Si';

            $intakeData = [
                'id_cliente' => $idCliente,
                'fecha_consulta' => $formulario['fecha_consulta'],
                'proceso' => $datosAdmision['proceso'] ?? null,
                'posee_a_number' => $datosAdmision['posee_a_number'] ?? null,
                'a_number' => $datosAdmision['a_number'] ?? null,
                'contacto' => $datosAdmision['contacto'] ?? null,
                'horario_contacto' => $datosAdmision['horario_contacto'] ?? null,
                'sucursal' => $sucursalId,
                'sucursal_nombre' => $sucursalNombre,
                'es_primera_consulta' => $esPrimeraConsulta,
                'fecha_ultima_consulta' => $fechaUltimaConsulta,
                'arrestado' => $datosAdmision['arrestado'] ?? 'No',
                'como_entro_eeuu' => $comoEntroEEUU,
                'tipo_visa' => $tipoVisa,
                'nationality' => $nationality,
                'radio-nacionalidad' => $datosAdmision['radio-nacionalidad'] ?? 'No',
                'segunda_nacionalidad' => $datosAdmision['segunda_nacionalidad'] ?? null,
                'direccion_cp' => $datosAdmision['direccion_cp'] ?? null,
                'direccion_pais' => $datosAdmision['direccion_pais'] ?? null,
                'direccion_ciudad' => $datosAdmision['direccion_cuidad'] ?? null,
                'direccion_estado' => $datosAdmision['beneficiario_estado'] ?? null,
                'direccion_calle_numero' => $datosAdmision['direccion_calle_numero'] ?? null,
                'direccion_telefono' => $datosAdmision['direccion_telefono'] ?? null,
                'direccion_email' => $datosAdmision['direccion_email'] ?? null,
                'beneficiario_nombre' => $datosAdmision['beneficiario_nombre'] ?? null,
                'beneficiario_ciudad' => $datosAdmision['beneficiario_ciudad'] ?? null,
                'beneficiario_estado' => $datosAdmision['beneficiario_estado'] ?? null,
                'beneficiario_pais' => $datosAdmision['beneficiario_pais'] ?? null,
                'beneficiario_genero' => $datosAdmision['beneficiario_genero'] ?? null,
                'beneficiario_fecha_nacimiento' => $datosAdmision['beneficiario_fecha_nacimiento'] ?? null,
                'beneficiario_estado_civil' => $estadoCivil,
                'estatus_migratorio_actual' => $datosAdmision['estatus_migratorio_actual'] ?? null,
                'fecha_ultima_entrada' => $datosAdmision['fecha_ultima_entrada'] ?? null,
                'solicitud_migratoria' => $datosAdmision['solicitud_migratoria'] ?? 'No',
                'solicitud_migratoria_explicacion' => $datosAdmision['solicitud_migratoria_explicacion'] ?? null,
                'proceso_migracion' => $datosAdmision['proceso_migracion'] ?? 'No',
                'proceso_migracion_explicacion' => $datosAdmision['proceso_migracion_explicacion'] ?? null,
                'fuente_informacion' => $datosAdmision['fuente_informacion'] ?? '',
                'parientes' => isset($datosAdmision['parientes'])
                    ? (is_array($datosAdmision['parientes']) ? implode(',', $datosAdmision['parientes']) : $datosAdmision['parientes'])
                    : null,
                'familiar_servicio' => $datosAdmision['familiar_servicio'] ?? 'No',
                'familiar_servicio_parentesco' => $datosAdmision['familiar_servicio_parentesco'] ?? null,
                'victima_crimen' => $datosAdmision['victima_crimen'] ?? 'No',
                'victima_crimen_info' => $datosAdmision['victima_crimen_info'] ?? null,
                'cometido_crimen' => isset($datosAdmision['cometido_crimen'])
                    ? (is_array($datosAdmision['cometido_crimen']) ? implode(',', $datosAdmision['cometido_crimen']) : $datosAdmision['cometido_crimen'])
                    : null,
                'arrestado_fecha_cargo' => $datosAdmision['arrestado_fecha_cargo'] ?? null,
                'arrestado_explicacion' => $datosAdmision['arrestado_explicacion'] ?? null,
                'peticionario_nombre' => $datosAdmision['peticionario_nombre'] ?? null,
                'peticionario_telefono' => $datosAdmision['peticionario_telefono'] ?? null,
                'peticionario_relacion' => $datosAdmision['peticionario_relacion'] ?? null,
                'peticionario_direccion' => $datosAdmision['peticionario_direccion'] ?? null,
                'motivo_visita' => $datosAdmision['motivo_visita'] ?? null,
            ];

            // Validar que los campos obligatorios no estén vacíos
            if (empty($intakeData['id_cliente']) || empty($intakeData['proceso']) || empty($intakeData['contacto']) || empty($intakeData['sucursal_nombre'])) {
                $errors[] = "El registro con ID {$formulario['id']} tiene campos obligatorios faltantes.";
                $failedInserts++;
                continue;
            }

            // Intentar insertar en la tabla intake
            try {
                if ($intakeModel->insert($intakeData)) {
                    $successfulInserts++;
                } else {
                    $errors[] = "Error al insertar el registro con ID {$formulario['id']}: " . implode(', ', $intakeModel->errors());
                    $failedInserts++;
                }
            } catch (\Exception $e) {
                $errors[] = "Error de base de datos al insertar el registro con ID {$formulario['id']}: " . $e->getMessage();
                $failedInserts++;
            }
        }

        // Mostrar el resumen de la migración
        echo "<h3>Resumen de la migración</h3>";
        echo "<p>Registros migrados exitosamente: $successfulInserts</p>";
        echo "<p>Registros fallidos: $failedInserts</p>";

        if (!empty($errors)) {
            echo "<h4>Detalles de los errores:</h4>";
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
        }
    }
}
