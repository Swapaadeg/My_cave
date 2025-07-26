<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Bouteilles>
     */
    #[ORM\OneToMany(targetEntity: Bouteilles::class, mappedBy: 'region')]
    private Collection $bouteilles;

    #[ORM\ManyToOne(inversedBy: 'region')]
    private ?Pays $pays = null;

    public function __construct()
    {
        $this->bouteilles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Bouteilles>
     */
    public function getBouteilles(): Collection
    {
        return $this->bouteilles;
    }

    public function addBouteille(Bouteilles $bouteille): static
    {
        if (!$this->bouteilles->contains($bouteille)) {
            $this->bouteilles->add($bouteille);
            $bouteille->setRegion($this);
        }

        return $this;
    }

    public function removeBouteille(Bouteilles $bouteille): static
    {
        if ($this->bouteilles->removeElement($bouteille)) {
            // set the owning side to null (unless already changed)
            if ($bouteille->getRegion() === $this) {
                $bouteille->setRegion(null);
            }
        }

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): static
    {
        $this->pays = $pays;

        return $this;
    }
}
