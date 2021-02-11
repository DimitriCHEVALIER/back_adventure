<?php

namespace App\Tests;

use App\Entity\CaseMap;
use App\Service\FileWriterService;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class FileWriterServiceTest extends TestCase
{
    private $fileWriterService;

    protected function setUp(): void
    {
        $this->fileWriterService = new FileWriterService();
    }

    public function testGenerateOutPutFileWrongParameters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $dataError = new stdClass();
        $dataError->nothing = 'nothing';

        $this->fileWriterService->generateOutPutFile(json_encode($dataError));
    }

    public function testGenerateOutPutFile(): void
    {
        $plaine = new stdClass();
        $plaine->type = CaseMap::PLAINE;
        $data = new stdClass();
        $data->filename = 'filename';
        $data->joueurs = [
        ];
        $data->map = [
            [
                $plaine,
            ],
            [
                $plaine,
            ],
        ];

        $output = $this->fileWriterService->generateOutPutFile($data);
        $this->assertNotNull($output);
    }
}
