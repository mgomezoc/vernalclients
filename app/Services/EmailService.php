<?php

namespace App\Services;

use CodeIgniter\Email\Email;
use Config\Services;

class EmailService
{
    protected $email;

    public function __construct()
    {
        $this->email = Services::email();
    }

    public function sendEmail($to, $subject, $message)
    {
        $htmlMessage = $this->formatHtmlEmail($message);

        $this->email->setTo($to);
        $this->email->setSubject($subject);
        $this->email->setMessage($htmlMessage);
        $this->email->setMailType('html');

        if (!$this->email->send()) {
            log_message('error', 'Error enviando correo: ' . $this->email->printDebugger());
            return false;
        }

        return true;
    }

    private function formatHtmlEmail($content)
    {
        return '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email | Vernal</title>
        <style>
            /* Estilos generales */
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                color: #333;
            }
            .container {
                width: 100%;
                max-width: 600px;
                margin: 20px auto;
                background: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
                border: 1px solid #ddd;
            }
            .header {
                background: #31395f;
                color: #ffffff;
                padding: 15px;
                text-align: center;
                font-size: 22px;
                font-weight: bold;
                border-radius: 8px 8px 0 0;
            }
            .content {
                padding: 20px;
                font-size: 16px;
                line-height: 1.6;
                text-align: left;
            }
            .button {
                display: block;
                width: 100%;
                max-width: 200px;
                margin: 20px auto;
                padding: 12px;
                background: #31395f;
                color: #ffffff;
                text-align: center;
                font-size: 18px;
                font-weight: bold;
                text-decoration: none;
                border-radius: 5px;
                border: none;
            }
            .button:hover {
                background: #212744;
            }
            .footer {
                text-align: center;
                padding: 10px;
                font-size: 12px;
                color: #888;
                border-top: 1px solid #ddd;
            }

            /* Media query para móviles */
            @media screen and (max-width: 600px) {
                .container {
                    padding: 15px;
                }
                .content {
                    font-size: 14px;
                }
                .button {
                    font-size: 16px;
                    padding: 10px;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">Vernal | Notificación</div>
            <div class="content">
                ' . $content . '
            </div>
            <div class="footer">
                <p>© ' . date("Y") . ' Vernal. Todos los derechos reservados.</p>
            </div>
        </div>
    </body>
    </html>';
    }
}
