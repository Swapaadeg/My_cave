<?php

namespace App\Entity;

use App\Repository\NotesBouteillesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotesBouteillesRepository::class)]
class NotesBouteilles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $note = null;

    #[ORM\ManyToOne(inversedBy: 'notesBouteilles')]
    private ?Bouteilles $bouteille = null;

    #[ORM\ManyToOne(inversedBy: 'notesBouteilles')]
    private ?User $user = null;

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

    public function getBouteille(): ?Bouteilles
    {
        return $this->bouteille;
    }

    public function setBouteille(?Bouteilles $bouteille): static
    {
        $this->bouteille = $bouteille;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
