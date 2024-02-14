<?php

namespace App\Entity;

use App\Repository\ContratRepository;
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

    

    public function getId(): ?int
    {
        return $this->id;
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

   /* public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }
*/
    public function setDateFin(\DateTimeInterface $date_fin): static
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
}
