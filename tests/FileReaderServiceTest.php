<?php

namespace App\Tests;

use App\Entity\CaseMap;
use App\Entity\Game;
use App\Entity\Joueur;
use App\Service\FileReaderService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class FileReaderServiceTest extends TestCase
{
    private $fileReaderService;

    protected function setUp(): void
    {
        $this->fileReaderService = new FileReaderService();
    }

    public function testTranslateFile(): void
    {
        /** @var Game $translatedFile */
        $translatedFile = $this->fileReaderService->translateFile('unit-test.txt');
        $expectedJoueur = (new Joueur())->setSequence('AADADAGGAD')
        ->setOrientation('S')
        ->setNom('Daniel Jackson')
        ->setNbrTresors(0);

        $expectedMap = [
            [
                new CaseMap(CaseMap::TRESOR), new CaseMap(CaseMap::PLAINE),
            ],
            [
                new CaseMap(CaseMap::MONTAGNE), new CaseMap(CaseMap::PLAINE),
            ],
        ];
        $this->assertNotNull($translatedFile);
        $this->assertEquals($expectedMap[0][0]->getType(), $translatedFile->getMap()[0][0]->getType());
        $this->assertEquals($expectedJoueur->getNbrTresors(), $translatedFile->getJoueurs()[0]->getNbrTresors());
        $this->assertEquals($expectedJoueur->getNom(), $translatedFile->getJoueurs()[0]->getNom());
        $this->assertEquals($expectedJoueur->getOrientation(), $translatedFile->getJoueurs()[0]->getOrientation());
        $this->assertEquals(1, sizeof($translatedFile->getJoueurs()));
        $this->assertEquals(sizeof($expectedMap), sizeof($translatedFile->getMap()));
    }

    public function testTranslateFileOutOfMap(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->fileReaderService->translateFile('input-test-error.txt');
    }
}
