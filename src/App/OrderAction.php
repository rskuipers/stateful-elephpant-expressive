<?php
declare(strict_types=1);

namespace App;

use Aura\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

final class OrderAction
{
    private $templateRenderer;

    public function __construct(TemplateRendererInterface $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Session $session */
        $session = $request->getAttribute(\DaMess\Http\SessionMiddleware::KEY);

        return new HtmlResponse($this->templateRenderer->render('@app/order.html.twig', [
            'order' => $session->getSegment('app')->get('order'),
        ]));
    }
}
