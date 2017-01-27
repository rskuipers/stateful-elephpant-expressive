<?php
declare(strict_types=1);

namespace App\Checkout\Steps;

use App\Checkout\Result\Proceed;
use App\Checkout\Result\Result;
use App\Model\Order;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

final class Review implements Step
{
    private $templateRenderer;

    public function __construct(TemplateRendererInterface $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function display(ServerRequestInterface $request, Order $order): ResponseInterface
    {
        return new HtmlResponse($this->templateRenderer->render('@app/checkout/review.html.twig', [
            'order' => $order,
        ]));
    }

    public function process(ServerRequestInterface $request, Order $order): Result
    {
        $order->setStatus(Order::STATUS_PENDING);
        return Proceed::toNextStep();
    }

    public function getName(): string
    {
        return 'review';
    }
}
