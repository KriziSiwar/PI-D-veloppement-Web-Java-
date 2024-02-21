<?php

namespace App\Entity;
use App\Entity\AssignedJobs;
use App\Repository\PostedJobsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: PostedJobsRepository::class)]
class PostedJobs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Title cannot be blank.')]
    #[Assert\Length(max: 255, maxMessage: 'Title cannot be longer than 255 characters.')]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Description cannot be blank.')]
    #[Assert\Length(max: 255, maxMessage: 'Description cannot be longer than 255 characters.')]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Required skills cannot be blank.')]
    #[Assert\Length(max: 255, maxMessage: 'Required skills cannot be longer than 255 characters.')]
    private ?string $required_skills = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Budget estimate cannot be blank.')]
    #[Assert\Type(type: 'integer', message: 'Budget estimate must be a valid integer.')]
    private ?int $budget_estimate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'Start date cannot be blank.')]
    #[Assert\Type(type: '\DateTimeInterface', message: 'Start date must be a valid date.')]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'End date cannot be blank.')]
    #[Assert\Type(type: '\DateTimeInterface', message: 'End date must be a valid date.')]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Status cannot be blank.')]
    #[Assert\Length(max: 255, maxMessage: 'Status cannot be longer than {{ limit }} characters.')]
    private ?string $status = null;

    #[ORM\ManyToMany(targetEntity: AssignedJobs::class, mappedBy: 'PostedJobs')]
    private Collection $assignedJobs;

    #[ORM\ManyToMany(targetEntity: Proposal::class, mappedBy: 'PostedJobs')]
    private Collection $proposals;

    public function __construct()
    {
        $this->assignedJobs = new ArrayCollection();
        $this->proposals = new ArrayCollection();
    }
 
    

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getRequiredSkills(): ?string
    {
        return $this->required_skills;
    }

    public function setRequiredSkills(string $required_skills): static
    {
        $this->required_skills = $required_skills;

        return $this;
    }

    public function getBudgetEstimate(): ?int
    {
        return $this->budget_estimate;
    }

    public function setBudgetEstimate(int $budget_estimate): static
    {
        $this->budget_estimate = $budget_estimate;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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
            $assignedJob->addPostedJob($this);
        }

        return $this;
    }

    public function removeAssignedJob(AssignedJobs $assignedJob): static
    {
        if ($this->assignedJobs->removeElement($assignedJob)) {
            $assignedJob->removePostedJob($this);
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
            $proposal->addPostedJob($this);
        }

        return $this;
    }

    public function removeProposal(Proposal $proposal): static
    {
        if ($this->proposals->removeElement($proposal)) {
            $proposal->removePostedJob($this);
        }

        return $this;
    }
     
   

    

    

        
}
