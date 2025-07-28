<?php

namespace App\Entity;

use App\Repository\CavesRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: CavesRepository::class)]
class Caves
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'caves')]
    private ?User $cave = null;

    /**
     * @var Collection<int, CommentairesCaves>
     */
    #[ORM\OneToMany(targetEntity: CommentairesCaves::class, mappedBy: 'cave', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $commentairesCaves;


    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    /**
     * @var Collection<int, CaveBouteille>
     */
    #[ORM\OneToMany(targetEntity: CaveBouteille::class, mappedBy: 'cave')]
    private Collection $caveBouteilles;

    public function __construct()
    {
        $this->commentairesCaves = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
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

    public function getCave(): ?User
    {
        return $this->cave;
    }

    public function setCave(?User $cave): static
    {
        $this->cave = $cave;
        return $this;
    }

    /**
     * @return Collection<int, CommentairesCaves>
     */
    public function getCommentairesCaves(): Collection
    {
        return $this->commentairesCaves;
    }

    public function addCommentairesCave(CommentairesCaves $commentairesCave): static
    {
        if (!$this->commentairesCaves->contains($commentairesCave)) {
            $this->commentairesCaves->add($commentairesCave);
            $commentairesCave->setCave($this);
        }
        return $this;
    }

    public function removeCommentairesCave(CommentairesCaves $commentairesCave): static
    {
        if ($this->commentairesCaves->removeElement($commentairesCave)) {
            if ($commentairesCave->getCave() === $this) {
                $commentairesCave->setCave(null);
            }
        }
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
            $caveBouteille->setCave($this);
        }

        return $this;
    }

    public function removeCaveBouteille(CaveBouteille $caveBouteille): static
    {
        if ($this->caveBouteilles->removeElement($caveBouteille)) {
            // set the owning side to null (unless already changed)
            if ($caveBouteille->getCave() === $this) {
                $caveBouteille->setCave(null);
            }
        }

        return $this;
    }
}