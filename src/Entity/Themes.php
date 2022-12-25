<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ThemesRepository")
 */
class Themes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reponseDemande;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tickets", mappedBy="themes")
     */
    private $demandeThemes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    public function __construct()
    {
        $this->demandeThemes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getreponseDemande(): ?string
    {
        return $this->reponseDemande;
    }

    public function setreponseDemande(?string $reponseDemande): self
    {
        $this->reponseDemande = $reponseDemande;

        return $this;
    }

    /**
     * @return Collection|Tickets[]
     */
    public function getDemandeThemes(): Collection
    {
        return $this->demandeThemes;
    }

    public function addDemandeTheme(Tickets $demandeTheme): self
    {
        if (!$this->demandeThemes->contains($demandeTheme)) {
            $this->demandeThemes[] = $demandeTheme;
            $demandeTheme->setThemes($this);
        }

        return $this;
    }

    public function removeDemandeTheme(Tickets $demandeTheme): self
    {
        if ($this->demandeThemes->contains($demandeTheme)) {
            $this->demandeThemes->removeElement($demandeTheme);
            // set the owning side to null (unless already changed)
            if ($demandeTheme->getThemes() === $this) {
                $demandeTheme->setThemes(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getTitre();
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
