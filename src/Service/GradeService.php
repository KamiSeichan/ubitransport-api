<?php

declare(strict_types=1);


namespace App\Service;

use App\Entity\Grade;
use Doctrine\ORM\EntityManagerInterface;

class GradeService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function classroomAverage(): float
    {
        return round($this->entityManager->getRepository(Grade::class)->averageGrades()['avg'], 2);
    }
}
