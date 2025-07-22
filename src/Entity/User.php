<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Caves>
     */
    #[ORM\OneToMany(targetEntity: Caves::class, mappedBy: 'cave')]
    private Collection $caves;

    /**
     * @var Collection<int, NotesCaves>
     */
    #[ORM\OneToMany(targetEntity: NotesCaves::class, mappedBy: 'user')]
    private Collection $notesCaves;

    /**
     * @var Collection<int, NotesBouteilles>
     */
    #[ORM\OneToMany(targetEntity: NotesBouteilles::class, mappedBy: 'user')]
    private Collection $notesBouteilles;

    /**
     * @var Collection<int, CommentairesCaves>
     */
    #[ORM\OneToMany(targetEntity: CommentairesCaves::class, mappedBy: 'User')]
    private Collection $commentairesCaves;

    /**
     * @var Collection<int, CommentairesBouteilles>
     */
    #[ORM\OneToMany(targetEntity: CommentairesBouteilles::class, mappedBy: 'user')]
    private Collection $commentairesBouteilles;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    /**
     * @var Collection<int, Bouteilles>
     */
    #[ORM\OneToMany(targetEntity: Bouteilles::class, mappedBy: 'user')]
    private Collection $bouteilles;

    public function __construct()
    {
        $this->caves = new ArrayCollection();
        $this->notesCaves = new ArrayCollection();
        $this->notesBouteilles = new ArrayCollection();
        $this->commentairesCaves = new ArrayCollection();
        $this->commentairesBouteilles = new ArrayCollection();
        $this->bouteilles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    /**
     * @return Collection<int, Caves>
     */
    public function getCaves(): Collection
    {
        return $this->caves;
    }

    public function addCave(Caves $cave): static
    {
        if (!$this->caves->contains($cave)) {
            $this->caves->add($cave);
            $cave->setCave($this);
        }

        return $this;
    }

    public function removeCave(Caves $cave): static
    {
        if ($this->caves->removeElement($cave)) {
            // set the owning side to null (unless already changed)
            if ($cave->getCave() === $this) {
                $cave->setCave(null);
            }
        }

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
            $notesCave->setUser($this);
        }

        return $this;
    }

    public function removeNotesCave(NotesCaves $notesCave): static
    {
        if ($this->notesCaves->removeElement($notesCave)) {
            // set the owning side to null (unless already changed)
            if ($notesCave->getUser() === $this) {
                $notesCave->setUser(null);
            }
        }

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
            $notesBouteille->setUser($this);
        }

        return $this;
    }

    public function removeNotesBouteille(NotesBouteilles $notesBouteille): static
    {
        if ($this->notesBouteilles->removeElement($notesBouteille)) {
            // set the owning side to null (unless already changed)
            if ($notesBouteille->getUser() === $this) {
                $notesBouteille->setUser(null);
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
            $commentairesCave->setUser($this);
        }

        return $this;
    }

    public function removeCommentairesCave(CommentairesCaves $commentairesCave): static
    {
        if ($this->commentairesCaves->removeElement($commentairesCave)) {
            // set the owning side to null (unless already changed)
            if ($commentairesCave->getUser() === $this) {
                $commentairesCave->setUser(null);
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
            $commentairesBouteille->setUser($this);
        }

        return $this;
    }

    public function removeCommentairesBouteille(CommentairesBouteilles $commentairesBouteille): static
    {
        if ($this->commentairesBouteilles->removeElement($commentairesBouteille)) {
            // set the owning side to null (unless already changed)
            if ($commentairesBouteille->getUser() === $this) {
                $commentairesBouteille->setUser(null);
            }
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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
            $bouteille->setUser($this);
        }

        return $this;
    }

    public function removeBouteille(Bouteilles $bouteille): static
    {
        if ($this->bouteilles->removeElement($bouteille)) {
            // set the owning side to null (unless already changed)
            if ($bouteille->getUser() === $this) {
                $bouteille->setUser(null);
            }
        }

        return $this;
    }
}
