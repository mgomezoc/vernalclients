<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use App\Services\EmailService;

class PasswordController extends Controller
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    /**
     * Muestra el formulario para solicitar el restablecimiento de contraseña.
     */
    public function solicitar()
    {
        return view('password/solicitar');
    }

    /**
     * Procesa la solicitud de restablecimiento de contraseña.
     */
    public function enviarCorreo()
    {
        $email = $this->request->getPost('email');

        $usuario = $this->usuarioModel->where('correo_electronico', $email)->first();

        if (!$usuario) {
            return redirect()->to(site_url('password/solicitar'))
                ->with('error', 'El correo no está registrado.');
        }

        // Generar token de recuperación
        $token = bin2hex(random_bytes(50));
        $expiration = Time::now()->addHours(24); // 24 horas de validez

        // Guardar en la base de datos
        $this->usuarioModel->update($usuario['id'], [
            'reset_token' => $token,
            'reset_expiration' => $expiration
        ]);

        // Enviar correo
        $emailService = new EmailService();
        $to = $usuario['correo_electronico'];
        $subject = "Recuperación de contraseña";

        // Sanitizar nombre del usuario para evitar XSS
        $nombreUsuario = htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8');

        // Generar enlace seguro
        $resetLink = base_url("password/restablecer/" . urlencode($token));

        // Mensaje con diseño mejorado
        $message = "
    <p>Hola, <strong>{$nombreUsuario}</strong>,</p>
    <p>Hemos recibido una solicitud para restablecer tu contraseña. Haz clic en el botón de abajo para continuar:</p>
    <p style='text-align: center;'>
        <a href='{$resetLink}' class='button' style='display: inline-block; background: #31395f; color: #ffffff; padding: 12px 20px; font-size: 18px; text-decoration: none; border-radius: 5px;'>Restablecer contraseña</a>
    </p>
    <p>Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
    <p><a href='{$resetLink}'>{$resetLink}</a></p>
    <p>Este enlace es válido por 24 horas.</p>
    <p>Si no solicitaste este cambio, puedes ignorar este mensaje.</p>
    <p>Atentamente,<br><strong>Equipo de Vernal</strong></p>";

        // Usar la plantilla de formato HTML para mejorar apariencia y compatibilidad
        $emailService->sendEmail($to, $subject, $message);


        return redirect()->to(site_url('password/solicitar'))
            ->with('success', 'Si el correo está registrado, recibirás instrucciones para restablecer tu contraseña.');
    }

    /**
     * Muestra el formulario de restablecimiento de contraseña.
     */
    public function restablecer($token)
    {
        $usuario = $this->usuarioModel->where('reset_token', $token)
            ->where('reset_expiration >=', Time::now())
            ->first();

        if (!$usuario) {
            return redirect()->to(site_url('password/solicitar'))
                ->with('error', 'El enlace es inválido o ha expirado.');
        }

        return view('password/restablecer', ['token' => $token]);
    }

    /**
     * Procesa el cambio de contraseña.
     */
    public function actualizar()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
        }

        $usuario = $this->usuarioModel->where('reset_token', $token)
            ->where('reset_expiration >=', Time::now())
            ->first();

        if (!$usuario) {
            return redirect()->to(site_url('password/solicitar'))
                ->with('error', 'El enlace es inválido o ha expirado.');
        }

        // Actualizar la contraseña y eliminar el token
        $this->usuarioModel->update($usuario['id'], [
            'contrasena' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_expiration' => null
        ]);

        return redirect()->to(site_url('login'))
            ->with('success', 'Tu contraseña ha sido restablecida correctamente.');
    }
}
