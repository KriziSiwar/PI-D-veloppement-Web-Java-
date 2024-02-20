<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please provide a title.")]
    #[Assert\Length(max: 255, maxMessage: "Title cannot be longer than {{ limit }} characters.")]
    private string $title;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please provide a description.")]
    #[Assert\Length(max: 255, maxMessage: "Description cannot be longer than {{ limit }} characters.")]
    private string $description;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message: "Please provide a start date.")]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message: "Please provide an end date.")]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: "Please provide a price.")]
    #[Assert\Type(type: 'integer', message: "Price must be a valid number.")]
    #[Assert\PositiveOrZero(message: "Price cannot be negative.")]
    private int $price = 0;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please provide a location.")]
    #[Assert\Length(max: 255, maxMessage: "Location cannot be longer than {{ limit }} characters.")]
    private string $location;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please provide a status.")]
    #[Assert\Length(max: 255, maxMessage: "Status cannot be longer than {{ limit }} characters.")]
    private string $statut;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please provide an image.")]
    #[Assert\Length(max: 255, maxMessage: "Image path cannot be longer than {{ limit }} characters.")]
    private string $image = "";

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: "Please provide the number of participants.")]
    #[Assert\Type(type: 'integer', message: "Number of participants must be a valid number.")]
    #[Assert\PositiveOrZero(message: "Number of participants cannot be negative.")]
    private int $nb_participant = 0;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Promotion::class)]
    private Collection $Promotion;

    public function __construct()
    {
        $this->Promotion = new ArrayCollection();

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }


    public function setStartDate(?\DateTimeInterface $startDate): void
    {
        $this->start_date = $startDate;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

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

    public function getNbParticipant(): ?int
    {
        return $this->nb_participant;
    }

    public function setNbParticipant(int $nb_participant): static
    {
        $this->nb_participant = $nb_participant;

        return $this;
    }

    /**
     * @return Collection<int, Promotion>
     */
    public function getPromotion(): Collection
    {
        return $this->Promotion;
    }

    public function addPromotion(Promotion $promotion): static
    {
        if (!$this->Promotion->contains($promotion)) {
            $this->Promotion->add($promotion);
            $promotion->setEvent($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): static
    {
        if ($this->Promotion->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getEvent() === $this) {
                $promotion->setEvent(null);
            }
        }

        return $this;
    }
}
