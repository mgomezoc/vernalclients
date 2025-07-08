<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Session\Handlers\FileHandler;

/**
 * @property string $assetVersion
 */
class App extends BaseConfig
{
    // URL base del sistema (ajustada correctamente para entorno local)
    public string $baseURL = 'http://localhost/abogadovernal/LawLink/public/';

    // Dominios permitidos (útil si usas validación de host)
    public array $allowedHostnames = [];

    // Página index principal (puede dejarse si usas .htaccess correctamente)
    public string $indexPage = 'index.php';

    // Método para obtener URI (REQUEST_URI suele ser la mejor opción)
    public string $uriProtocol = 'REQUEST_URI';

    // Configuración de idioma y localización
    public string $defaultLocale = 'en';
    public bool $negotiateLocale = false;
    public array $supportedLocales = ['en'];

    // Zona horaria (correcta para Monterrey, México)
    public string $appTimezone = 'America/Chicago';

    // Charset estándar
    public string $charset = 'UTF-8';

    // Forzar HTTPS (habilítalo en producción si usas SSL)
    public bool $forceGlobalSecureRequests = false;

    // Sesión: configuración por defecto usando archivos
    public string $sessionDriver = FileHandler::class;
    public string $sessionCookieName = 'ci_session';
    public int $sessionExpiration = 7200; // 2 horas
    public string $sessionSavePath = WRITEPATH . 'session';
    public bool $sessionMatchIP = false;
    public int $sessionTimeToUpdate = 300;
    public bool $sessionRegenerateDestroy = false;
    public ?string $sessionDBGroup = null;

    // Cookies
    public string $cookiePrefix = '';
    public string $cookieDomain = '';
    public string $cookiePath = '/';
    public bool $cookieSecure = false; // poner en true en producción con HTTPS
    public bool $cookieHTTPOnly = true;
    public ?string $cookieSameSite = 'Lax';

    // Proxy (si usas load balancer tipo Cloudflare)
    public array $proxyIPs = [];

    // Protección CSRF
    public string $CSRFTokenName = 'csrf_test_name';
    public string $CSRFHeaderName = 'X-CSRF-TOKEN';
    public string $CSRFCookieName = 'csrf_cookie_name';
    public int $CSRFExpire = 7200;
    public bool $CSRFRegenerate = true;
    public bool $CSRFRedirect = false;
    public string $CSRFSameSite = 'Lax';

    // Política CSP (desactívala si no la estás usando)
    public bool $CSPEnabled = false;

    // Versión de assets (JS, CSS) para invalidar caché del navegador
    public string $assetVersion;

    public function __construct()
    {
        parent::__construct();
        $this->assetVersion = env('app.assetVersion', '1.0.0');
    }
}
