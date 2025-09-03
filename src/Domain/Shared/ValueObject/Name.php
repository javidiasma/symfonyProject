<?php

namespace App\Domain\Shared\ValueObject;

final class Name
{
    private string $value;

    public function __construct(string $value)
    {
        $trimmed = trim($value);
        if ($trimmed === '' || mb_strlen($trimmed) < 2) {
            throw new \InvalidArgumentException('Name must be at least 2 characters.');
        }
        $this->value = $trimmed;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}


