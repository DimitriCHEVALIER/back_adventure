<?php

namespace App\Entity;

class Joueur
{
    /** @var string */
    private $id;
    /** @var string */
    private $nom;
    /** @var string */
    private $orientation;
    /** @var string */
    private $sequence;
    /** @var int */
    private $nbrTresors;

    public function __construct()
    {
        $this->id = uniqid();
        $this->nbrTresors = 0;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): Joueur
    {
        $this->nom = $nom;

        return $this;
    }

    public function getOrientation(): string
    {
        return $this->orientation;
    }

    public function setOrientation(string $orientation): Joueur
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function getSequence(): string
    {
        return $this->sequence;
    }

    public function setSequence(string $sequence): Joueur
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(string $id): Joueur
    {
        $this->id = $id;

        return $this;
    }

    public function getNbrTresors(): int
    {
        return $this->nbrTresors;
    }

    public function setNbrTresors(int $nbrTresors): Joueur
    {
        $this->nbrTresors = $nbrTresors;

        return $this;
    }
}
