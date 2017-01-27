<?php
declare(strict_types=1);

namespace App\Checkout\Result;

final class Proceed implements Result
{
    private $nextStep;

    private function __construct(string $step = null)
    {
        $this->nextStep = $step;
    }

    public static function toNextStep(): self
    {
        return new self(null);
    }

    public static function toStep(string $step): self
    {
        return new self($step);
    }

    public function hasNextStep(): bool
    {
        return is_string($this->nextStep);
    }

    public function getNextStep(): string
    {
        return $this->nextStep;
    }
}
