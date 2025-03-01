<?php

namespace App\Commands;

use App\Models\CasoModel;
use App\Models\UsuarioModel;
use App\Models\ClienteModel;
use App\Services\EmailService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class RevisarFechasCasos extends BaseCommand
{
    protected $group       = 'Tareas';
    protected $name        = 'revisar:fechas-casos';
    protected $description = 'Revisa las fechas límite y corte de los casos y envía notificaciones si están próximas a vencer.';

    public function run(array $params)
    {
        $casoModel = new CasoModel();
        $emailService = new EmailService();

        // Fechas próximas
        $fechasProximas = [
            date('Y-m-d', strtotime('+15 days')),
            date('Y-m-d', strtotime('+7 days')),
            date('Y-m-d', strtotime('+3 days'))
        ];

        // Buscar casos con fechas próximas
        $casos = $casoModel->whereIn('fecha_corte', $fechasProximas)
            ->orWhereIn('limite_tiempo', $fechasProximas)
            ->findAll();

        if (empty($casos)) {
            CLI::write('No hay casos próximos a vencer.', 'green');
            return;
        }

        // Enviar notificaciones
        foreach ($casos as $caso) {
            $this->enviarNotificacion($caso, $emailService);
            CLI::write("Notificación enviada para el caso ID: {$caso['id_caso']}", 'yellow');
        }

        CLI::write('Proceso completado.', 'green');
    }

    private function enviarNotificacion($caso, EmailService $emailService)
    {
        $usuarioModel = new UsuarioModel();
        $clienteModel = new ClienteModel();

        // Obtener el usuario asignado al caso
        $usuario = $usuarioModel->find($caso['id_usuario']);
        $to = $usuario ? $usuario['correo_electronico'] : null;

        // Obtener información del cliente asociado al caso
        $cliente = $clienteModel->find($caso['id_cliente']);

        if (!$to || !$cliente) {
            CLI::write("No se encontró información del usuario o cliente para el caso ID: {$caso['id_caso']}", 'red');
            return;
        }

        // Crear el template HTML del correo
        $subject = 'Recordatorio: Caso próximo a vencer';
        $message = "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Notificación de Caso Próximo a Vencer</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f9; }
                    .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
                    .header { background-color: #007BFF; color: #ffffff; text-align: center; padding: 20px; font-size: 20px; }
                    .content { padding: 20px; }
                    .content p { margin: 0 0 15px; line-height: 1.6; color: #333; }
                    .content .highlight { color: #007BFF; font-weight: bold; }
                    .cta-button { display: block; text-align: center; background-color: #28a745; color: #ffffff; padding: 15px; margin: 20px 0; text-decoration: none; border-radius: 5px; font-size: 16px; }
                    .cta-button:hover { background-color: #218838; }
                    .footer { background-color: #f8f9fa; text-align: center; padding: 10px; font-size: 14px; color: #6c757d; }
                    @media only screen and (max-width: 600px) {
                        .content { padding: 15px; }
                        .cta-button { padding: 10px; font-size: 14px; }
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        Recordatorio: Caso Próximo a Vencer
                    </div>
                    <div class='content'>
                        <p>Estimado <span class='highlight'>{$usuario['nombre']} {$usuario['apellido_paterno']}</span>,</p>
                        <p>
                            El caso con <span class='highlight'>ID: {$caso['id_caso']}</span> tiene fechas próximas a vencer:
                        </p>
                        <ul>
                            <li>Fecha Corte: <span class='highlight'>{$caso['fecha_corte']}</span></li>
                            <li>Fecha Límite: <span class='highlight'>{$caso['limite_tiempo']}</span></li>
                        </ul>
                        <p>
                            Información del Cliente Asociado:
                        </p>
                        <ul>
                            <li>Nombre: <span class='highlight'>{$cliente['nombre']}</span></li>
                            <li>Teléfono: <span class='highlight'>{$cliente['telefono']}</span></li>
                            <li>Consulta: <span class='highlight'>{$cliente['tipo_consulta']}</span></li>
                        </ul>
                        <a href='https://vernalclients.com/clientes/{$cliente['id_cliente']}' class='cta-button'>
                            Ver Detalles del Cliente
                        </a>
                    </div>
                    <div class='footer'>
                        <p>Soporte Vernal Clients</p>
                        <p>© 2025 VERNAL FARNUM MEJÍA & ASSOCIATES. Todos los derechos reservados.</p>
                    </div>
                </div>
            </body>
            </html>
        ";

        // Enviar el correo usando el EmailService
        if ($emailService->sendEmail($to, $subject, $message)) {
            CLI::write("Correo enviado a: {$to} para el caso ID: {$caso['id_caso']}", 'green');
        } else {
            CLI::write("Error enviando correo para el caso ID: {$caso['id_caso']}", 'red');
        }
    }
}
