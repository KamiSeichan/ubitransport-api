<?php

declare(strict_types=1);


namespace App\Service;

use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @param Request $request
     * @return Student
     * @throws \Exception
     */
    public function create(Request $request): Student
    {
        $student = (new Student())
            ->setLastname($request->get('lastname'))
            ->setFirstname($request->get('firstname'))
            ->setBirthdayDate(new \DateTimeImmutable($request->get('birthday')));

        return $student;
    }

    public function update(Request $request, Student $student): Student
    {
        $student->setLastname($request->get('lastname'))
            ->setFirstname($request->get('firstname'))
            ->setBirthdayDate(new \DateTimeImmutable($request->get('birthday')));

        return $student;
    }
}
