<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $name = null;
    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $color = null;


    //créer la fonction qui retourne l'id
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    // créer la fonction qui paramètre le nom, en tant que variable $name
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }



    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;
        return $this;
    }


    public function __toString(): string
    {
        return $this->name ?? 'Category';
    }
}





