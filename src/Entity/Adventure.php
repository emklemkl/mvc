<?php

namespace App\Entity;

use App\Repository\AdventureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdventureRepository::class)]
class Adventure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $back = null;

    #[ORM\Column(length: 255)]
    private ?string $forward = null;

    #[ORM\Column(length: 255)]
    private ?string $left_go = null;

    #[ORM\Column(length: 255)]
    private ?string $right_go = null;

    #[ORM\Column(length: 255)]
    private ?string $item = null;

    #[ORM\Column(length: 255)]
    private ?string $image_class = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBack(): ?string
    {
        return $this->back;
    }

    public function setBack(string $back): static
    {
        $this->back = $back;

        return $this;
    }

    public function getForward(): ?string
    {
        return $this->forward;
    }

    public function setForward(string $forward): static
    {
        $this->forward = $forward;

        return $this;
    }

    public function getLeftGo(): ?string
    {
        return $this->left_go;
    }

    public function setLeftGo(string $left_go): static
    {
        $this->left_go = $left_go;

        return $this;
    }

    public function getRightGo(): ?string
    {
        return $this->right_go;
    }

    public function setRightGo(string $right_go): static
    {
        $this->right_go = $right_go;

        return $this;
    }

    public function getItem(): ?string
    {
        return $this->item;
    }

    public function setItem(string $item): static
    {
        $this->item = $item;

        return $this;
    }

    public function getImageClass(): ?string
    {
        return $this->image_class;
    }

    public function setImageClass(string $image_class): static
    {
        $this->image_class = $image_class;

        return $this;
    }
}
