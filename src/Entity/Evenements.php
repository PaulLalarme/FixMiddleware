<?php

namespace App\Entity;

use App\Repository\EvenementsRepository;
use App\Entity\Category;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementsRepository::class)]
class Evenements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

   #[ORM\ManyToOne(targetEntity: Departements::class)]
    #[ORM\JoinColumn(nullable: true)] 
    private ?Departements $location = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    private ?Category $category = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $time = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $access = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $restauration = null;

    #[ORM\Column(nullable: true)]
    private ?string $accessibility = null;

    #[ORM\Column(nullable: true)]
    private ?int $minimumage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getLocation(): ?Departements
    {
        return $this->location;
    }

     public function setLocation(?Departements $loc): self
    {
        $this->location = $loc;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): static
    {
        $this->img = $img;

        return $this;
    }

    public function getTime(): ?\DateTime
    {
        return $this->time;
    }

    public function setTime(\DateTime $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getAccess(): ?string
    {
        return $this->access;
    }

    public function setAccess(?string $access): static
    {
        $this->access = $access;

        return $this;
    }

    public function getRestauration(): ?string
    {
        return $this->restauration;
    }

    public function setRestauration(?string $restauration): static
    {
        $this->restauration = $restauration;

        return $this;
    }


        public function getAccessibility(): ?string
    {
        return $this->accessibility;
    }

    public function setAccessibility(?string $accessibility): static
    {
        $this->accessibility = $accessibility;

        return $this;
    }


    public function getMinimumage(): ?int
    {
        return $this->minimumage;
    }

    public function setMinimumage(?int $minimumage): static
    {
        $this->minimumage = $minimumage;

        return $this;
    }


}
