<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le titre est obligatoire.')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Le titre doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le titre ne peut pas dépasser {{ limit }} caractères.'
    )]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]

    private ?string $synopsis = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'La durée est obligatoire.')]
    #[Assert\Positive(message: 'La durée doit être strictement positive.')]
    private ?int $duree = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date de sortie est obligatoire.')]
    private ?\DateTime $dateSortie = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'La note est obligatoire.')]
    #[Assert\Range(
        min: 0,
        max: 10,
        notInRangeMessage: 'La note doit être comprise entre {{ min }} et {{ max }}.'
    )]
    private ?float $notePresse = null;

    #[ORM\Column(length: 255)]
    #[Assert\Url(message: 'L\'URL de l\'affiche n\'est pas valide.', requireTld: true)]
    #[Assert\Length(max: 255)]
    private ?string $affiche = null;

    #[ORM\ManyToOne(inversedBy: 'no')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateSortie(): ?\DateTime
    {
        return $this->dateSortie;
    }

    public function setDateSortie(\DateTime $dateSortie): static
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getNotePresse(): ?int
    {
        return $this->notePresse;
    }

    public function setNotePresse(int $notePresse): static
    {
        $this->notePresse = $notePresse;

        return $this;
    }

    public function getAffiche(): ?string
    {
        return $this->affiche;
    }

    public function setAffiche(string $affiche): static
    {
        $this->affiche = $affiche;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
