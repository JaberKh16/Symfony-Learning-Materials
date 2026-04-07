<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Assert\Length;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint as Assert;


#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Product name should not be blank")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: "Product name must be at least {{ limit }} characters long",
        maxMessage: "Product name cannot be longer than {{ limit }} characters"
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    #[Assert\NotBlank(message: "SKU should not be blank")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: "SKU must be at least {{ limit }} characters long",
        maxMessage: "SKU cannot be longer than {{ limit }} characters"
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9_-]+$/",
        message: "SKU can only contain letters, numbers, underscores, and hyphens"
    )]
    
    private ?string $sku = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\Type('float')]
    #[Assert\NotBlank(message: "Price should not be blank")]
    #[Assert\GreaterThan(
        value: 0,
        message: "Price must be a positive number"
    )]
    private ?float $price = null;

    #[ORM\Column]
    #[Assert\Type('\DateTime')]
    #[Assert\NotBlank(message: "Entry date should not be blank")]
    private ?\DateTime $entry_date = null;

    #[ORM\Column]
    #[Assert\Type('boolean')]
    #[Assert\NotNull(message: "Status should not be null")]
    private ?bool $status = null;

    public function __construct()
    {
        $this->entry_date = new \DateTime();
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

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

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

    public function getEntryDate(): ?\DateTime
    {
        return $this->entry_date;
    }

    public function setEntryDate(\DateTime $entry_date): static
    {
        $this->entry_date = $entry_date;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }
}
