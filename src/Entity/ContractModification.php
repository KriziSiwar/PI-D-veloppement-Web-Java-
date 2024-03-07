<?php

namespace App\Entity;
use App\Entity\Contrat;
use App\Repository\ContractModificationRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractModificationRepository::class)]
class ContractModification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $fieldName = null;

    #[ORM\Column(length: 255)]
    private ?string $oldValue = null;

    #[ORM\Column(length: 255)]
    private ?string $newValue = null;

    #[ORM\Column(type: 'datetime')] // Utilisez le type 'datetime' pour stocker les valeurs de date et d'heure
    private ?\DateTimeInterface $timestamp = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?contrat $contrat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFieldName(): ?string
    {
        return $this->fieldName;
    }

    public function setFieldName(string $fieldName): static
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    public function getOldValue(): ?string
    {
        return $this->oldValue;
    }

    public function setOldValue(string $oldValue): static
    {
        $this->oldValue = $oldValue;

        return $this;
    }

    public function getNewValue(): ?string
    {
        return $this->newValue;
    }

    public function setNewValue(string $newValue): static
    {
        $this->newValue = $newValue;

        return $this;
    }

    /*public function getTimestamp(): ?string
    {
        return $this->timestamp;
    }*/

    public function setTimestamp(DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }

public function getTimestamp(): ?string
{
    // Utiliser la méthode format pour obtenir la date au format de votre choix
    return $this->timestamp instanceof DateTimeInterface ? $this->timestamp->format('Y-m-d H:i:s') : null;
}
    public function getContrat(): ?contrat
    {
        return $this->contrat;
    }

    public function setContrat(?contrat $contrat): static
    {
        $this->contrat = $contrat;

        return $this;
    }
}
