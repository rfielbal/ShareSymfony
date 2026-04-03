<?php

namespace App\Entity;

use App\Repository\FichierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FichierRepository::class)]
class Fichier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fichiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $nomOriginal = null;

    #[ORM\Column(length: 255)]
    private ?string $nomServeur = null;

    #[ORM\Column]
    private ?\DateTime $dateEnvoie = null;

    #[ORM\Column(length: 5)]
    private ?string $extension = null;

    #[ORM\Column]
    private ?int $taille = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getNomOriginal(): ?string
    {
        return $this->nomOriginal;
    }

    public function setNomOriginal(string $nomOriginal): static
    {
        $this->nomOriginal = $nomOriginal;

        return $this;
    }

    public function getNomServeur(): ?string
    {
        return $this->nomServeur;
    }

    public function setNomServeur(string $nomServeur): static
    {
        $this->nomServeur = $nomServeur;

        return $this;
    }

    public function getDateEnvoie(): ?\DateTime
    {
        return $this->dateEnvoie;
    }

    public function setDateEnvoie(\DateTime $dateEnvoie): static
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): static
    {
        $this->taille = $taille;

        return $this;
    }
}
