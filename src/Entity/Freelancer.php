<?php

namespace App\Entity;

use App\Repository\FreelancerRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: FreelancerRepository::class)]
class Freelancer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToMany(targetEntity: AssignedJobs::class, mappedBy: 'Freelancer')]
    private Collection $assignedJobs;

    #[ORM\ManyToMany(targetEntity: Proposal::class, mappedBy: 'Freelancer')]
    private Collection $proposals;

    #[ORM\ManyToMany(targetEntity: Reclamation::class, mappedBy: 'Freelancer')]
    private Collection $reclamations;

    public function __construct()
    {
        $this->assignedJobs = new ArrayCollection();
        $this->proposals = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
    }

   
   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
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
     * @return Collection<int, AssignedJobs>
     */
    public function getAssignedJobs(): Collection
    {
        return $this->assignedJobs;
    }

    public function addAssignedJob(AssignedJobs $assignedJob): static
    {
        if (!$this->assignedJobs->contains($assignedJob)) {
            $this->assignedJobs->add($assignedJob);
            $assignedJob->addFreelancer($this);
        }

        return $this;
    }

    public function removeAssignedJob(AssignedJobs $assignedJob): static
    {
        if ($this->assignedJobs->removeElement($assignedJob)) {
            $assignedJob->removeFreelancer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Proposal>
     */
    public function getProposals(): Collection
    {
        return $this->proposals;
    }

    public function addProposal(Proposal $proposal): static
    {
        if (!$this->proposals->contains($proposal)) {
            $this->proposals->add($proposal);
            $proposal->addFreelancer($this);
        }

        return $this;
    }

    public function removeProposal(Proposal $proposal): static
    {
        if ($this->proposals->removeElement($proposal)) {
            $proposal->removeFreelancer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): static
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->addFreelancer($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): static
    {
        if ($this->reclamations->removeElement($reclamation)) {
            $reclamation->removeFreelancer($this);
        }

        return $this;
    }

    

   

  

    






  

   
}
