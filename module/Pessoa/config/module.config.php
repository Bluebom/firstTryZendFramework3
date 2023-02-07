<?php

namespace Pessoa;

use Pessoa\Controller\PessoaController;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'pessoa' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/pessoa[/:action[/:id]]',
                    'constraint' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller' => PessoaController::class,
                        'action' => 'index',
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
      'factories' => [
//          PessoaController::class => InvokableFactory::class,
      ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'pessoa' => __DIR__ . '/../view'
        ]
    ],
    'db' => [
        'driver' => 'Pdo_Pgsql',
        'dsn' => 'pgsql:dbname=zend;host=postgres',
        'username' => 'frank',
        'password' => '123123',
        'port' => '5432'
    ]
];