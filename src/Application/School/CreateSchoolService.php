<?php

namespace App\Application\School;

use App\Domain\School\School;
use App\Domain\School\SchoolRepository;
use App\Domain\Shared\ValueObject\Name;

final class CreateSchoolService
{
    public function __construct(private readonly SchoolRepository $schools) {}

    public function handle(string $name, string $degree): School
    {
        $school = School::create(new Name($name), $degree);
        $this->schools->save($school);
        return $school;
    }
}


