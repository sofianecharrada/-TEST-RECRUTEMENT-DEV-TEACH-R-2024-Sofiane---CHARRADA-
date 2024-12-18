<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
#[UniqueEntity('name')]
class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 2, max: 100)]
    private ?string $Description = null;

    #[ORM\Column]
    #[Assert\Positive()]
    #[Assert\LessThan(200)]
    #[Assert\NotNull()]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $creerLe = null;

    #[ORM\ManyToOne(targetEntity: Categories::class)]
    #[ORM\JoinColumn(nullable: false)] // Vous pouvez définir cette colonne comme obligatoire
    private ?Categories $categorie = null;

    public function __construct()
    {
        $this->creerLe = new  DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCreerLe(): ?\DateTimeImmutable
    {
        return $this->creerLe;
    }

    public function setCreerLe(\DateTimeImmutable $creerLe): static
    {
        $this->creerLe = $creerLe;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
        
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
