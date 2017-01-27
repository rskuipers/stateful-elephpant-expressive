<?php
declare(strict_types=1);

namespace App\Checkout;

use App\Checkout\Result\Proceed;
use App\Checkout\Steps\Step;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;

final class CheckoutAction
{
    /**
     * @var Step[]
     */
    private $steps;

    private $router;

    public function __construct(array $steps, RouterInterface $router)
    {
        $this->router = $router;

        foreach ($steps as $step) {
            $this->steps[] = $step;
        }
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $currentStep = $this->currentStep($request);
        $session = $request->getAttribute(\DaMess\Http\SessionMiddleware::KEY);
        $order = $session->getSegment('app')->get('order');

        if ($request->getMethod() === 'POST') {
            $result = $currentStep->process($request, $order);
            if ($result instanceof Proceed) {
                return $this->proceed($currentStep, $result);
            }
        }

        return $currentStep->display($request, $order);
    }

    private function currentStep(ServerRequestInterface $request): Step
    {
        foreach ($this->steps as $step) {
            if ($step->getName() === $request->getAttribute('step')) {
                return $step;
            }
        }

        throw new \RuntimeException('Step not found');
    }

    private function proceed(Step $currentStep, Proceed $result): RedirectResponse
    {
        if ($result->hasNextStep()) {
            return new RedirectResponse($this->router->generateUri('checkout/step', [
                'step' => $result->getNextStep(),
            ]));
        }

        for ($i = 0; $i < count($this->steps); $i++) {
            $step = $this->steps[$i];
            if ($step->getName() === $currentStep->getName()) {
                return $this->redirectToStep(++$i);
            }
        }

        throw new \RuntimeException('Step not found');
    }

    private function redirectToStep(int $stepNumber): RedirectResponse
    {
        if (!array_key_exists($stepNumber, $this->steps)) {
            return new RedirectResponse($this->router->generateUri('order'));
        }

        $step = $this->steps[$stepNumber];
        return new RedirectResponse($this->router->generateUri('checkout/step', ['step' => $step->getName()]));
    }
}
