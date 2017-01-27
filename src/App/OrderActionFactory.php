<?php
declare(strict_types=1);

namespace App;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

final class OrderActionFactory
{
    public function __invoke(ContainerInterface $container): OrderAction
    {
        return new OrderAction(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
