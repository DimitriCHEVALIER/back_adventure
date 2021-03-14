<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class CoinDto
{
    /** @var string */
    private $id;
    /** @var string
     * @Groups({"coins_values"})
     */
    private $nom;
    /** @var string
     * @Groups({"coins_values"})
     */
    private $code;
    /** @var float
     * @Groups({"coins_values"})
     */
    private $value;

    /** @var string
     * @Groups({"coins_values"})
     */
    private $dateDebutChart;

    /** @var array
     * @Groups({"coins_values"})
     */
    private $sparklingLastWeek;

    /** @var string
     * @Groups({"coins_values"})
     */
    private $imgSrc;

    public function __construct()
    {
        $this->id = uniqid();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function getDateDebutChart(): string
    {
        return $this->dateDebutChart;
    }

    public function setDateDebutChart(string $dateDebutChart): CoinDto
    {
        $this->dateDebutChart = $dateDebutChart;

        return $this;
    }

    public function getSparklingLastWeek(): array
    {
        return $this->sparklingLastWeek;
    }

    public function setSparklingLastWeek(array $sparklingLastWeek): CoinDto
    {
        $this->sparklingLastWeek = $sparklingLastWeek;

        return $this;
    }

    public function getImgSrc(): string
    {
        return $this->imgSrc;
    }

    public function setImgSrc(string $imgSrc): CoinDto
    {
        $this->imgSrc = $imgSrc;

        return $this;
    }
}
