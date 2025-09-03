<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\School\School;
use App\Domain\School\SchoolId;
use App\Domain\School\SchoolRepository as DomainSchoolRepository;
use App\Entity\School as OrmSchool;
use App\Infrastructure\Persistence\Doctrine\Mapper\SchoolMapper;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineSchoolRepository implements DomainSchoolRepository
{
    public function __construct(private readonly EntityManagerInterface $em) {}

    public function save(School $school): void
    {
        $orm = SchoolMapper::toOrm($school);
        $this->em->persist($orm);
        $this->em->flush();
    }

    public function byId(SchoolId $id): ?School
    {
        $orm = $this->em->getRepository(OrmSchool::class)->find($id->value());
        return $orm ? SchoolMapper::toDomain($orm) : null;
    }
}


