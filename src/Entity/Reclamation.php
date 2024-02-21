<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
   #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please enter an object.')]
    #[Assert\Length(max: 255, maxMessage: 'Object cannot be longer than 255 characters.')]
    private ?string $objet = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please enter content.')]
    #[Assert\Length(max: 255, maxMessage: 'Content cannot be longer than 255 characters.')]
    private ?string $contenu = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please enter a status.')]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'Please enter a reclamation date.')]
    private ?\DateTimeInterface $date_reclamation = null;

    #[ORM\ManyToMany(targetEntity: Freelancer::class, inversedBy: 'reclamations')]
    private Collection $Freelancer;

    public function __construct()
    {
        $this->Freelancer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): static
    {
        $this->objet = $objet;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateReclamation(): ?\DateTimeInterface
    {
        return $this->date_reclamation;
    }

    public function setDateReclamation(\DateTimeInterface $date_reclamation): static
    {
        $this->date_reclamation = $date_reclamation;

        return $this;
    }

    /**
     * @return Collection<int, Freelancer>
     */
    public function getFreelancer(): Collection
    {
        return $this->Freelancer;
    }

    public function addFreelancer(Freelancer $freelancer): static
    {
        if (!$this->Freelancer->contains($freelancer)) {
            $this->Freelancer->add($freelancer);
        }

        return $this;
    }

    public function removeFreelancer(Freelancer $freelancer): static
    {
        $this->Freelancer->removeElement($freelancer);

        return $this;
    }
}
