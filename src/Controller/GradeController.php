<?php

declare(strict_types=1);


namespace App\Controller;

use App\Service\GradeService;
use App\Service\StudentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 *  @Route("/grades", name="api_grades_")
 */
class GradeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    public EntityManagerInterface $entityManager;

    /**
     * @var StudentService
     */
    public GradeService $gradeService;

    /**
     * @var SerializerInterface
     */
    public SerializerInterface $serializer;

    public function __construct(
        GradeService $gradeService,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
        $this->gradeService = $gradeService;
        $this->serializer = $serializer;
    }

    /**
     *
     * @Route("/average", name="average_get", methods={"GET"})
     * @return JsonResponse
     *
     */
    public function classRoomAverage(): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize(
                $this->gradeService->classroomAverage(),
                "json",
                []
            ),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }
}
