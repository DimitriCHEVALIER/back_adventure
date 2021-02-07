<?php


namespace App\Entity;


class CaseMap
{

    public const PLAINE = 'PLAINE';
    public const MONTAGNE = 'MONTAGNE';
    public const TRESOR = 'TRESOR';

    /** @var int */
    private $x;
    /** @var int */
    private $y;
    /** @var string */
    private $type;
    /** @var int */
    private $nbrTresors;

    /** @var ?Joueur */
    private $joueur;


    public function __construct(int $x, int $y, string$type)
    {
        $this->x = $x;
        $this->y = $y;
        $this->type = $type;
        $this->nbrTresors = 0;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     * @return CaseMap
     */
    public function setX(int $x): CaseMap
    {
        $this->x = $x;
        return $this;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     * @return CaseMap
     */
    public function setY(int $y): CaseMap
    {
        $this->y = $y;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return CaseMap
     */
    public function setType(string $type): CaseMap
    {
        $this->type = $type;
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
     * @return CaseMap
     */
    public function setNbrTresors(int $nbrTresors): CaseMap
    {
        $this->nbrTresors = $nbrTresors;
        return $this;
    }

    /**
     * @param int $nbrTresors
     * @return CaseMap
     */
    public function addTresors($value): CaseMap
    {
        $this->nbrTresors += $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getJoueur()
    {
        return $this->joueur;
    }

    /**
     * @param mixed $joueur
     * @return CaseMap
     */
    public function setJoueur($joueur)
    {
        $this->joueur = $joueur;
        return $this;
    }

}