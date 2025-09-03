<?php

namespace App\Domain\Student;

use App\Domain\School\SchoolId;

interface StudentRepository
{
    public function save(Student $student): void;
    public function byId(StudentId $id): ?Student;
    /** @return Student[] */
    public function bySchool(SchoolId $schoolId): array;
}


