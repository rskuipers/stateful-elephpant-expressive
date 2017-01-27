<?php
declare(strict_types=1);

namespace App;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

final class HomeActionFactory
{
    public function __invoke(ContainerInterface $container): HomeAction
    {
        return new HomeAction(
            $container->get(RouterInterface::class)
        );
    }
}
