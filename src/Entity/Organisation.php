<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\OrganisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganisationRepository::class)]
class Organisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom est requis ")]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"L'adresse  est requise")]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(pattern:"/^\d{8}$/",message:"Le numéro de téléphone doit contenir 8 chiffres"
        )]
    private ?string $telephone = null;


    #[ORM\Column(type:"string", length:255)]
    #[Assert\NotBlank(message:"L'adresse email est requise")]
    #[Assert\Email(message:"L'adresse email '{{ value }}' n'est pas valide.")]
    
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    
    private ?string $contact = null;

    #[ORM\OneToMany(mappedBy: 'organisation', targetEntity: Contrat::class)]
    private Collection $contrat;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le domaine d'activite est requis")]
    public ?string $domaine_activite = null;

    public function __construct()
    {
        $this->contrat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

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

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection<int, contrat>
     */
    public function getContrat(): Collection
    {
        return $this->contrat;
    }

    public function addContrat(contrat $id): static
    {
        if (!$this->contrat->contains($id)) {
            $this->contrat->add($id);
            $id->setOrganisation($this);
        }

        return $this;
    }

    public function removeContrat(contrat $id): static
    {
        if ($this->contrat->removeElement($id)) {
            // set the owning side to null (unless already changed)
            if ($id->getOrganisation() === $this) {
                $id->setOrganisation(null);
            }
        }

        return $this;
    }

    public function getDomaineActivite(): ?string
    {
        return $this->domaine_activite;
    }

    public function setDomaineActivite(string $domaine_activite): static
    {
        $this->domaine_activite = $domaine_activite;

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }

}
