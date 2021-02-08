<?php

namespace App\Service;

use App\Entity\CaseMap;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileWriterService
{
    private $map;

    /** Méthode principale pour créer le fichier de sortie du jeu
     * $data a besoin des attributs filename, map, et joueurs.
     *
     * @param $data
     *
     * @return BinaryFileResponse
     */
    public function generateOutPutFile($data)
    {
        if (!property_exists($data, 'filename') || !property_exists($data, 'map') || !property_exists($data, 'joueurs')) {
            throw new InvalidArgumentException('Paramètres non valides');
        }
        $this->map = $data->map;
        $filename = 'output_'.$data->filename;
        $file = fopen(__DIR__.'/../ressources/data/output/'.$filename, 'w') or exit('Unable to open file!');
        $this->writeMapValues($file, $data->map);
        $this->writeJoueursValues($file, $data->joueurs);
        fclose($file);

        return new BinaryFileResponse(__DIR__.'/../ressources/data/output/'.$filename);
    }

    /** Cette méthode écrit les paramètres de la carte : dimensions, emplacement des montagnes et trésors.
     * @param $file
     * @param $map
     */
    private function writeMapValues($file, $map)
    {
        $lineParamsMap = 'C - '.sizeof($map).' - '.sizeof($map[0])."\n";
        fwrite($file, $lineParamsMap);
        for ($i = 0; $i < sizeof($map); ++$i) {
            for ($j = 0; $j < sizeof($map[0]); ++$j) {
                if (CaseMap::MONTAGNE === $map[$i][$j]->type) {
                    $lineMountain = 'M - '.$j.' - '.$i."\n";
                    fwrite($file, $lineMountain);
                } elseif (CaseMap::TRESOR === $map[$i][$j]->type) {
                    $lineTreasure = 'T - '.$j.' - '.$i.' - '.$map[$i][$j]->nbr_tresors."\n";
                    fwrite($file, $lineTreasure);
                }
            }
        }
    }

    /** Cette méthode écrit résultats des aventuriers.
     * @param $file
     * @param $joueurs
     */
    private function writeJoueursValues($file, $joueurs)
    {
        for ($i = 0; $i < sizeof($joueurs); ++$i) {
            $position = $this->getJoueurPosition($joueurs[$i]->id);
            $lineTreasure = 'A - '.$joueurs[$i]->nom.' - '.$position['x'].' - '.$position['y'].' - '.$joueurs[$i]->orientation.' - '.$joueurs[$i]->nbr_tresors."\n";
            fwrite($file, $lineTreasure);
        }
    }

    /** Récupère la position d un joueur sur la carte à partir de son ID.
     * @param $idJoueur
     *
     * @return array
     */
    private function getJoueurPosition($idJoueur)
    {
        for ($i = 0; $i < sizeof($this->map); ++$i) {
            for ($j = 0; $j < sizeof($this->map[0]); ++$j) {
                if (property_exists($this->map[$i][$j], 'joueur') && null !== $this->map[$i][$j]->joueur && $idJoueur === $this->map[$i][$j]->joueur->id) {
                    return [
                      'x' => $j,
                      'y' => $i,
                  ];
                }
            }
        }
    }
}
