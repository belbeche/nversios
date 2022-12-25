<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketsRepository")
 */
class Tickets
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, max="255", minMessage="Votre titre est trop court")
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=40, max="255", minMessage="Merci de renseigner plus de précissions")
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url()
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Themes", inversedBy="demandeThemes",cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $themes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="UsersTickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReponseDemande", mappedBy="ticket")
     */
    private $ticketAnswer;

    public function __construct()
    {
        $this->getTicketAnswer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getThemes(): ?Themes
    {
        return $this->themes;
    }

    public function setThemes(?Themes $themes): self
    {
        $this->themes = $themes;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getUsersId(): ?Utilisateur
    {
        return $this->users_id;
    }

    public function setUsersId(?Utilisateur $users_id): self
    {
        $this->users_id = $users_id;

        return $this;
    }

    /**
     * @return Collection|ReponseDemande[]
     */
    public function getTicketAnswer(): Collection
    {
        return $this->ticketAnswer;
    }

    public function addTicketAnswer(ReponseDemande $ticketAnswer): self
    {
        if (!$this->ticketAnswer->contains($ticketAnswer)) {
            $this->ticketAnswer[] = $ticketAnswer;
            $ticketAnswer->setTicket($this);
        }

        return $this;
    }

    public function removeTicketAnswer(ReponseDemande $ticketAnswer): self
    {
        if ($this->ticketAnswer->contains($ticketAnswer)) {
            $this->ticketAnswer->removeElement($ticketAnswer);
            // set the owning side to null (unless already changed)
            if ($ticketAnswer->ticket() === $this) {
                $ticketAnswer->setTicket(null);
            }
        }

        return $this;
    }
}
