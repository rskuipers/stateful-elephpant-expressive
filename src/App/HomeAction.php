<?php
declare(strict_types=1);

namespace App;

use App\Model\Order;
use Aura\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;

final class HomeAction
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Session $session */
        $session = $request->getAttribute(\DaMess\Http\SessionMiddleware::KEY);
        $session->getSegment('app')->set('order', new Order());

        return new RedirectResponse($this->router->generateUri('order'));
    }
}
