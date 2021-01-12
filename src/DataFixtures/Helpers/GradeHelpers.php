<?php

declare(strict_types=1);


namespace App\DataFixtures\Helpers;


use App\Entity\Grade;
use App\Entity\Student;

class GradeHelpers
{
    /**
     * @param Student $student
     * @param string $subject
     * @param float $value
     * @return Grade
     */
    public function createGrade(Student $student, string $subject, float $value): Grade
    {
        $grade = (new Grade())
            ->setStudent($student)
            ->setSubject($subject)
            ->setValue($value);

        return $grade;
    }
}