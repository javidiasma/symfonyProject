<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\School\SchoolId;
use App\Domain\Student\Student;
use App\Domain\Student\StudentId;
use App\Domain\Student\StudentRepository as DomainStudentRepository;
use App\Entity\School as OrmSchool;
use App\Entity\Student as OrmStudent;
use App\Infrastructure\Persistence\Doctrine\Mapper\StudentMapper;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineStudentRepository implements DomainStudentRepository
{
    public function __construct(private readonly EntityManagerInterface $em) {}

    public function save(Student $student): void
    {
        $school = null;
        if ($student->schoolId()) {
            $school = $this->em->getRepository(OrmSchool::class)->find($student->schoolId()->value());
        }
        $orm = StudentMapper::toOrm($student, null, $school);
        $this->em->persist($orm);
        $this->em->flush();
    }

    public function byId(StudentId $id): ?Student
    {
        $orm = $this->em->getRepository(OrmStudent::class)->find($id->value());
        return $orm ? StudentMapper::toDomain($orm) : null;
    }

    public function bySchool(SchoolId $schoolId): array
    {
        $orms = $this->em->getRepository(OrmStudent::class)->findBy(['school' => $schoolId->value()]);
        return array_map(static fn(OrmStudent $o) => StudentMapper::toDomain($o), $orms);
    }
}


