<?php

namespace App\Application\Student;

use App\Domain\School\SchoolId;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\Shared\ValueObject\PhoneNumber;
use App\Domain\Student\Student;
use App\Domain\Student\StudentRepository;

final class RegisterStudentService
{
    public function __construct(private readonly StudentRepository $students) {}

    public function handle(string $username, ?string $phoneNumber, ?int $schoolId): Student
    {
        $phone = $phoneNumber ? new PhoneNumber($phoneNumber) : null;
        $school = $schoolId ? new SchoolId($schoolId) : null;
        $student = Student::register(new Name($username), $phone, $school);
        $this->students->save($student);
        return $student;
    }
}


