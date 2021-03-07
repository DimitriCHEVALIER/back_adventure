<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cryptocurrency::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"return-order"})
     */
    private $originalCurrency;

    /**
     * @ORM\ManyToOne(targetEntity=Cryptocurrency::class, inversedBy="ordersBought")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"return-order"})
     */
    private $newCurrency;

    /**
     * @ORM\Column(type="float")
     * @Groups({"return-order"})
     */
    private $amountOldCurrency;

    /**
     * @ORM\Column(type="float")
     * @Groups({"return-order"})
     */
    private $amountNewCurrency;

    /**
     * @ORM\ManyToOne(targetEntity=Plateforme::class, inversedBy="orders")
     * @Groups({"return-order"})
     */
    private $plateforme;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalCurrency(): ?Cryptocurrency
    {
        return $this->originalCurrency;
    }

    public function setOriginalCurrency(?Cryptocurrency $originalCurrency): self
    {
        $this->originalCurrency = $originalCurrency;

        return $this;
    }

    public function getNewCurrency(): ?Cryptocurrency
    {
        return $this->newCurrency;
    }

    public function setNewCurrency(?Cryptocurrency $newCurrency): self
    {
        $this->newCurrency = $newCurrency;

        return $this;
    }

    public function getAmountOldCurrency(): ?float
    {
        return $this->amountOldCurrency;
    }

    public function setAmountOldCurrency(float $amountOldCurrency): self
    {
        $this->amountOldCurrency = $amountOldCurrency;

        return $this;
    }

    public function getAmountNewCurrency(): ?float
    {
        return $this->amountNewCurrency;
    }

    public function setAmountNewCurrency(float $amountNewCurrency): self
    {
        $this->amountNewCurrency = $amountNewCurrency;

        return $this;
    }

    public function getPlateforme(): ?Plateforme
    {
        return $this->plateforme;
    }

    public function setPlateforme(?Plateforme $plateforme): self
    {
        $this->plateforme = $plateforme;

        return $this;
    }
}
