<?php

namespace Support;
use Laminas\Mvc\Middleware\PipeSpec;
use Laminas\Router\Http\Literal;
use User\Middleware\AuthenticationMiddleware;
use User\Middleware\AuthorizationMiddleware;
use User\Middleware\RequestPreparationMiddleware;
use User\Middleware\SecurityMiddleware;

return [
    'service_manager' => [
        'aliases' => [
            ],
        'factories' => [
            //start services factories
            Service\SupportService::class => Factory\Service\SupportServiceFactory::class,
            //start handlers factories

            //item handlers -api section
            Handler\Api\Item\ItemListHandler::class => Factory\Handler\Api\Item\ItemListHandlerFactory::class,
            Handler\Api\Item\ItemGetHandler::class => Factory\Handler\Api\Item\ItemGetHandlerFactory::class,
            Handler\Api\Item\ItemAddHandler::class => Factory\Handler\Api\Item\ItemAddHandlerFactory::class,
            Handler\Api\Item\ItemUpdateHandler::class => Factory\Handler\Api\Item\ItemUpdateHandlerFactory::class,
            Handler\Api\Item\ItemEditHandler::class => Factory\Handler\Api\Item\ItemEditHandlerFactory::class,

            //item handlers -admin section
            Handler\Admin\Item\ItemListHandler::class => Factory\Handler\Admin\Item\ItemListHandlerFactory::class,
            Handler\Admin\Item\ItemGetHandler::class => Factory\Handler\Admin\Item\ItemGetHandlerFactory::class,
            Handler\Admin\Item\ItemAddHandler::class => Factory\Handler\Admin\Item\ItemAddHandlerFactory::class,
            Handler\Admin\Item\ItemUpdateHandler::class => Factory\Handler\Admin\Item\ItemUpdateHandlerFactory::class,
            Handler\Admin\Item\ItemEditHandler::class => Factory\Handler\Admin\Item\ItemEditHandlerFactory::class,
        ],
    ],

    'router' => [
        'routes' => [
            // public section
            'public_support' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/support',
                    'defaults' => [],
                ],
                'child_routes' => [
                ],
            ],
            // admin section
            'api_support' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/api/support',
                    'defaults' => [],
                ],
                'child_routes' => [
                    // admin installer
                    'item' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/item',
                            'defaults' => [],
                        ],
                        'child_routes' => [
                            'add' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/add',
                                    'defaults' => [
                                        'module' => 'support',
                                        'section' => 'api',
                                        'package' => 'item',
                                        'handler' => 'get',
                                        'permission' => 'api-support-item-get',
                                        'controller' => PipeSpec::class,
                                        'middleware' => new PipeSpec(
                                            RequestPreparationMiddleware::class,
                                            SecurityMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            Handler\Api\Item\ItemAddHandler::class
                                        ),
                                    ],
                                ],
                            ],
                            'get' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/get',
                                    'defaults' => [
                                        'module' => 'support',
                                        'section' => 'api',
                                        'package' => 'item',
                                        'handler' => 'get',
                                        'permission' => 'api-support-item-get',
                                        'controller' => PipeSpec::class,
                                        'middleware' => new PipeSpec(
                                            RequestPreparationMiddleware::class,
                                            SecurityMiddleware::class,
                                            SecurityMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            Handler\Api\Item\ItemGetHandler::class
                                        ),
                                    ],
                                ],
                            ],
                            'update' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/update',
                                    'defaults' => [
                                        'module' => 'support',
                                        'section' => 'api',
                                        'package' => 'item',
                                        'handler' => 'update',
                                        'permission' => 'api-support-item-update',
                                        'controller' => PipeSpec::class,
                                        'middleware' => new PipeSpec(
                                            RequestPreparationMiddleware::class,
                                            SecurityMiddleware::class,
                                            SecurityMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            Handler\Api\Item\ItemUpdateHandler::class
                                        ),
                                    ],
                                ],
                            ],
                            'edit' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/edit',
                                    'defaults' => [
                                        'module' => 'support',
                                        'section' => 'api',
                                        'package' => 'item',
                                        'handler' => 'edit',
                                        'permission' => 'api-support-item-edit',
                                        'controller' => PipeSpec::class,
                                        'middleware' => new PipeSpec(
                                            RequestPreparationMiddleware::class,
                                            SecurityMiddleware::class,
                                            SecurityMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            Handler\Api\Item\ItemEditHandler::class
                                        ),
                                    ],
                                ],
                            ],
                            'list' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/list',
                                    'defaults' => [
                                        'module' => 'support',
                                        'section' => 'api',
                                        'package' => 'item',
                                        'handler' => 'list',
                                        'permission' => 'api-support-item-list',
                                        'controller' => PipeSpec::class,
                                        'middleware' => new PipeSpec(
                                            RequestPreparationMiddleware::class,
                                            SecurityMiddleware::class,
                                            SecurityMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            Handler\Api\Item\ItemListHandler::class
                                        ),
                                    ],
                                ],
                            ],
                        ]
                    ],
                ],
            ],
            // admin section
            'admin_support' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin/support',
                    'defaults' => [],
                ],
                'child_routes' => [
                    // admin installer
                    'installer' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/installer',
                            'defaults' => [
                                'module' => 'support',
                                'section' => 'admin',
                                'package' => 'installer',
                                'handler' => 'installer',
                                'controller' => PipeSpec::class,
                                'middleware' => new PipeSpec(
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    Handler\InstallerHandler::class
                                ),
                            ],
                        ],
                    ],
                    'item' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/item',
                            'defaults' => [],
                        ],
                        'child_routes' => [
                            'add' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/add',
                                    'defaults' => [
                                        'module' => 'support',
                                        'section' => 'admin',
                                        'package' => 'item',
                                        'handler' => 'get',
                                        'permission' => 'admin-support-item-get',
                                        'controller' => PipeSpec::class,
                                        'middleware' => new PipeSpec(
                                            RequestPreparationMiddleware::class,
                                            SecurityMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            Handler\Admin\Item\ItemAddHandler::class
                                        ),
                                    ],
                                ],
                            ],
                            'get' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/get',
                                    'defaults' => [
                                        'module' => 'support',
                                        'section' => 'admin',
                                        'package' => 'item',
                                        'handler' => 'get',
                                        'permission' => 'admin-support-item-get',
                                        'controller' => PipeSpec::class,
                                        'middleware' => new PipeSpec(
                                            RequestPreparationMiddleware::class,
                                            SecurityMiddleware::class,
                                            SecurityMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            Handler\Admin\Item\ItemGetHandler::class
                                        ),
                                    ],
                                ],
                            ],
                            'update' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/update',
                                    'defaults' => [
                                        'module' => 'support',
                                        'section' => 'admin',
                                        'package' => 'item',
                                        'handler' => 'update',
                                        'permission' => 'admin-support-item-update',
                                        'controller' => PipeSpec::class,
                                        'middleware' => new PipeSpec(
                                            RequestPreparationMiddleware::class,
                                            SecurityMiddleware::class,
                                            SecurityMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            Handler\Admin\Item\ItemUpdateHandler::class
                                        ),
                                    ],
                                ],
                            ],
                            'edit' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/edit',
                                    'defaults' => [
                                        'module' => 'support',
                                        'section' => 'admin',
                                        'package' => 'item',
                                        'handler' => 'edit',
                                        'permission' => 'admin-support-item-edit',
                                        'controller' => PipeSpec::class,
                                        'middleware' => new PipeSpec(
                                            RequestPreparationMiddleware::class,
                                            SecurityMiddleware::class,
                                            SecurityMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            Handler\Admin\Item\ItemEditHandler::class
                                        ),
                                    ],
                                ],
                            ],
                            'list' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/list',
                                    'defaults' => [
                                        'module' => 'support',
                                        'section' => 'admin',
                                        'package' => 'item',
                                        'handler' => 'list',
                                        'permission' => 'admin-support-item-list',
                                        'controller' => PipeSpec::class,
                                        'middleware' => new PipeSpec(
                                            RequestPreparationMiddleware::class,
                                            SecurityMiddleware::class,
                                            SecurityMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            AuthenticationMiddleware::class,
                                            Handler\Admin\Item\ItemListHandler::class
                                        ),
                                    ],
                                ],
                            ],
                        ]
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];