<?php
declare(strict_types=1);

namespace App\Checkout;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

final class CheckoutActionFactory
{
    public function __invoke(ContainerInterface $container): CheckoutAction
    {
        $steps = [];

        return new CheckoutAction($steps, $container->get(RouterInterface::class));
    }
}
