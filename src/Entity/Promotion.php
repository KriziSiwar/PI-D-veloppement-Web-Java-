<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
class Promotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $QR_code = null;

    #[ORM\Column]
    private ?int $discount = null;

    #[ORM\Column]
    private ?int $id_event = null;

    #[ORM\ManyToOne(inversedBy: 'Promotion')]
    private ?Event $event = null;

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

    public function getQRCode(): ?string
    {
        return $this->QR_code;
    }

    public function setQRCode(string $QR_code): static
    {
        $this->QR_code = $QR_code;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getIdEvent(): ?int
    {
        return $this->id_event;
    }

    public function setIdEvent(int $id_event): static
    {
        $this->id_event = $id_event;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }
}
