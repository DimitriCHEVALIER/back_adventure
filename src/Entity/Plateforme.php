<?php

namespace App\Entity;

use App\Repository\PlateformeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PlateformeRepository::class)
 */
class Plateforme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"liste_plateformes, single-plateforme"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"liste_plateformes, single-plateforme"})
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"single-plateforme"})
     */
    private $amountInvestment;

    /**
     * @ORM\OneToMany(targetEntity=OwnedCrypto::class, mappedBy="plateforme")
     */
    private $ownedCryptos;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="plateforme")
     */
    private $orders;

    public function __construct()
    {
        $this->ownedCryptos = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAmountInvestment(): ?int
    {
        return $this->amountInvestment;
    }

    public function setAmountInvestment(int $amountInvestment): self
    {
        $this->amountInvestment = $amountInvestment;

        return $this;
    }

    /**
     * @return Collection|OwnedCrypto[]
     */
    public function getOwnedCryptos(): Collection
    {
        return $this->ownedCryptos;
    }

    public function addOwnedCrypto(OwnedCrypto $ownedCrypto): self
    {
        if (!$this->ownedCryptos->contains($ownedCrypto)) {
            $this->ownedCryptos[] = $ownedCrypto;
            $ownedCrypto->setPlateforme($this);
        }

        return $this;
    }

    public function removeOwnedCrypto(OwnedCrypto $ownedCrypto): self
    {
        if ($this->ownedCryptos->removeElement($ownedCrypto)) {
            // set the owning side to null (unless already changed)
            if ($ownedCrypto->getPlateforme() === $this) {
                $ownedCrypto->setPlateforme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setPlateforme($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getPlateforme() === $this) {
                $order->setPlateforme(null);
            }
        }

        return $this;
    }
}
