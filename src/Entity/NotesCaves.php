<?php

namespace App\Entity;

use App\Repository\NotesCavesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotesCavesRepository::class)]
class NotesCaves
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $note = null;

    #[ORM\ManyToOne(inversedBy: 'notesCaves')]
    private ?caves $cave = null;

    #[ORM\ManyToOne(inversedBy: 'notesCaves')]
    private ?user $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getCave(): ?caves
    {
        return $this->cave;
    }

    public function setCave(?caves $cave): static
    {
        $this->cave = $cave;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }
}
