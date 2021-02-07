<?php


namespace App\Entity;


class Joueur
{
    /** @var string */
    private $id;
    /** @var string */
    private $nom;
    /** @var int */
    private $xInitial;
    /** @var int */
    private $yInitial;
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

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return Joueur
     */
    public function setNom(string $nom): Joueur
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return int
     */
    public function getXInitial(): int
    {
        return $this->xInitial;
    }

    /**
     * @param int $xInitial
     * @return Joueur
     */
    public function setXInitial(int $xInitial): Joueur
    {
        $this->xInitial = $xInitial;
        return $this;
    }

    /**
     * @return int
     */
    public function getYInitial(): int
    {
        return $this->yInitial;
    }

    /**
     * @param int $yInitial
     * @return Joueur
     */
    public function setYInitial(int $yInitial): Joueur
    {
        $this->yInitial = $yInitial;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrientation(): string
    {
        return $this->orientation;
    }

    /**
     * @param string $orientation
     * @return Joueur
     */
    public function setOrientation(string $orientation): Joueur
    {
        $this->orientation = $orientation;
        return $this;
    }

    /**
     * @return string
     */
    public function getSequence(): string
    {
        return $this->sequence;
    }

    /**
     * @param string $sequence
     * @return Joueur
     */
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
     * @return Joueur
     */
    public function setId(string $id): Joueur
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbrTresors(): int
    {
        return $this->nbrTresors;
    }

    /**
     * @param int $nbrTresors
     * @return Joueur
     */
    public function setNbrTresors(int $nbrTresors): Joueur
    {
        $this->nbrTresors = $nbrTresors;
        return $this;
    }
}