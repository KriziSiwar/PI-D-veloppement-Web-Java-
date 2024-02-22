<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(length: 255)]
    private string $description;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $start_date;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $end_date;

    #[ORM\Column]
    private int $price=0;

    #[ORM\Column(length: 255)]
    private string $location;

    #[ORM\Column(length: 255)]
    private string $statut;

    #[ORM\Column(length: 255)]
    private string $image="";

    #[ORM\Column]
    private int $nb_participant=0;

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

    public function setEndDate(\DateTimeInterface $end_date): static
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

    public function __toString(): string
    {
        return $this->title;
    }
}
