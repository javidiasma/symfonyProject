<?php

namespace App\Domain\School;

interface SchoolRepository
{
    public function save(School $school): void;
    public function byId(SchoolId $id): ?School;
}


