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

<<<<<<< HEAD
    //#[ORM\Column(length: 255)]
    //public ?string $title = null;

    #[ORM\Column(length: 255)]
    public ?string $QR_code = null;
=======
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $QR_code = null;
>>>>>>> e7a942a627c11e9012e547f10deb81e0778f5c0c

    #[ORM\Column]
    private ?int $discount = null;

<<<<<<< HEAD
    /*#[ORM\Column]
    private ?int $id_event = null;*/
=======
    #[ORM\Column]
    private ?int $id_event = null;
>>>>>>> e7a942a627c11e9012e547f10deb81e0778f5c0c

    #[ORM\ManyToOne(inversedBy: 'Promotion')]
    private ?Event $event = null;

    public function getId(): ?int
    {
        return $this->id;
    }

<<<<<<< HEAD
   /* public function getTitle(): ?string
=======
    public function getTitle(): ?string
>>>>>>> e7a942a627c11e9012e547f10deb81e0778f5c0c
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
<<<<<<< HEAD
    }*/
=======
    }
>>>>>>> e7a942a627c11e9012e547f10deb81e0778f5c0c

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

<<<<<<< HEAD
   /* public function getIdEvent(): ?int
=======
    public function getIdEvent(): ?int
>>>>>>> e7a942a627c11e9012e547f10deb81e0778f5c0c
    {
        return $this->id_event;
    }

    public function setIdEvent(int $id_event): static
    {
        $this->id_event = $id_event;

        return $this;
    }
<<<<<<< HEAD
*/
=======

>>>>>>> e7a942a627c11e9012e547f10deb81e0778f5c0c
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
