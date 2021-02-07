<?php

namespace App\Entity;

class CaseMap
{
    public const PLAINE = 'PLAINE';
    public const MONTAGNE = 'MONTAGNE';
    public const TRESOR = 'TRESOR';

    /** @var string */
    private $type;
    /** @var int */
    private $nbrTresors;

    /** @var ?Joueur */
    private $joueur;

    public function __construct(string $type)
    {
        $this->type = $type;
        $this->nbrTresors = 0;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): CaseMap
    {
        $this->type = $type;

        return $this;
    }

    public function getNbrTresors(): int
    {
        return $this->nbrTresors;
    }

    public function setNbrTresors(int $nbrTresors): CaseMap
    {
        $this->nbrTresors = $nbrTresors;

        return $this;
    }

    /**
     * @param int $nbrTresors
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
     *
     * @return CaseMap
     */
    public function setJoueur($joueur)
    {
        $this->joueur = $joueur;

        return $this;
    }
}
