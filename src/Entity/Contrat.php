<?php

namespace App\Entity;
use App\Entity\User;
use App\Entity\Organisation;
use App\Repository\ContratRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ContratRepository::class)]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   #[ORM\Column(type: Types::DATE_MUTABLE)]
#[Assert\NotBlank(message:"La date de début est requise")]
public ?\DateTimeInterface $date_debut;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"La date de fin est requise")]
    #[Assert\GreaterThan(propertyPath:"date_debut", message:"La date de fin doit être après la date de début")]
    public ?\DateTimeInterface $date_fin;

  
    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThan(value: 15, message: "Le montant doit être supérieur à 15")]
    private ?int $montant;

   
   
   

    #[ORM\Column(type: "string",length:255)]
    #[Assert\NotBlank(message:"Le statut est requis")]
    private ?string $statut;
    
  
    #[ORM\Column(type: "string",length:255)]
    #[Assert\NotBlank(message:"Le projet est requis ")]
    private ?string $projet;

    
    #[ORM\Column(type: "string",length:255)]
    #[Assert\NotBlank(message:"le nom du freelancer est requis  ")]
    #[Assert\Regex("/^[a-zA-Z]+$/", message:"Le nom du freelancer ne doit contenir que des lettres de l'alphabet")]
    private $freelancer;

    #[ORM\ManyToOne(inversedBy: 'contrat')]
    public ?Organisation $organisation = null;

      
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTimeInterface $date_creation = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

     #[ORM\ManyToOne(inversedBy: 'user')]
     public ?User $user = null;
       

    #[ORM\OneToMany(mappedBy: 'no', targetEntity: AssignedJobs::class)]
    private Collection $assigned_Jobs;

    #[ORM\ManyToMany(targetEntity: PostedJobs::class)]
    private Collection $posted_jobs_id;

    public function __construct()
    {
        $this->assigned_Jobs = new ArrayCollection();
        $this->posted_jobs_id = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

   /* public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }
*/



    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

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

    public function getProjet(): ?string
    {
        return $this->projet;
    }

    public function setProjet(string $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    public function getFreelancer(): ?string
    {
        return $this->freelancer;
    }

    public function setFreelancer(string $freelancer): static
    {
        $this->freelancer = $freelancer;

        return $this;
    }

    public function getOrganisation(): ?Organisation
    {
        return $this->organisation;
    }

    public function setOrganisation(?Organisation $id): static
    {
        $this->organisation = $id;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(): self
    {
        $this->date_creation = new \DateTime();

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

    public function getUserId(): ?User


    {
        return $this->user

        ;
    }

    public function setUserId(?User $id): static
    {
        $this->user = $id;

        return $this;
    }

    /**
     * @return Collection<int, AssignedJobs>
     */
    public function getAssignedJobs(): Collection
    {
        return $this->assigned_Jobs;
    }

    public function addAssignedJob(AssignedJobs $assignedJob): static
    {
        if (!$this->assigned_Jobs->contains($assignedJob)) {
            $this->assigned_Jobs->add($assignedJob);
            $assignedJob->setNo($this);
        }

        return $this;
    }

    public function removeAssignedJob(AssignedJobs $assignedJob): static
    {
        if ($this->assigned_Jobs->removeElement($assignedJob)) {
            // set the owning side to null (unless already changed)
            if ($assignedJob->getNo() === $this) {
                $assignedJob->setNo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PostedJobs>
     */
    public function getPostedJobsId(): Collection
    {
        return $this->posted_jobs_id;
    }

    public function addPostedJobsId(PostedJobs $postedJobsId): static
    {
        if (!$this->posted_jobs_id->contains($postedJobsId)) {
            $this->posted_jobs_id->add($postedJobsId);
        }

        return $this;
    }

    public function removePostedJobsId(PostedJobs $postedJobsId): static
    {
        $this->posted_jobs_id->removeElement($postedJobsId);

        return $this;
    }


public function __toString()
{
    return $this->getOrganisation();
}
}
