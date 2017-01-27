<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
        ],
        // Map middleware -> factories here
        'factories' => [
            App\HomeAction::class => App\HomeActionFactory::class,
            App\OrderAction::class => App\OrderActionFactory::class,
            App\Checkout\CheckoutAction::class => App\Checkout\CheckoutActionFactory::class,
        ],
    ],

    'routes' => [
         [
             'name' => 'home',
             'path' => '/',
             'middleware' => App\HomeAction::class,
             'allowed_methods' => ['GET'],
         ],
         [
             'name' => 'checkout/display',
             'path' => '/checkout/{step:[a-z-]+}',
             'middleware' => App\Checkout\CheckoutAction::class,
             'allowed_methods' => ['GET', 'POST'],
         ],
         [
             'name' => 'order',
             'path' => '/order',
             'middleware' => App\OrderAction::class,
             'allowed_methods' => ['GET'],
         ],
    ],
];
