<?php

namespace App\Entity;

use App\Repository\CavesRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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
    private ?user $cave = null;

    /**
     * @var Collection<int, NotesCaves>
     */
    #[ORM\OneToMany(targetEntity: NotesCaves::class, mappedBy: 'cave')]
    private Collection $notesCaves;

    /**
     * @var Collection<int, CommentairesCaves>
     */
    #[ORM\OneToMany(targetEntity: CommentairesCaves::class, mappedBy: 'cave')]
    private Collection $commentairesCaves;

    /**
     * @var Collection<int, Bouteilles>
     */
    #[ORM\ManyToMany(targetEntity: Bouteilles::class, inversedBy: 'bouteilles_caves')]
    private Collection $caves_bouteilles;

    //UPLOAD DES IMAGES
    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;
    
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    public function __construct()
    {
        $this->notesCaves = new ArrayCollection();
        $this->commentairesCaves = new ArrayCollection();
        $this->caves_bouteilles = new ArrayCollection();
    }


    //GETTER SETTER
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

    public function getCave(): ?user
    {
        return $this->cave;
    }

    public function setCave(?user $cave): static
    {
        $this->cave = $cave;

        return $this;
    }

    /**
     * @return Collection<int, NotesCaves>
     */
    public function getNotesCaves(): Collection
    {
        return $this->notesCaves;
    }

    public function addNotesCave(NotesCaves $notesCave): static
    {
        if (!$this->notesCaves->contains($notesCave)) {
            $this->notesCaves->add($notesCave);
            $notesCave->setCave($this);
        }

        return $this;
    }

    public function removeNotesCave(NotesCaves $notesCave): static
    {
        if ($this->notesCaves->removeElement($notesCave)) {
            // set the owning side to null (unless already changed)
            if ($notesCave->getCave() === $this) {
                $notesCave->setCave(null);
            }
        }

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
            // set the owning side to null (unless already changed)
            if ($commentairesCave->getCave() === $this) {
                $commentairesCave->setCave(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bouteilles>
     */
    public function getCavesBouteilles(): Collection
    {
        return $this->caves_bouteilles;
    }

    public function addCavesBouteille(Bouteilles $cavesBouteille): static
    {
        if (!$this->caves_bouteilles->contains($cavesBouteille)) {
            $this->caves_bouteilles->add($cavesBouteille);
        }

        return $this;
    }

    public function removeCavesBouteille(Bouteilles $cavesBouteille): static
    {
        $this->caves_bouteilles->removeElement($cavesBouteille);

        return $this;
    }

        //IMAGES
    public function getImageFile(): ?File {

    return $this->imageFile;
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
}
