<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: EventRepository::class)]



class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $description = null;


    #[Assert\NotBlank]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTimeInterface $start_date_time = null;


    #[Assert\NotBlank]
    #[Assert\GreaterThan(propertyPath: "start_date_time")]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTimeInterface $end_date_time = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[Assert\NotBlank]
    #[Assert\Range(min: 20, max: 100)]
    #[ORM\Column]
    public ?int $number_participants = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: 'La catégorie doit contenir uniquement des lettres.'
    )]
    #[ORM\Column(length: 255)]
    private ?string $category = null;

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

    public function getStartDateTime(): ?\DateTimeInterface
    {
        return $this->start_date_time;
    }

    public function setStartDateTime(\DateTimeInterface $start_date_time): static
    {
        $this->start_date_time = $start_date_time;

        return $this;
    }

    public function getEndDateTime(): ?\DateTimeInterface
    {
        return $this->end_date_time;
    }

    public function setEndDateTime(\DateTimeInterface $end_date_time): static
    {
        $this->end_date_time = $end_date_time;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getNumberParticipants(): ?int
    {
        return $this->number_participants;
    }

    public function setNumberParticipants(int $number_participants): static
    {
        $this->number_participants = $number_participants;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }
}
