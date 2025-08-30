<?php

namespace App\Controller;

use App\Entity\Student;
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
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ): JsonResponse {
        try {
            // Deserialize the request content to Student entity
            $student = $serializer->deserialize($request->getContent(), Student::class, 'json');
            
            // Validate the entity
            $violations = $validator->validate($student);
            if (count($violations) > 0) {
                $errors = [];
                foreach ($violations as $violation) {
                    $errors[$violation->getPropertyPath()] = $violation->getMessage();
                }
                
                return $this->json([
                    'error' => 'Validation failed',
                    'details' => $errors
                ], Response::HTTP_BAD_REQUEST);
            }
            
            // Persist the student
            $entityManager->persist($student);
            $entityManager->flush();
            
            return $this->json([
                'message' => 'Student registered successfully',
                'student' => [
                    'id' => $student->getId(),
                    'username' => $student->getUsername(),
                    'phoneNumber' => $student->getPhoneNumber()
                ]
            ], Response::HTTP_CREATED);
            
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Failed to register student',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
