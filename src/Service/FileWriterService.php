<?php

namespace App\Service;

use App\Entity\CaseMap;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileWriterService
{
    private $map;

    public function generateOutPutFile($data)
    {
        $this->map = $data->map;
        $filename = 'output_Adventure.txt';
        $file = fopen(__DIR__.'/../ressources/data/'.$filename, 'w') or exit('Unable to open file!');
        $this->writeMapValues($file, $data->map);
        $this->writeJoueursValues($file, $data->joueurs);
        fclose($file);

        return new BinaryFileResponse(__DIR__.'/../ressources/data/'.$filename);
    }

    private function writeMapValues($file, $map)
    {
        $lineParamsMap = 'C - '.sizeof($map).' - '.sizeof($map[0])."\n";
        fwrite($file, $lineParamsMap);
        for ($i = 0; $i < sizeof($map); ++$i) {
            for ($j = 0; $j < sizeof($map[0]); ++$j) {
                if (CaseMap::MONTAGNE === $map[$i][$j]->type) {
                    $lineMountain = 'M - '.$i.' - '.$j."\n";
                    fwrite($file, $lineMountain);
                } elseif (CaseMap::TRESOR === $map[$i][$j]->type) {
                    $lineTreasure = 'T - '.$i.' - '.$j.' - '.$map[$i][$j]->nbr_tresors."\n";
                    fwrite($file, $lineTreasure);
                }
            }
        }
    }

    private function writeJoueursValues($file, $joueurs)
    {
        for ($i = 0; $i < sizeof($joueurs); ++$i) {
            $position = $this->getJoueurPosition($joueurs[$i]->id);
            $lineTreasure = 'T - '.$joueurs[$i]->nom.' - '.$position['x'].' - '.$position['y'].' - '.$joueurs[$i]->orientation.' - '.$joueurs[$i]->nbr_tresors."\n";
            fwrite($file, $lineTreasure);
        }
    }

    private function getJoueurPosition($idJoueur)
    {
        for ($i = 0; $i < sizeof($this->map); ++$i) {
            for ($j = 0; $j < sizeof($this->map[0]); ++$j) {
                if (property_exists($this->map[$i][$j], 'joueur')) {
                }
                if (property_exists($this->map[$i][$j], 'joueur') && null !== $this->map[$i][$j]->joueur && $idJoueur === $this->map[$i][$j]->joueur->id) {
                    return [
                      'x' => $i,
                      'y' => $j,
                  ];
                }
            }
        }
    }
}
