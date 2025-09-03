<?php

namespace App\Infrastructure\Persistence\Doctrine\Mapper;

use App\Domain\School\School as DomainSchool;
use App\Domain\School\SchoolId;
use App\Domain\Shared\ValueObject\Name;
use App\Entity\School as OrmSchool;

final class SchoolMapper
{
    public static function toDomain(OrmSchool $orm): DomainSchool
    {
        return DomainSchool::reconstitute(
            new SchoolId($orm->getId()),
            new Name($orm->getName()),
            $orm->getDegree()
        );
    }

    public static function toOrm(DomainSchool $domain, ?OrmSchool $target = null): OrmSchool
    {
        $orm = $target ?? new OrmSchool();
        $orm->setName($domain->name()->value());
        $orm->setDegree($domain->degree());
        return $orm;
    }
}


