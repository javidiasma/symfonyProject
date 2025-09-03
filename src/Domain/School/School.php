<?php

namespace App\Domain\School;

use App\Domain\Shared\ValueObject\Name;

final class School
{
    private ?SchoolId $id;
    private Name $name;
    private string $degree;

    private function __construct(?SchoolId $id, Name $name, string $degree)
    {
        $this->id = $id;
        $this->name = $name;
        $this->changeDegree($degree);
    }

    public static function create(Name $name, string $degree): self
    {
        return new self(null, $name, $degree);
    }

    public static function reconstitute(SchoolId $id, Name $name, string $degree): self
    {
        return new self($id, $name, $degree);
    }

    public function id(): ?SchoolId { return $this->id; }
    public function name(): Name { return $this->name; }
    public function degree(): string { return $this->degree; }

    public function rename(Name $name): void
    {
        $this->name = $name;
    }

    public function changeDegree(string $degree): void
    {
        $trimmed = trim($degree);
        if ($trimmed === '' || mb_strlen($trimmed) < 2) {
            throw new \InvalidArgumentException('Degree must be at least 2 characters.');
        }
        $this->degree = $trimmed;
    }
}


