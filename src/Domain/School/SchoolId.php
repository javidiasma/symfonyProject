<?php

namespace App\Domain\School;

final class SchoolId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('SchoolId must be positive.');
        }
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}


