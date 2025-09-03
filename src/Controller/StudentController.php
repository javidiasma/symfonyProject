<?php

namespace App\Controller;

use App\Application\Student\RegisterStudentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class StudentController extends AbstractController
{
    #[Route('/students/register', name: 'student_register', methods: ['POST'])]
    public function register(
        Request $request,
        SerializerInterface $serializer,
        RegisterStudentService $registerStudent
    ): JsonResponse {
        try {
            $payload = json_decode($request->getContent(), true) ?? [];
            $username = $payload['username'] ?? '';
            $phone = $payload['phoneNumber'] ?? null;
            $schoolId = isset($payload['schoolId']) ? (int)$payload['schoolId'] : null;

            $student = $registerStudent->handle($username, $phone, $schoolId);
            
            return $this->json([
                'message' => 'Student registered successfully',
                'student' => [
                    'id' => $student->id()?->value(),
                    'username' => (string)$student->username(),
                    'phoneNumber' => $student->phoneNumber()?->value(),
                    'schoolId' => $student->schoolId()?->value()
                ]
            ], Response::HTTP_CREATED);
            
        } catch (\Throwable $e) {
            return $this->json([
                'error' => 'Failed to register student',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
