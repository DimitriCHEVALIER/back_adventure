<?php


namespace App\Entity;


class Game
{

    private $map;

    private $joueurs;

    public function __construct($map, $joueurs)
    {
        $this->joueurs = $joueurs;
        $this->map = $map;
    }

    /**
     * @return mixed
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @param mixed $map
     * @return Game
     */
    public function setMap($map)
    {
        $this->map = $map;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getJoueurs()
    {
        return $this->joueurs;
    }

    /**
     * @param mixed $joueurs
     * @return Game
     */
    public function setJoueurs($joueurs)
    {
        $this->joueurs = $joueurs;
        return $this;
    }
}