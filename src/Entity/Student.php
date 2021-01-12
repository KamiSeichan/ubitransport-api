<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private string $lastname;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private string $firstname;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $birthdayDate;

    /**
     * @ORM\OneToMany(targetEntity="Grade", mappedBy="student", cascade={"remove"})
     */
    private Collection $grades;

    /**
     * Student constructor.
     */
    public function __construct() {
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
}
