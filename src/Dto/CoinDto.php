<?php

namespace App\Dto;
use Symfony\Component\Serializer\Annotation\Groups;

class CoinDto
{
    /** @var string */
    private $id;
    /** @var string
     * @Groups({"coins_values"})
     *
     */
    private $nom;
    /** @var string
     * @Groups({"coins_values"})
     *
     */
    private $code;
    /** @var float
     * @Groups({"coins_values"})
     *
     */
    private $value;

    public function __construct()
    {
        $this->id = uniqid();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }
}
