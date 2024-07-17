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
        $this->email->setTo($to);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        if (!$this->email->send()) {
            log_message('error', 'Error enviando correo: ' . $this->email->printDebugger());
            return false;
        }

        return true;
    }
}
