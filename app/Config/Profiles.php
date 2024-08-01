<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Profiles extends BaseConfig
{
    public $menus = [
        'ADMIN' => [
            'usuarios' => [
                'icon' => 'fa-duotone fa-users fa-fade',
                'url' => 'usuarios',
                'label' => 'Usuarios',
            ],
            'sucursales' => [
                'icon' => 'fa-duotone fa-building fa-fade',
                'url' => 'sucursales',
                'label' => 'Sucursales',
            ],
            'abogados' => [
                'icon' => 'fa-solid fa-gavel',
                'url' => 'abogados',
                'label' => 'Abogados',
            ],
            'clientes' => [
                'icon' => 'fa-solid fa-people-simple',
                'url' => 'clientes',
                'label' => 'Clientes',
            ],
            'reportes' => [
                'icon' => 'fa-duotone fa-file-chart-column',
                'url' => 'reportes',
                'label' => 'Reportes',
            ],
            'auditoria' => [  // Nueva sección agregada
                'icon' => 'fa-duotone fa-clipboard-list-check',
                'url' => 'auditoria',
                'label' => 'Auditoría',
            ],
        ],
        'CALL' => [
            'clientes' => [
                'icon' => 'fa-solid fa-people-simple',
                'url' => 'clientes/callcenter',
                'label' => 'Clientes',
            ]
        ],
        'PARALEGAL' => [
            'clientes' => [
                'icon' => 'fa-solid fa-people-simple',
                'url' => 'clientes/abogado',
                'label' => 'Clientes',
            ],
        ],
        'ATTORNEY' => [
            'clientes' => [
                'icon' => 'fa-solid fa-people-simple',
                'url' => 'clientes/abogado',
                'label' => 'Prospectos',
            ],
            'todos_clientes' => [
                'icon' => 'fa-solid fa-people-simple',
                'url' => 'clientes/asignados',
                'label' => 'Bitácora Clientes',
            ],
            'reportes' => [
                'icon' => 'fa-duotone fa-file-chart-column',
                'url' => 'reportes',
                'label' => 'Reportes',
            ],
        ],
        'RECEPTION' => [
            'clientes' => [
                'icon' => 'fa-solid fa-people-simple',
                'url' => 'clientes/recepcion',
                'label' => 'Clientes',
            ],
        ],
        'MARKETING' => [
            'clientes' => [
                'icon' => 'fa-solid fa-people-simple',
                'url' => 'clientes/recepcion',
                'label' => 'Clientes',
            ],
        ],
    ];
}
