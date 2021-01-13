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
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

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
     * @SWG\Tag(name="Student")
     * @SWG\Response(
     *     response=200,
     *     description="http ok"
     * )
     *
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
     * @SWG\Tag(name="Student")
     * @SWG\Parameter(
     *     name="lastname",
     *     description="Nom du nouvel élève",
     *     in="query",
     *     type="string",
     *     required=true
     *
     * )
     *
     * @SWG\Parameter(
     *     name="firstname",
     *     description="Prénom du nouvel élève",
     *     in="query",
     *     type="string",
     *     required=true
     * )
     *
     * @SWG\Parameter(
     *     name="birthday",
     *     description="Date d'anniversaire au format Y-m-d",
     *     in="query",
     *     type="string"
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="http created"
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Bad request"
     * )
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
     *
     * @SWG\Tag(name="Student")
     * @SWG\Parameter(
     *     name="lastname",
     *     description="Nom à modifier",
     *     in="query",
     *     type="string",
     *
     * )
     *
     * @SWG\Parameter(
     *     name="firstname",
     *     description="Prénom à modifier",
     *     in="query",
     *     type="string",
     *     required=true
     * )
     *
     * @SWG\Parameter(
     *     name="birthday",
     *     description="Date d'anniversaire au format Y-m-d à modifier",
     *     in="query",
     *     type="string"
     * )
     *
     * @SWG\Response(
     *     response=204,
     *     description="no content"
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Bad request"
     * )
     *
     * @param Student $student
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws \Exception
     */
    public function put(Student $student, Request $request, ValidatorInterface $validator): JsonResponse
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

    /**
     *
     * @Route("/{id}", name="item_delete", methods={"DELETE"})
     * @SWG\Tag(name="Student")
     * @SWG\Response(
     *     response=204,
     *     description="no content"
     * )
     * @param Student $student
     * @return JsonResponse
     */
    public function delete(Student $student): JsonResponse
    {
        $this->studentService->delete($student);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     *
     * @Route("/{id}/grade", name="item_student_grade_post", methods={"POST"})
     * @SWG\Tag(name="Student")
     * @SWG\Parameter(
     *     name="subject",
     *     description="Nom de la matière",
     *     in="query",
     *     type="string",
     *     required=true
     *
     * )
     *
     * @SWG\Parameter(
     *     name="value",
     *     description="Note de l'élève",
     *     in="query",
     *     type="number",
     *     required=true
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="http created"
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Bad request"
     * )
     *
     * @return JsonResponse
     */
    public function addGrade(
        Student $student,
        Request $request,
        UrlGeneratorInterface $urlGenerator,
        ValidatorInterface $validator
    ): JsonResponse {
        $grade = $this->studentService->addGrade($request, $student);

        $errors = $validator->validate($grade);

        if ($errors->count() > 0) {
            return new JsonResponse(
                $this->serializer->serialize($errors, 'json'),
                JsonResponse::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        $this->entityManager->persist($grade);
        $this->entityManager->flush();

        return new JsonResponse(
            $this->serializer->serialize(
                $this->studentService->addGrade($request, $student),
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
     * @Route("/{id}/average", name="item_student_average_get", methods={"GET"})
     *
     * @SWG\Tag(name="Student")
     * @SWG\Response(
     *     response=200,
     *     description="http ok"
     * )
     *
     * @return JsonResponse
     */
    public function getAverage(Student $student): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize(
                $student->getAverageGrades(),
                "json",
                ["groups" => "get_student_average"]
            ),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }
}
