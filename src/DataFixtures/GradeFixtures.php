<?php

declare(strict_types=1);


namespace App\DataFixtures;


use App\DataFixtures\Helpers\GradeHelpers;
use App\DataFixtures\Helpers\StudentHelpers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GradeFixtures extends Fixture implements OrderedFixtureInterface
{
    private $studentHelpers;

    private $gradeHelpers;

    public const GRADE_1 = 10;

    public const GRADE_2 = 2;

    public const GRADE_3 = 11;

    public const GRADE_4 = 18;

    public function __construct(StudentHelpers $studentHelpers, GradeHelpers $gradeHelpers)
    {
        $this->studentHelpers = $studentHelpers;
        $this->gradeHelpers = $gradeHelpers;
    }

    public function load(ObjectManager $objectManager)
    {

        $student1 = $this->getReference('student1');
        $student2 = $this->getReference('student2');

        $objectManager->persist($this->gradeHelpers->createGrade($student1, 'histoire', self::GRADE_1));
        $objectManager->persist($this->gradeHelpers->createGrade($student1, 'math', self::GRADE_2));
        $objectManager->persist($this->gradeHelpers->createGrade($student2, 'geo', self::GRADE_3));
        $objectManager->persist($this->gradeHelpers->createGrade($student2, 'français', self::GRADE_4));

        $objectManager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}