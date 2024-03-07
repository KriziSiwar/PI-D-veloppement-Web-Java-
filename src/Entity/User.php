<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert; // Add this line



#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Assert\NotBlank(message: "Email is required.")]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]

    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $FirstName = null;

    #[ORM\Column(length: 255)]
    private ?string $LastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ProfilePicture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $JobTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ProfessionalOverview = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Expertise = null;

    #[ORM\Column(nullable: true)]
    private ?int $Phone = null;

    #[ORM\Column(nullable: true)]
    private ?int $rate = null;

    #[ORM\Column(nullable: true)]
    private ?array $language = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $CompanyName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $CompanyDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $industry = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyWebsite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyLogo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reset_token = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $LastLogin = null;

    #[ORM\Column(nullable: true)]
    private ?array $friendsList = null;



    public function __construct()
    {
        $this->friendsList = [];
    }
  

    // User.php

            public function isFriend(User $friend): bool
            {
                return in_array($friend->getId(), $this->friendsList, true);
            }
            public function getFriendsList(): ?array
{
    return $this->friendsList;
}


            public function addFriendToList(User $friend): self
    {
        if (!in_array($friend->getId(), $this->friendsList, true)) {
            $this->friendsList[] = $friend->getId();
        }
        return $this;
    }

    public function removeFriendFromList(User $friend): self
    {
        $key = array_search($friend->getId(), $this->friendsList, true);
        if ($key !== false) {
            unset($this->friendsList[$key]);
        }

        return $this;
    }



    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    // Ajoutez une méthode setter pour définir le jeton de réinitialisation
    public function setResetToken(?string $resetToken): self
    {
        $this->reset_token = $resetToken;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): static
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->ProfilePicture;
    }

    public function setProfilePicture(?string $ProfilePicture): static
    {
        $this->ProfilePicture = $ProfilePicture;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->JobTitle;
    }

    public function setJobTitle(?string $JobTitle): static
    {
        $this->JobTitle = $JobTitle;

        return $this;
    }

    public function getProfessionalOverview(): ?string
    {
        return $this->ProfessionalOverview;
    }

    public function setProfessionalOverview(?string $ProfessionalOverview): static
    {
        $this->ProfessionalOverview = $ProfessionalOverview;

        return $this;
    }

    public function getExpertise(): ?string
    {
        return $this->Expertise;
    }

    public function setExpertise(?string $Expertise): static
    {
        $this->Expertise = $Expertise;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->Phone;
    }

    public function setPhone(?int $Phone): static
    {
        $this->Phone = $Phone;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getLanguage(): ?array
    {
        return $this->language;
    }

    public function setLanguage(?array $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->CompanyName;
    }

    public function setCompanyName(?string $CompanyName): static
    {
        $this->CompanyName = $CompanyName;

        return $this;
    }

    public function getCompanyDescription(): ?string
    {
        return $this->CompanyDescription;
    }

    public function setCompanyDescription(?string $CompanyDescription): static
    {
        $this->CompanyDescription = $CompanyDescription;

        return $this;
    }

    public function getIndustry(): ?string
    {
        return $this->industry;
    }

    public function setIndustry(?string $industry): static
    {
        $this->industry = $industry;

        return $this;
    }
    public function __toString()
    {
        // Choose a property that represents the User object
        return $this->FirstName;
    }
    public function getCompanyWebsite(): ?string
    {
        return $this->companyWebsite;
    }

    public function setCompanyWebsite(?string $companyWebsite): static
    {
        $this->companyWebsite = $companyWebsite;

        return $this;
    }

    public function getCompanyLogo(): ?string
    {
        return $this->companyLogo;
    }

    public function setCompanyLogo(?string $companyLogo): static
    {
        $this->companyLogo = $companyLogo;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->LastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $LastLogin): static
    {
        $this->LastLogin = $LastLogin;

        return $this;
    }



    public function setFriendsList(?array $friendsList): static
    {
        $this->friendsList = $friendsList;

        return $this;
    }
}
