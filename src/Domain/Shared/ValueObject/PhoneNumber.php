<?php

namespace App\Domain\Shared\ValueObject;

final class PhoneNumber
{
    private string $value;

    public function __construct(string $value)
    {
        $trimmed = trim($value);
        if ($trimmed === '' || !preg_match('/^\+?[1-9]\d{1,14}$/', $trimmed)) {
            throw new \InvalidArgumentException('Invalid phone number.');
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


