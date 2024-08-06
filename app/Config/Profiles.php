<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Profiles extends BaseConfig
{
    public $menus = [
        'ADMIN' => [
            'usuarios' => [
                'icon' => 'fa-solid fa-users-cog', // Ícono relacionado con la gestión de usuarios
                'url' => 'usuarios',
                'label' => 'Usuarios',
            ],
            'sucursales' => [
                'icon' => 'fa-solid fa-building', // Ícono de edificio para representar sucursales
                'url' => 'sucursales',
                'label' => 'Sucursales',
            ],
            'abogados' => [
                'icon' => 'fa-solid fa-gavel', // Ícono de martillo, representando abogados o justicia
                'url' => 'abogados',
                'label' => 'Abogados',
            ],
            'clientes' => [
                'icon' => 'fa-solid fa-user-friends', // Ícono de grupo de personas para clientes
                'url' => 'clientes',
                'label' => 'Clientes',
            ],
            'reportes' => [
                'icon' => 'fa-solid fa-chart-line', // Ícono de gráfico de línea para representar reportes
                'url' => 'reportes',
                'label' => 'Reportes',
            ],
            'pagos' => [
                'icon' => 'fa-solid fa-money-check-alt',
                'url' => 'pagos_consultas',
                'label' => 'Pagos',
            ],
            'auditoria' => [
                'icon' => 'fa-solid fa-clipboard-check', // Ícono de auditoría para representar revisión y control
                'url' => 'auditoria',
                'label' => 'Auditoría',
            ],
        ],
        'CALL' => [
            'clientes' => [
                'icon' => 'fa-solid fa-headset', // Ícono de auriculares para representar el call center
                'url' => 'clientes/callcenter',
                'label' => 'Clientes',
            ]
        ],
        'PARALEGAL' => [
            'clientes' => [
                'icon' => 'fa-solid fa-user-tie', // Ícono de una persona con corbata, representando un asistente legal
                'url' => 'clientes/abogado',
                'label' => 'Clientes',
            ],
        ],
        'ATTORNEY' => [
            'clientes' => [
                'icon' => 'fa-solid fa-briefcase', // Ícono de maletín para representar prospectos o casos legales
                'url' => 'clientes/abogado',
                'label' => 'Prospectos',
            ],
            'todos_clientes' => [
                'icon' => 'fa-solid fa-book', // Ícono de libro para representar una bitácora
                'url' => 'clientes/asignados',
                'label' => 'Bitácora Clientes',
            ],
            'reportes' => [
                'icon' => 'fa-solid fa-chart-pie', // Ícono de gráfico de pastel para reportes
                'url' => 'reportes',
                'label' => 'Reportes',
            ],
        ],
        'RECEPTION' => [
            'clientes' => [
                'icon' => 'fa-solid fa-user-check', // Ícono de usuario con marca de verificación para recepción
                'url' => 'clientes/recepcion',
                'label' => 'Clientes',
            ],
            'pagos' => [
                'icon' => 'fa-solid fa-money-check-alt',
                'url' => 'pagos_consultas',
                'label' => 'Pagos',
            ],
        ],
        'MARKETING' => [
            'clientes' => [
                'icon' => 'fa-solid fa-bullhorn', // Ícono de megáfono para representar marketing
                'url' => 'clientes/recepcion',
                'label' => 'Clientes',
            ],
        ],
    ];
}
