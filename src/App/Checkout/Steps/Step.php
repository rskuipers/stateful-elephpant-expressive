<?php
declare(strict_types=1);

namespace App\Checkout\Steps;

use App\Checkout\Result\Result;
use App\Model\Order;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Step
{
    public function display(ServerRequestInterface $request, Order $order): ResponseInterface;
    public function process(ServerRequestInterface $request, Order $order): Result;
    public function getName(): string;
}
