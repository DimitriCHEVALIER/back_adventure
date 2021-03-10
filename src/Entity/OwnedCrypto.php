<?php

namespace App\Entity;

use App\Repository\OwnedCryptoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OwnedCryptoRepository::class)
 */
class OwnedCrypto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_owned_cryptos"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cryptocurrency::class, inversedBy="ownedCryptos")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get_owned_cryptos", "get_benefits"})
     */
    private $crytocurrency;

    /**
     * @ORM\ManyToOne(targetEntity=Plateforme::class, inversedBy="ownedCryptos")
     * @Groups({"get_owned_cryptos"})
     */
    private $plateforme;

    /**
     * @ORM\Column(type="float")
     * @Groups({"get_owned_cryptos"})
     */
    private $amount;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"get_owned_cryptos"})
     */
    private $averageEuroEq;

    /**
     * @ORM\OneToMany(targetEntity=BeneficeByOwnedCrypto::class, mappedBy="ownedCrypto")
     */
    private $beneficeByOwnedCryptos;

    public function __construct()
    {
        $this->beneficeByOwnedCryptos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCrytocurrency(): ?Cryptocurrency
    {
        return $this->crytocurrency;
    }

    public function setCrytocurrency(?Cryptocurrency $crytocurrency): self
    {
        $this->crytocurrency = $crytocurrency;

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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAverageEuroEq(): ?float
    {
        return $this->averageEuroEq;
    }

    public function setAverageEuroEq(?float $averageEuroEq): self
    {
        $this->averageEuroEq = $averageEuroEq;

        return $this;
    }

    /**
     * @return Collection|BeneficeByOwnedCrypto[]
     */
    public function getBeneficeByOwnedCryptos(): Collection
    {
        return $this->beneficeByOwnedCryptos;
    }

    public function addBeneficeByOwnedCrypto(BeneficeByOwnedCrypto $beneficeByOwnedCrypto): self
    {
        if (!$this->beneficeByOwnedCryptos->contains($beneficeByOwnedCrypto)) {
            $this->beneficeByOwnedCryptos[] = $beneficeByOwnedCrypto;
            $beneficeByOwnedCrypto->setOwnedCrypto($this);
        }

        return $this;
    }

    public function removeBeneficeByOwnedCrypto(BeneficeByOwnedCrypto $beneficeByOwnedCrypto): self
    {
        if ($this->beneficeByOwnedCryptos->removeElement($beneficeByOwnedCrypto)) {
            // set the owning side to null (unless already changed)
            if ($beneficeByOwnedCrypto->getOwnedCrypto() === $this) {
                $beneficeByOwnedCrypto->setOwnedCrypto(null);
            }
        }

        return $this;
    }
}
