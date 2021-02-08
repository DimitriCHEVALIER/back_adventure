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
     */
    public function translateFile($filename)
    {
        $this->joueurs = [];
        foreach (file(__DIR__.'/../ressources/data/input/'.$filename) as $line) {
            if ('#' == substr("$line", 1)) {
                continue;
            }
            // clean des caractère non textuels
            $line = str_replace("\r", '', $line);
            $line = str_replace("\n", '', $line);
            // On répcupère les paramètres la ligne un par un
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
        if (sizeof($params) <= 2) {
            throw new InvalidArgumentException('Fichier non valide');
        }
        $this->map[intval($params[2])][intval($params[1])]->setType(CaseMap::MONTAGNE);
    }

    /** Ajout d'un trésor sur la carte.
     * @param $params array ligne de paramètre explosée
     */
    private function setTresor($params)
    {
        if (sizeof($params) <= 3) {
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
        if (sizeof($params) <= 5) {
            throw new InvalidArgumentException('Fichier non valide');
        }
        $newJoueur = new Joueur();

        $newJoueur->setNom($params[1])
            ->setOrientation($params[4])
            ->setSequence($params[5]);
        $this->map[intval($params[3])][intval($params[2])]->setJoueur($newJoueur);
        array_push($this->joueurs, $newJoueur);
    }
}
