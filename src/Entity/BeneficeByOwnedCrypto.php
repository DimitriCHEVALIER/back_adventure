<?php

namespace App\Entity;

use App\Repository\BeneficeByOwnedCryptoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BeneficeByOwnedCryptoRepository::class)
 */
class BeneficeByOwnedCrypto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=OwnedCrypto::class, inversedBy="beneficeByOwnedCryptos")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"create_benefit", "get_benefits"})
     */
    private $ownedCrypto;

    /**
     * @ORM\Column(type="float")
     * @Groups({"create_benefit", "get_benefits"})
     */
    private $beneficeNet;

    /**
     * @ORM\Column(type="float")
     * @Groups({"create_benefit", "get_benefits"})
     */
    private $impot;

    /**
     * @ORM\Column(type="float")
     * @Groups({"create_benefit", "get_benefits"})
     */
    private $amountSold;

    /**
     * @ORM\Column(type="float")
     * @Groups({"create_benefit", "get_benefits"})
     */
    private $tauxVente;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     * @Groups({"get_benefits"})
     */
    private $impotDeclared;

    public function __construct()
    {
        $this->impotDeclared = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwnedCrypto(): ?OwnedCrypto
    {
        return $this->ownedCrypto;
    }

    public function setOwnedCrypto(?OwnedCrypto $ownedCrypto): self
    {
        $this->ownedCrypto = $ownedCrypto;

        return $this;
    }

    public function getBeneficeNet(): ?float
    {
        return $this->beneficeNet;
    }

    public function setBeneficeNet(float $beneficeNet): self
    {
        $this->beneficeNet = $beneficeNet;

        return $this;
    }

    public function getImpot(): ?float
    {
        return $this->impot;
    }

    public function setImpot(float $impot): self
    {
        $this->impot = $impot;

        return $this;
    }

    public function getAmountSold(): ?float
    {
        return $this->amountSold;
    }

    public function setAmountSold(float $amountSold): self
    {
        $this->amountSold = $amountSold;

        return $this;
    }

    public function getTauxVente(): ?float
    {
        return $this->tauxVente;
    }

    public function setTauxVente(float $tauxVente): self
    {
        $this->tauxVente = $tauxVente;

        return $this;
    }

    public function getImpotDeclared(): ?bool
    {
        return $this->impotDeclared;
    }

    public function setImpotDeclared(bool $impotDeclared): self
    {
        $this->impotDeclared = $impotDeclared;

        return $this;
    }
}
