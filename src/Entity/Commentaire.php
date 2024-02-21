<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'The author cannot be blank.')]
    private ?string $auteur = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'The comment cannot be blank.')]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'The publication date cannot be blank.')]
    private ?\DateTimeInterface $date_publication = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'The note cannot be null.')]
    #[Assert\Range(
        min: 1,
        max: 5,
        notInRangeMessage: 'The note must be between {{ min }} and {{ max }}.',
    )]
    private ?int $note = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
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

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    public function setDatePublication(\DateTimeInterface $date_publication): static
    {
        $this->date_publication = $date_publication;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }
}
