<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaysRepository::class)]
class Pays
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
    #[ORM\OneToMany(targetEntity: Bouteilles::class, mappedBy: 'pays')]
    private Collection $bouteilles;

    /**
     * @var Collection<int, region>
     */
    #[ORM\OneToMany(targetEntity: region::class, mappedBy: 'pays')]
    private Collection $region;

    public function __construct()
    {
        $this->bouteilles = new ArrayCollection();
        $this->region = new ArrayCollection();
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
            $bouteille->setPays($this);
        }

        return $this;
    }

    public function removeBouteille(Bouteilles $bouteille): static
    {
        if ($this->bouteilles->removeElement($bouteille)) {
            // set the owning side to null (unless already changed)
            if ($bouteille->getPays() === $this) {
                $bouteille->setPays(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, region>
     */
    public function getRegion(): Collection
    {
        return $this->region;
    }

    public function addRegion(region $region): static
    {
        if (!$this->region->contains($region)) {
            $this->region->add($region);
            $region->setPays($this);
        }

        return $this;
    }

    public function removeRegion(region $region): static
    {
        if ($this->region->removeElement($region)) {
            // set the owning side to null (unless already changed)
            if ($region->getPays() === $this) {
                $region->setPays(null);
            }
        }

        return $this;
    }
}
