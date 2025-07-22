<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BouteillesRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[Vich\Uploadable]
#[UniqueEntity(
    fields: ['nom', 'millesime', 'region', 'cepage'],
    message: 'Une bouteille identique existe déjà avec ce nom, millésime, région et cépage.'
)]
#[ORM\Entity(repositoryClass: BouteillesRepository::class)]
#[ORM\Table(name: 'bouteilles')]
#[ORM\UniqueConstraint(name: 'unique_bouteille_combo', columns: ['nom', 'millesime', 'region', 'cepage'])]
class Bouteilles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $region = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $millesime = null;

    #[ORM\Column(length: 255)]
    private ?string $cepage = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: NotesBouteilles::class, mappedBy: 'bouteille')]
    private Collection $notesBouteilles;

    #[ORM\OneToMany(targetEntity: CommentairesBouteilles::class, mappedBy: 'bouteille')]
    private Collection $commentairesBouteilles;

    #[ORM\ManyToMany(targetEntity: Caves::class, mappedBy: 'caves_bouteilles')]
    private Collection $bouteilles_caves;

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;
    
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\ManyToOne(inversedBy: 'bouteilles')]
    private ?User $user = null;

    public function __construct()
    {
        $this->notesBouteilles = new ArrayCollection();
        $this->commentairesBouteilles = new ArrayCollection();
        $this->bouteilles_caves = new ArrayCollection();
    }

    // GETTER SETTER 
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

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    public function getCepage(): ?string
    {
        return $this->cepage;
    }

    public function setCepage(string $cepage): static
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

    /**
     * @return Collection<int, NotesBouteilles>
     */
    public function getNotesBouteilles(): Collection
    {
        return $this->notesBouteilles;
    }

    public function addNotesBouteille(NotesBouteilles $notesBouteille): static
    {
        if (!$this->notesBouteilles->contains($notesBouteille)) {
            $this->notesBouteilles->add($notesBouteille);
            $notesBouteille->setBouteille($this);
        }

        return $this;
    }

    public function removeNotesBouteille(NotesBouteilles $notesBouteille): static
    {
        if ($this->notesBouteilles->removeElement($notesBouteille)) {
            // set the owning side to null (unless already changed)
            if ($notesBouteille->getBouteille() === $this) {
                $notesBouteille->setBouteille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommentairesBouteilles>
     */
    public function getCommentairesBouteilles(): Collection
    {
        return $this->commentairesBouteilles;
    }

    public function addCommentairesBouteille(CommentairesBouteilles $commentairesBouteille): static
    {
        if (!$this->commentairesBouteilles->contains($commentairesBouteille)) {
            $this->commentairesBouteilles->add($commentairesBouteille);
            $commentairesBouteille->setBouteille($this);
        }

        return $this;
    }

    public function removeCommentairesBouteille(CommentairesBouteilles $commentairesBouteille): static
    {
        if ($this->commentairesBouteilles->removeElement($commentairesBouteille)) {
            // set the owning side to null (unless already changed)
            if ($commentairesBouteille->getBouteille() === $this) {
                $commentairesBouteille->setBouteille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Caves>
     */
    public function getBouteillesCaves(): Collection
    {
        return $this->bouteilles_caves;
    }

    public function addBouteillesCave(Caves $bouteillesCave): static
    {
        if (!$this->bouteilles_caves->contains($bouteillesCave)) {
            $this->bouteilles_caves->add($bouteillesCave);
            $bouteillesCave->addCavesBouteille($this);
        }

        return $this;
    }

    public function removeBouteillesCave(Caves $bouteillesCave): static
    {
        if ($this->bouteilles_caves->removeElement($bouteillesCave)) {
            $bouteillesCave->removeCavesBouteille($this);
        }

        return $this;
    }

    //IMAGES
    public function getImageFile(): ?File {

    return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        // Nécessaire pour que Doctrine détecte une modification
        if ($imageFile !== null) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function setImageName(?string $imageName): void {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string {
       return $this->imageName;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
    return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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
