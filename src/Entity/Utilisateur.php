<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(
 *    fields = {"email"},
 *    message = "L'email vous avez indiqué est déjà utilisé"
 * )
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;
    /**
     * @Assert\EqualTo(propertyPath="password", message="vous n'avez pas tapé le même mot de passe")
     * */
    private $confirm_password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tickets", mappedBy="users_id")
     */
    private $UsersTickets;

    public function __construct()
    {
        $this->UsersTickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }

    /**
     * @return Collection|Tickets[]
     */
    public function getUsersTickets(): Collection
    {
        return $this->UsersTickets;
    }

    public function addUsersTicket(Tickets $usersTicket): self
    {
        if (!$this->UsersTickets->contains($usersTicket)) {
            $this->UsersTickets[] = $usersTicket;
            $usersTicket->setUsersId($this);
        }

        return $this;
    }

    public function removeUsersTicket(Tickets $usersTicket): self
    {
        if ($this->UsersTickets->contains($usersTicket)) {
            $this->UsersTickets->removeElement($usersTicket);
            // set the owning side to null (unless already changed)
            if ($usersTicket->getUsersId() === $this) {
                $usersTicket->setUsersId(null);
            }
        }

        return $this;
    }
    public function getRoles(){
        return ['ROLE_USER'];
    }
    public function getSalt(){}
    public function eraseCredentials(){}
}
