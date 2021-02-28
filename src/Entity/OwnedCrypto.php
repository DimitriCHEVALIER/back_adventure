<?php

namespace App\Entity;

use App\Repository\OwnedCryptoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OwnedCryptoRepository::class)
 */
class OwnedCrypto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cryptocurrency::class, inversedBy="ownedCryptos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $crytocurrency;

    /**
     * @ORM\ManyToOne(targetEntity=Plateforme::class, inversedBy="ownedCryptos")
     */
    private $plateforme;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $averageEuroEq;

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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getEuroAmountOrigin(): ?float
    {
        return $this->averageEuroEq;
    }

    public function setEuroAmountOrigin(?float $averageEuroEq): self
    {
        $this->averageEuroEq = $averageEuroEq;

        return $this;
    }
}
