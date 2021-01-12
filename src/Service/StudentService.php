<?php

declare(strict_types=1);


namespace App\Service;


use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;

class StudentService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * StudentService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function listStudent(): array
    {
        return $this->entityManager->getRepository(Student::class)->findAll();
    }
}