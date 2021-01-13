<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_student"})
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank
     * @Assert\Length(min=2)
     * @Groups({"get_student"})
     */
    private string $lastname;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank
     * @Assert\Length(min=2)
     * @Groups({"get_student"})
     */
    private string $firstname;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     * @Groups({"get_student"})
     */
    private ?\DateTimeImmutable $birthdayDate;

    /**
     * @ORM\OneToMany(targetEntity="Grade", mappedBy="student", cascade={"remove"})
     * @Groups({"get_student"})
     */
    private Collection $grades;
    /**
     * @var float
     * @Groups({"get_student_average"})
     */
    private float $averageGrade = 0.0;



    /**
     * @return ArrayCollection|Collection
     */
    public function getGrades()
    {
        return $this->grades;
    }

    /**
     * @param ArrayCollection|Collection $grades
     */
    public function setGrades($grades): void
    {
        $this->grades = $grades;
    }

    /**
     * Student constructor.
     */
    public function __construct()
    {
        $this->grades = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return $this
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return $this
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getBirthdayDate(): ?\DateTimeImmutable
    {
        return $this->birthdayDate;
    }

    /**
     * @param \DateTimeImmutable|null $birthdayDate
     * @return $this
     */
    public function setBirthdayDate(?\DateTimeImmutable $birthdayDate): self
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }

    public function getAverageGrades(): float
    {
        $count = 0;
        $totalValues = 0.0;
        foreach ($this->getGrades() as $grade) {
            ++$count;
            $totalValues += $grade->getValue();
        }
        if ($count > 0) {
            $this->averageGrade = $totalValues / $count;
        }

        return $this->averageGrade;
    }
}
