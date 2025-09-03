<?php

namespace App\Controller;

use App\Application\School\CreateSchoolService;
use App\Domain\School\SchoolId;
use App\Domain\School\SchoolRepository as DomainSchoolRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class SchoolController extends AbstractController
{
    #[Route('/schools', name: 'school_list', methods: ['GET'])]
    public function list(DomainSchoolRepository $schools): JsonResponse
    {
        try {
            // In a richer example, a query service would provide DTOs or view models.
            $schoolData = [];
            return $this->json([
                'schools' => $schoolData
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return $this->json([
                'error' => 'Failed to retrieve schools',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/schools/{id}', name: 'school_show', methods: ['GET'])]
    public function show(int $id, DomainSchoolRepository $schools): JsonResponse
    {
        try {
            $school = $schools->byId(new SchoolId($id));
            if (!$school) {
                return $this->json([
                    'error' => 'School not found'
                ], Response::HTTP_NOT_FOUND);
            }

            return $this->json([
                'school' => [
                    'id' => $school->id()?->value(),
                    'name' => (string)$school->name(),
                    'degree' => $school->degree()
                ]
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return $this->json([
                'error' => 'Failed to retrieve school',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/schools', name: 'school_create', methods: ['POST'])]
    public function create(
        Request $request,
        CreateSchoolService $createSchool
    ): JsonResponse {
        try {
            $payload = json_decode($request->getContent(), true) ?? [];
            $name = $payload['name'] ?? '';
            $degree = $payload['degree'] ?? '';

            $school = $createSchool->handle($name, $degree);

            return $this->json([
                'message' => 'School created successfully',
                'school' => [
                    'id' => $school->id()?->value(),
                    'name' => (string)$school->name(),
                    'degree' => $school->degree()
                ]
            ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return $this->json([
                'error' => 'Failed to create school',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/schools/{id}', name: 'school_update', methods: ['PUT'])]
    public function update(
        int $id,
        Request $request,
        DomainSchoolRepository $schools
    ): JsonResponse {
        try {
            $school = $schools->byId(new SchoolId($id));
            if (!$school) {
                return $this->json([
                    'error' => 'School not found'
                ], Response::HTTP_NOT_FOUND);
            }

            $payload = json_decode($request->getContent(), true) ?? [];
            if (isset($payload['name'])) {
                $school->rename(new \App\Domain\Shared\ValueObject\Name($payload['name']));
            }
            if (isset($payload['degree'])) {
                $school->changeDegree($payload['degree']);
            }
            $schools->save($school);

            return $this->json([
                'message' => 'School updated successfully',
                'school' => [
                    'id' => $school->id()?->value(),
                    'name' => (string)$school->name(),
                    'degree' => $school->degree()
                ]
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return $this->json([
                'error' => 'Failed to update school',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/schools/{id}', name: 'school_delete', methods: ['DELETE'])]
    public function delete(int $id, DomainSchoolRepository $schools): JsonResponse
    {
        try {
            $school = $schools->byId(new SchoolId($id));
            if (!$school) {
                return $this->json([
                    'error' => 'School not found'
                ], Response::HTTP_NOT_FOUND);
            }

            return $this->json(['error' => 'Deletion not allowed in this example'], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $e) {
            return $this->json([
                'error' => 'Failed to delete school',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
