<?php
declare(strict_types=1);

namespace App\Checkout;

use App\Checkout\Steps\Details;
use App\Checkout\Steps\Payment;
use App\Checkout\Steps\Review;
use Aura\Session\Session;
use Interop\Container\ContainerInterface;
use SM\Factory\Factory;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

final class CheckoutActionFactory
{
    public function __invoke(ContainerInterface $container): CheckoutAction
    {
        $session = $container->get(Session::class);
        $order = $session->getSegment('app')->get('order');

        $stateMachineFactory = $container->get(Factory::class);
        $orderStateMachine = $stateMachineFactory->get($order);

        $steps = [
            new Details($container->get(TemplateRendererInterface::class)),
            new Payment($container->get(TemplateRendererInterface::class)),
            new Review($container->get(TemplateRendererInterface::class), $orderStateMachine),
        ];

        return new CheckoutAction($steps, $container->get(RouterInterface::class));
    }
}
