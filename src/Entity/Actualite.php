<?php

namespace App\Entity;

use App\Repository\ActualiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActualiteRepository::class)]
class Actualite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Title cannot be blank.')]
    #[Assert\Length(max: 255, maxMessage: 'Title cannot be longer than 255 characters.')]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'Publication date cannot be blank.')]
    private ?\DateTimeInterface $date_publication = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Description cannot be blank.')]
    #[Assert\Length(max: 255, maxMessage: 'Description cannot be longer than 255 characters.')]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Category cannot be blank.')]
    #[Assert\Length(max: 255, maxMessage: 'Category cannot be longer than 255 characters.')]
    private ?string $categorie = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Image path cannot be blank.')]
    #[Assert\Length(max: 255, maxMessage: 'Image path cannot be longer than 255 characters.')]
    private ?string $image = null;

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

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    public function setDatePublication(\DateTimeInterface $date_publication): static
    {
        $this->date_publication = $date_publication;

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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
