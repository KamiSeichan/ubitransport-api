<?php

declare(strict_types=1);


namespace App\DataFixtures;

use App\DataFixtures\Helpers\StudentHelpers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var StudentHelpers
     */
    private StudentHelpers $studentHelpers;

    public function __construct(StudentHelpers $studentHelpers)
    {
        $this->studentHelpers = $studentHelpers;
    }

    public function load(ObjectManager $objectManager)
    {
        $student1 = $this->studentHelpers->createStudent('name1', 'firstname1', new \DateTimeImmutable('2000-09-01'));
        $student2 = $this->studentHelpers->createStudent('name2', 'firstname2', new \DateTimeImmutable('2000-10-01'));

        $objectManager->persist($student1);
        $objectManager->persist($student2);

        $this->setReference('student1', $student1);
        $this->setReference('student2', $student2);

        $objectManager->flush();
    }

    /**
     * Get the order of this fixture.
     */
    public function getOrder(): int
    {
        return 1;
    }
}
