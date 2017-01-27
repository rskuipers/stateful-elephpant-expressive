<?php
declare(strict_types=1);

namespace App\Checkout\Steps;

use App\Checkout\Result\Error;
use App\Checkout\Result\Proceed;
use App\Checkout\Result\Result;
use App\Model\Order;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

final class Payment implements Step
{
    private $templateRenderer;

    public function __construct(TemplateRendererInterface $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function display(ServerRequestInterface $request, Order $order): ResponseInterface
    {
        return new HtmlResponse($this->templateRenderer->render('@app/checkout/payment.html.twig'));
    }

    public function process(ServerRequestInterface $request, Order $order): Result
    {
        $data = $request->getParsedBody();
        if (!isset($data['paymentMethod'])) {
            return new Error();
        }

        $order->setPaymentMethod($data['paymentMethod']);

        return Proceed::toNextStep();
    }

    public function getName(): string
    {
        return 'payment';
    }
}
