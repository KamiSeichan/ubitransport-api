<?php

declare(strict_types=1);


namespace App\DataFixtures\Helpers;

use App\Entity\Student;

class StudentHelpers
{
    /**
     * @param string $lastname
     * @param string $firstname
     * @param \DateTimeImmutable $birthday
     * @return Student
     */
    public function createStudent(string $lastname, string $firstname, \DateTimeImmutable $birthday): Student
    {
        $student = (new Student())
            ->setLastname($lastname)
            ->setFirstname($firstname)
            ->setBirthdayDate($birthday);

        return $student;
    }
}
