<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GradeRepository::class)
 */
class Grade
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="grades")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false)
     */
    private Student $student;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private string $subject;

    /**
     * @ORM\Column(type="float")
     */
    private float $value;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Student
     */
    public function getStudent(): Student
    {
        return $this->student;
    }

    /**
     * @param Student $student
     * @return $this
     */
    public function setStudent(Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }
}
