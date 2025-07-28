<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BouteillesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: BouteillesRepository::class)]
#[ORM\Table(name: 'bouteilles')]
class Bouteilles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $millesime = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;


    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\ManyToOne(inversedBy: 'bouteilles')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'bouteilles')]
    #[ORM\JoinColumn(name: 'cepage_id', referencedColumnName: 'id', nullable: true)]
    private ?Cepage $cepage = null;

    #[ORM\ManyToOne(inversedBy: 'bouteilles')]
    #[ORM\JoinColumn(name: 'type_id', referencedColumnName: 'id')]
    private ?Type $type = null;

    #[ORM\ManyToOne(inversedBy: 'bouteilles')]
    #[ORM\JoinColumn(name: 'pays_id', referencedColumnName: 'id')]
    private ?Pays $pays = null;

    #[ORM\ManyToOne(inversedBy: 'bouteilles')]
    #[ORM\JoinColumn(name: 'region_id', referencedColumnName: 'id', nullable: true)]
    private ?Region $region = null;

    /**
     * @var Collection<int, CaveBouteille>
     */
    #[ORM\OneToMany(targetEntity: CaveBouteille::class, mappedBy: 'bouteille')]
    private Collection $caveBouteilles;

    public function __construct()
    {
        $this->caveBouteilles = new ArrayCollection();
    }

    // Getters et setters

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

    public function getMillesime(): ?int
    {
        return $this->millesime;
    }

    public function setMillesime(int $millesime): static
    {
        $this->millesime = $millesime;
        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;
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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): static
    {
        $this->region = $region;
        return $this;
    }

    public function getCepage(): ?Cepage
    {
        return $this->cepage;
    }

    public function setCepage(?Cepage $cepage): static
    {
        $this->cepage = $cepage;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }


    // Gestion des images
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): static
    {
        $this->imageFile = $imageFile;
        if ($imageFile !== null) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;
        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
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

    /**
     * @return Collection<int, CaveBouteille>
     */
    public function getCaveBouteilles(): Collection
    {
        return $this->caveBouteilles;
    }

    public function addCaveBouteille(CaveBouteille $caveBouteille): static
    {
        if (!$this->caveBouteilles->contains($caveBouteille)) {
            $this->caveBouteilles->add($caveBouteille);
            $caveBouteille->setBouteille($this);
        }

        return $this;
    }

    public function removeCaveBouteille(CaveBouteille $caveBouteille): static
    {
        if ($this->caveBouteilles->removeElement($caveBouteille)) {
            // set the owning side to null (unless already changed)
            if ($caveBouteille->getBouteille() === $this) {
                $caveBouteille->setBouteille(null);
            }
        }

        return $this;
    }
}