<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"productsByCategory"})
     * @Groups({"product"})
     * @Groups({"returnedOrders"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"productsByCategory"})
     * @Groups({"product"})
     * @Groups({"returnedOrders"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3, max = 128)
     * @Groups({"productsByCategory"})
     * @Groups({"product"})
     * @Groups({"returnedOrders"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank()
     * @Assert\Length(min = 10, max = 128)
     * @Groups({"productsByCategory"})
     * @Groups({"product"})
     */
    private $picture;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     * @Groups({"productsByCategory"})
     * @Groups({"product"})
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Groups({"productsByCategory"})
     * @Groups({"product"})
     */
    private $size;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide.")
     * @Groups({"productsByCategory"})
     * @Groups({"product"})
     * @Assert\NotBlank(message="Veuillez renseigner un prix.")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Veuillez ajouter une description.")
     * @Groups({"productsByCategory"})
     * @Groups({"product"})
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Groups({"productsByCategory"})
     * @Groups({"product"})
     */
    private $ingredients;

    /**
     * @ORM\Column(type="text")
     * @Groups({"productsByCategory"})
     * @Groups({"product"})
     */
    private $advice;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"productsByCategory"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"productsByCategory"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"productsByCategory"})
     * @Groups({"product"})
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=ProductOrder::class, mappedBy="product")
     */
    private $productOrders;

    public function __construct()
    {
        $this->productOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getAdvice(): ?string
    {
        return $this->advice;
    }

    public function setAdvice(string $advice): self
    {
        $this->advice = $advice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getType(): ?type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, ProductOrder>
     */
    public function getProductOrders(): Collection
    {
        return $this->productOrders;
    }

    public function addProductOrder(ProductOrder $productOrder): self
    {
        if (!$this->productOrders->contains($productOrder)) {
            $this->productOrders[] = $productOrder;
            $productOrder->setProduct($this);
        }

        return $this;
    }

    public function removeProductOrder(ProductOrder $productOrder): self
    {
        if ($this->productOrders->removeElement($productOrder)) {
            // set the owning side to null (unless already changed)
            if ($productOrder->getProduct() === $this) {
                $productOrder->setProduct(null);
            }
        }

        return $this;
    }
}
