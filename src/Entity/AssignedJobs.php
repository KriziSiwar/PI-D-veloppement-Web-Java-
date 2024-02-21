<?php

namespace App\Entity;

use App\Repository\AssignedJobsRepository;
use App\Repository\PostedJobsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\PostedJobs;
#[ORM\Entity(repositoryClass: AssignedJobsRepository::class)]
class AssignedJobs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $status = null;

 

    #[ORM\ManyToMany(targetEntity: PostedJobs::class, inversedBy: 'assignedJobs')]
    private Collection $PostedJobs;

    #[ORM\ManyToMany(targetEntity: Freelancer::class, inversedBy: 'assignedJobs')]
    private Collection $Freelancer;

    public function __construct()
    {
        
        $this->PostedJobs = new ArrayCollection();
        $this->Freelancer = new ArrayCollection();
    }

   
   

    

    

 


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Freelancer>
     */
    public function getFreelancerId(): Collection
    {
        return $this->Freelancer;
    }

    public function addFreelancerId(Freelancer $freelancer): static
    {
        if (!$this->Freelancer->contains($freelancer)) {
            $this->Freelancer->add($freelancer);
        }

        return $this;
    }

    public function removeFreelancerId(Freelancer $freelancer): static
    {
        $this->Freelancer->removeElement($freelancer);

        return $this;
    }

    

    
}
