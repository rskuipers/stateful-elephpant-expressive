<?php
declare(strict_types=1);

namespace App\Model;

final class Order
{
    const STATUS_NEW         = 'new';
    const STATUS_PENDING     = 'pending';
    const STATUS_COMPLETED   = 'completed';
    const STATUS_CANCELED    = 'canceled';
    const STATUS_REFUNDED    = 'refunded';

    private $status = self::STATUS_NEW;

    private $paymentMethod;

    private $email;

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
