<?php

namespace App\Entity;

use App\Repository\CryptocurrencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CryptocurrencyRepository::class)
 */
class Cryptocurrency
{
    const EURO_CODE = 'EUR';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_owned_cryptos"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"currencies_referentiel", "get_owned_cryptos", "get_benefits"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"currencies_referentiel", "get_owned_cryptos", "get_benefits"})
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=OwnedCrypto::class, mappedBy="crytocurrency")
     * @Groups({"currencies_referentiel"})
     */
    private $ownedCryptos;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="originalCurrency")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="newCurrency")
     */
    private $ordersBought;

    public function __construct()
    {
        $this->ownedCryptos = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->ordersBought = new ArrayCollection();
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
            $ownedCrypto->setCrytocurrency($this);
        }

        return $this;
    }

    public function removeOwnedCrypto(OwnedCrypto $ownedCrypto): self
    {
        if ($this->ownedCryptos->removeElement($ownedCrypto)) {
            // set the owning side to null (unless already changed)
            if ($ownedCrypto->getCrytocurrency() === $this) {
                $ownedCrypto->setCrytocurrency(null);
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
            $order->setOriginalCurrency($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getOriginalCurrency() === $this) {
                $order->setOriginalCurrency(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrdersBought(): Collection
    {
        return $this->ordersBought;
    }

    public function addOrdersBought(Order $ordersBought): self
    {
        if (!$this->ordersBought->contains($ordersBought)) {
            $this->ordersBought[] = $ordersBought;
            $ordersBought->setNewCurrency($this);
        }

        return $this;
    }

    public function removeOrdersBought(Order $ordersBought): self
    {
        if ($this->ordersBought->removeElement($ordersBought)) {
            // set the owning side to null (unless already changed)
            if ($ordersBought->getNewCurrency() === $this) {
                $ordersBought->setNewCurrency(null);
            }
        }

        return $this;
    }
}
