<?php

namespace App\Entity;

use App\Repository\CommentairesBouteillesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentairesBouteillesRepository::class)]
class CommentairesBouteilles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentaire = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'commentairesBouteilles')]
    private ?Bouteilles $bouteille = null;

    #[ORM\ManyToOne(inversedBy: 'commentairesBouteilles')]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'reponse')]
    private ?self $reponse = null;

    public function __construct()
    {
        $this->reponse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

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

    public function getReponse(): ?self
    {
        return $this->reponse;
    }

    public function setReponse(?self $reponse): static
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function addReponse(self $reponse): static
    {
        if (!$this->reponse->contains($reponse)) {
            $this->reponse->add($reponse);
            $reponse->setReponse($this);
        }

        return $this;
    }

    public function removeReponse(self $reponse): static
    {
        if ($this->reponse->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getReponse() === $this) {
                $reponse->setReponse(null);
            }
        }

        return $this;
    }
}
