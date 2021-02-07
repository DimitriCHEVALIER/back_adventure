<?php

namespace App\Controller;

use App\Service\FileReaderService;
use App\Service\FileWriterService;
use App\Utils\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DataFileController extends AbstractController
{
    private $jsonResponse;
    private $fileReaderService;
    private $fileWriterService;

    public function __construct(JsonResponse $jsonResponse, FileReaderService $fileReaderService, FileWriterService $fileWriterService)
    {
        $this->jsonResponse = $jsonResponse;
        $this->fileReaderService = $fileReaderService;
        $this->fileWriterService = $fileWriterService;
    }

    /**
     * @Route("/get_input_file", name="get_input_file")
     */
    public function getInputFile()
    {
        return $this->jsonResponse->success($this->fileReaderService->translateFile('config-peru.txt'));
    }

    /**
     * @Route("/get_output_file")
     */
    public function getOutputFile(Request $request)
    {
        return $this->fileWriterService->generateOutPutFile(json_decode($request->getContent()));
    }
}
