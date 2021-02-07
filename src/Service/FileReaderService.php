<?php

namespace App\Service;

use App\Entity\CaseMap;
use App\Entity\Game;
use App\Entity\Joueur;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class FileReaderService
{
    private $map;
    private $joueurs;

    public function translateFile($filename)
    {
        $this->joueurs = [];
        foreach (file(__DIR__.'/../ressources/data/'.$filename) as $line) {
            if ('#' == substr("$line", 1)) {
                continue;
            }
            $line = str_replace("\r", '', $line);
            $line = str_replace("\n", '', $line);
            $tabledLines = explode(' - ', $line);
            if ($tabledLines && 'C' == $tabledLines[0]) {
                $this->createMap($tabledLines);
            } elseif ($tabledLines && 'M' == $tabledLines[0]) {
                $this->createMountain($tabledLines);
            } elseif ($tabledLines && 'T' == $tabledLines[0]) {
                $this->setTresor($tabledLines);
            } elseif ($tabledLines && 'A' == $tabledLines[0]) {
                $this->addAventurier($tabledLines);
            }
        }

        return new Game($this->map, $this->joueurs);
    }

    private function createMap($params)
    {
        if (sizeof($params) <= 2) {
            throw new InvalidArgumentException('Fichier non valide');
        }
        for ($i = 0; $i < intval($params[1]); ++$i) {
            for ($j = 0; $j < intval($params[2]); ++$j) {
                $this->map[$i][$j] = new CaseMap(CaseMap::PLAINE);
            }
        }
    }

    private function createMountain($params)
    {
        if (sizeof($params) <= 2) {
            throw new InvalidArgumentException('Fichier non valide');
        }
        $this->map[intval($params[1])][intval($params[2])]->setType(CaseMap::MONTAGNE);
    }

    private function setTresor($params)
    {
        if (sizeof($params) <= 3) {
            throw new InvalidArgumentException('Fichier non valide');
        }
        $this->map[intval($params[1])][intval($params[2])]->setType(CaseMap::TRESOR);
        $this->map[intval($params[1])][intval($params[2])]->addTresors(intval($params[3]));
    }

    private function addAventurier($params)
    {
        if (sizeof($params) <= 5) {
            throw new InvalidArgumentException('Fichier non valide');
        }
        $newJoueur = new Joueur();

        $newJoueur->setNom($params[1])
            ->setOrientation($params[4])
            ->setSequence($params[5]);
        $this->map[intval($params[2])][intval($params[3])]->setJoueur($newJoueur);
        array_push($this->joueurs, $newJoueur);
    }
}
