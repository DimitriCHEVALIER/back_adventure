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

    /** Récupère la liste complète des fichiers dans  le dossier d'input*/
    public function getAllInputFilesNames()
    {
        $allFiles = scandir(__DIR__.'/../ressources/data/input');
        // On enleve les 2 premiers résultats qui sont . et ..
        array_shift($allFiles);
        array_shift($allFiles);

        return $allFiles;
    }

    /** Méthode principale pour lire un fichier d'entrée.
     * @param $filename
     *
     * @return Game
     *
     * @throws InvalidArgumentException
     */
    public function translateFile($filename)
    {
        /* @var InvalidArgumentException $e */
        try {
            $this->joueurs = [];
            foreach (file(__DIR__.'/../ressources/data/input/'.$filename) as $line) {
                if ('#' == substr("$line", 1)) {
                    continue;
                }
                // clean des caractère non textuels
                $line = str_replace("\r", '', $line);
                $line = str_replace("\n", '', $line);
                // On répcupère les paramètres de la ligne un par un
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
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /** Création de la matrice de carte, par défaut enièrement en plaine.
     * @param $params array ligne de paramètre explosée
     */
    private function createMap($params)
    {
        if (sizeof($params) <= 2) {
            throw new InvalidArgumentException('Fichier non valide');
        }
        for ($i = 0; $i < intval($params[2]); ++$i) {
            for ($j = 0; $j < intval($params[1]); ++$j) {
                $this->map[$i][$j] = new CaseMap(CaseMap::PLAINE);
            }
        }
    }

    /** Création d'une montagne sur la carte.
     * @param $params array ligne de paramètre explosée
     */
    private function createMountain($params)
    {
        if ($this->hasSizeMapErrors(2, $params, 2, 1)) {
            throw new InvalidArgumentException('Fichier non valide');
        }
        $this->map[intval($params[2])][intval($params[1])]->setType(CaseMap::MONTAGNE);
    }

    /** Ajout d'un trésor sur la carte.
     * @param $params array ligne de paramètre explosée
     */
    private function setTresor($params)
    {
        if ($this->hasSizeMapErrors(3, $params, 2, 1)) {
            throw new InvalidArgumentException('Fichier non valide');
        }
        $this->map[intval($params[2])][intval($params[1])]->setType(CaseMap::TRESOR);
        $this->map[intval($params[2])][intval($params[1])]->addTresors(intval($params[3]));
    }

    /** Ajout d'un Joueur pour partir à l'aventure.
     * @param $params array ligne de paramètre explosée
     */
    private function addAventurier($params)
    {
        // Gestion des erreurs de fichier, si les valeures insérées ne sont pas bonne
        if ($this->hasSizeMapErrors(5, $params, 3, 2)) {
            throw new InvalidArgumentException('Fichier non valide');
        } elseif (null !== $this->map[intval($params[3])][intval($params[2])]->getJoueur()) {
            throw new InvalidArgumentException('Deux joueurs ne peuvent pas commencer sur la meme case');
        }
        $newJoueur = new Joueur();

        $newJoueur->setNom($params[1])
            ->setOrientation($params[4])
            ->setSequence($params[5]);
        $this->map[intval($params[3])][intval($params[2])]->setJoueur($newJoueur);
        array_push($this->joueurs, $newJoueur);
    }

    private function hasSizeMapErrors($nbrRequiredParams, $params, $x, $y)
    {
        return sizeof($params) <= $nbrRequiredParams || $params[$x] < 0 || $params[$y] < 0 || $params[$x] >= sizeof($this->map)
            || $params[$y] >= sizeof($this->map[0]);
    }
}
