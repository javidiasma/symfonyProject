<?php

namespace App\Domain\Student;

final class StudentId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('StudentId must be positive.');
        }
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}


