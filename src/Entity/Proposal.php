<?php

namespace App\Entity;

use App\Repository\ProposalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ProposalRepository::class)]
class Proposal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $client = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\Type(type: 'float')]
    private ?float $budget = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $delai = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    #[Assert\Type(type: '\DateTimeInterface')]
    private ?\DateTimeInterface $date_soummission = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    #[Assert\Type(type: '\DateTimeInterface')]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    #[Assert\Type(type: '\DateTimeInterface')]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\ManyToMany(targetEntity: Freelancer::class, inversedBy: 'proposals')]
    #[Assert\Valid] // Validates each element in the collection
    private Collection $Freelancer;

    #[ORM\ManyToMany(targetEntity: PostedJobs::class, inversedBy: 'proposals')]
    #[Assert\Valid] // Validates each element in the collection
    private Collection $PostedJobs;


    public function __construct()
    {
        $this->Freelancer = new ArrayCollection();
        $this->PostedJobs = new ArrayCollection();
    }



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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): static
    {
        $this->client = $client;

        return $this;
    }



    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDelai(): ?string
    {
        return $this->delai;
    }

    public function setDelai(string $delai): static
    {
        $this->delai = $delai;

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

    public function getDateSoummission(): ?\DateTimeInterface
    {
        return $this->date_soummission;
    }

    public function setDateSoummission(\DateTimeInterface $date_soummission): static
    {
        $this->date_soummission = $date_soummission;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

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

    /**
     * @return Collection<int, PostedJobs>
     */
    public function getPostedJobs(): Collection
    {
        return $this->PostedJobs;
    }

    public function addPostedJob(PostedJobs $postedJob): static
    {
        if (!$this->PostedJobs->contains($postedJob)) {
            $this->PostedJobs->add($postedJob);
        }

        return $this;
    }

    public function removePostedJob(PostedJobs $postedJob): static
    {
        $this->PostedJobs->removeElement($postedJob);

        return $this;
    }
}
