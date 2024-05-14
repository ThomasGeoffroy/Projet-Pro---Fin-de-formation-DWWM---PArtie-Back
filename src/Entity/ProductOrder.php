<?php

namespace App\Entity;

use App\Repository\ProductOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductOrderRepository::class)
 */
class ProductOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"returnedOrders"})
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"returnedOrders"})
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="productOrders")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"returnedOrders"})
     */
    private $orderCode;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="productOrders")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Groups({"returnedOrders"})
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrderCode(): ?Order
    {
        return $this->orderCode;
    }

    public function setOrderCode(?Order $orderCode): self
    {
        $this->orderCode = $orderCode;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
