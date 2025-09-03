<?php

namespace App\Domain\Student;

use App\Domain\School\SchoolId;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\Shared\ValueObject\PhoneNumber;

final class Student
{
    private ?StudentId $id;
    private Name $username;
    private ?PhoneNumber $phoneNumber;
    private ?SchoolId $schoolId;

    private function __construct(?StudentId $id, Name $username, ?PhoneNumber $phoneNumber, ?SchoolId $schoolId)
    {
        $this->id = $id;
        $this->username = $username;
        $this->phoneNumber = $phoneNumber;
        $this->schoolId = $schoolId;
    }

    public static function register(Name $username, ?PhoneNumber $phoneNumber = null, ?SchoolId $schoolId = null): self
    {
        return new self(null, $username, $phoneNumber, $schoolId);
    }

    public static function reconstitute(StudentId $id, Name $username, ?PhoneNumber $phoneNumber, ?SchoolId $schoolId): self
    {
        return new self($id, $username, $phoneNumber, $schoolId);
    }

    public function id(): ?StudentId { return $this->id; }
    public function username(): Name { return $this->username; }
    public function phoneNumber(): ?PhoneNumber { return $this->phoneNumber; }
    public function schoolId(): ?SchoolId { return $this->schoolId; }

    public function rename(Name $username): void { $this->username = $username; }
    public function changePhoneNumber(?PhoneNumber $phoneNumber): void { $this->phoneNumber = $phoneNumber; }
    public function assignToSchool(?SchoolId $schoolId): void { $this->schoolId = $schoolId; }
}


