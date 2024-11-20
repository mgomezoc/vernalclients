<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Profiles extends BaseConfig
{
    public $menus = [
        'ADMIN' => [
            'usuarios' => [
                'icon' => 'fa-solid fa-users-cog',
                'url' => 'usuarios',
                'label' => 'Usuarios',
            ],
            'sucursales' => [
                'icon' => 'fa-solid fa-building',
                'url' => 'sucursales',
                'label' => 'Sucursales',
            ],
            'abogados' => [
                'icon' => 'fa-solid fa-gavel',
                'url' => 'abogados',
                'label' => 'Abogados',
            ],
            'clientes' => [
                'icon' => 'fa-solid fa-user-friends',
                'url' => 'clientes',
                'label' => 'Clientes',
            ],
            'reportes' => [
                'icon' => 'fa-solid fa-chart-line',
                'url' => 'reportes',
                'label' => 'Reportes',
            ],
            'pagos' => [
                'icon' => 'fa-solid fa-money-check-alt',
                'url' => 'pagos_consultas',
                'label' => 'Pagos',
            ],
            'auditoria' => [
                'icon' => 'fa-solid fa-clipboard-check',
                'url' => 'auditoria',
                'label' => 'Auditoría',
            ],
        ],
        'ADMINCALL' => [
            'clientes' => [
                'icon' => 'fa-solid fa-user-friends',
                'url' => 'clientes',
                'label' => 'Clientes',
            ],
            'pagos' => [
                'icon' => 'fa-solid fa-money-check-alt',
                'url' => 'pagos_consultas',
                'label' => 'Pagos',
            ],
        ],
        'CALL' => [
            'clientes' => [
                'icon' => 'fa-solid fa-headset',
                'url' => 'clientes/callcenter',
                'label' => 'Clientes',
            ]
        ],
        'PARALEGAL' => [
            'clientes' => [
                'icon' => 'fa-solid fa-user-tie',
                'url' => 'clientes/abogado',
                'label' => 'Clientes',
            ],
        ],
        'ATTORNEY' => [
            'clientes' => [
                'icon' => 'fa-solid fa-briefcase',
                'url' => 'clientes/abogado',
                'label' => 'Prospectos',
            ],
            'todos_clientes' => [
                'icon' => 'fa-solid fa-book',
                'url' => 'clientes/asignados',
                'label' => 'Bitácora Clientes',
            ],
            'reportes' => [
                'icon' => 'fa-solid fa-chart-pie',
                'url' => 'reportes',
                'label' => 'Reportes',
            ],
        ],
        'RECEPTION' => [
            'clientes' => [
                'icon' => 'fa-solid fa-user-check',
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
                'icon' => 'fa-solid fa-bullhorn',
                'url' => 'clientes/recepcion',
                'label' => 'Clientes',
            ],
        ],
    ];
}
