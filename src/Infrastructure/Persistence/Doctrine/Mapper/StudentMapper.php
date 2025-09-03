<?php

namespace App\Infrastructure\Persistence\Doctrine\Mapper;

use App\Domain\School\SchoolId;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\Shared\ValueObject\PhoneNumber;
use App\Domain\Student\Student as DomainStudent;
use App\Domain\Student\StudentId;
use App\Entity\School as OrmSchool;
use App\Entity\Student as OrmStudent;

final class StudentMapper
{
    public static function toDomain(OrmStudent $orm): DomainStudent
    {
        return DomainStudent::reconstitute(
            new StudentId($orm->getId()),
            new Name($orm->getUsername() ?? ''),
            $orm->getPhoneNumber() ? new PhoneNumber($orm->getPhoneNumber()) : null,
            $orm->getSchool() ? new SchoolId($orm->getSchool()->getId()) : null
        );
    }

    public static function toOrm(DomainStudent $domain, ?OrmStudent $target = null, ?OrmSchool $school = null): OrmStudent
    {
        $orm = $target ?? new OrmStudent();
        $orm->setUsername($domain->username()->value());
        $orm->setPhoneNumber($domain->phoneNumber()?->value());
        if ($school) {
            $orm->setSchool($school);
        }
        return $orm;
    }
}


