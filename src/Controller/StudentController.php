<?php

declare(strict_types=1);


namespace App\Controller;

use App\Service\StudentService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

/**
 *  @Route("/students", name="api_student_")
 */
class StudentController extends AbstractController
{
    /**
     * @var StudentService
     */
    private StudentService $studentService;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(StudentService $studentService, SerializerInterface $serializer)
    {
        $this->studentService = $studentService;
        $this->serializer = $serializer;
    }

    /**
     *
     * @Route(name="api_student_collection_get", methods={"GET"})
     * @return JsonResponse
     *
     */
    public function collection(): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($this->studentService->listStudent(), "json", ["groups" => ["get_student", "get_grade"]]),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }
}