<?php

declare(strict_types=1);


namespace App\Controller;

use App\Entity\Student;
use App\Service\StudentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 *  @Route("/students", name="api_student_")
 */
class StudentController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    public EntityManagerInterface $entityManager;

    /**
     * @var StudentService
     */
    public StudentService $studentService;

    /**
     * @var SerializerInterface
     */
    public SerializerInterface $serializer;

    public function __construct(
        StudentService $studentService,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
        $this->studentService = $studentService;
        $this->serializer = $serializer;
    }

    /**
     *
     * @Route(name="collection_get", methods={"GET"})
     * @return JsonResponse
     *
     */
    public function collection(): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize(
                $this->studentService->listStudent(),
                "json",
                ["groups" => ["get_student", "get_grade"]]
            ),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     *
     * @Route(name="item_post", methods={"POST"})
     *
     * @param Request $request
     * @param UrlGeneratorInterface $urlGenerator
     * @return JsonResponse
     */
    public function post(
        Request $request,
        UrlGeneratorInterface $urlGenerator,
        ValidatorInterface $validator
    ): JsonResponse {
        $student = $this->studentService->create($request);

        $errors = $validator->validate($student);

        if ($errors->count() > 0) {
            return new JsonResponse(
                $this->serializer->serialize($errors, 'json'),
                JsonResponse::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        $this->entityManager->persist($student);
        $this->entityManager->flush();

        return new JsonResponse(
            $this->serializer->serialize(
                $this->studentService->create($request),
                "json",
                ["groups" => ["get_student", "get_grade"]]
            ),
            JsonResponse::HTTP_CREATED,
            ["Location" => $urlGenerator->generate("api_student_collection_get")],
            true
        );
    }

    /**
     *
     * @Route("/{id}", name="item_put", methods={"PUT"})
     *
     * @param Student $student
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws \Exception
     */
    public function put(Student $student, Request $request, ValidatorInterface $validator)
    {
        $student = $this->studentService->update($request, $student);

        $errors = $validator->validate($student);

        if ($errors->count() > 0) {
            return new JsonResponse(
                $this->serializer->serialize($errors, 'json'),
                JsonResponse::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        $this->entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
