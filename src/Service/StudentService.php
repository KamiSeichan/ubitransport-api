<?php

declare(strict_types=1);


namespace App\Service;

use App\Entity\Grade;
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

    /**
     * @param Request $request
     * @param Student $student
     * @return Student
     * @throws \Exception
     */
    public function update(Request $request, Student $student): Student
    {
        $student->setLastname($request->get('lastname'))
            ->setFirstname($request->get('firstname'))
            ->setBirthdayDate(new \DateTimeImmutable($request->get('birthday')));

        return $student;
    }

    /**
     * @param Student $student
     */
    public function delete(Student $student): void
    {
        $this->entityManager->remove($student);
        $this->entityManager->flush();
    }

    /**
     * @param Request $request
     * @param Student $student
     * @return Student
     */
    public function addGrade(Request $request, Student $student): Grade
    {
        $grade = (new Grade())
            ->setSubject($request->get('subject'))
            ->setValue(floatval($request->get('value')))
            ->setStudent($student);

        return $grade;
    }
}
