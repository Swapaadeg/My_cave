<?php

namespace App\Entity;

use App\Repository\CaveBouteilleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaveBouteilleRepository::class)]
class CaveBouteille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'caveBouteilles')]
    private ?Caves $cave = null;

    #[ORM\ManyToOne(inversedBy: 'caveBouteilles')]
    private ?Bouteilles $bouteille = null;

    #[ORM\Column]
    private ?int $quantite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCave(): ?Caves
    {
        return $this->cave;
    }

    public function setCave(?Caves $cave): static
    {
        $this->cave = $cave;

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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }
}
