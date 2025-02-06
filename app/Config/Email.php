<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'soporte@vernalclients.com';
    public string $fromName   = 'Soporte Vernal Clients';

    public string $protocol;
    public string $SMTPHost;
    public string $SMTPUser;
    public string $SMTPPass;
    public int $SMTPPort;
    public string $SMTPCrypto;

    public int $SMTPTimeout = 10;
    public string $mailType = 'html';
    public string $charset = 'UTF-8';
    public string $CRLF = "\r\n";
    public string $newline = "\r\n";
    public bool $validate = true;

    public function __construct()
    {
        $this->protocol = 'smtp';
        $this->SMTPHost = getenv('SMTP_HOST') ?: 'default_host';
        $this->SMTPUser = getenv('SMTP_USER') ?: 'default_user';
        $this->SMTPPass = getenv('SMTP_PASS') ?: 'default_pass';
        $this->SMTPPort = getenv('SMTP_PORT') ? (int) getenv('SMTP_PORT') : 25;
        $this->SMTPCrypto = getenv('SMTP_CRYPTO') ?: 'tls';
    }
}
