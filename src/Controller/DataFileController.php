<?php

namespace App\Controller;

use App\Service\FileReaderService;
use App\Service\FileWriterService;
use App\Utils\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/get_input_file/{name}", name="get_input_file")
     *
     * @param $name
     *
     * @return Response
     */
    public function getInputFile($name)
    {
        try {
            $translatedFile = $this->fileReaderService->translateFile($name);

            return $this->jsonResponse->success($translatedFile);
        } catch (\Exception $e) {
            return $this->jsonResponse->error($e->getMessage());
        }
    }

    /**
     * @Route("/get_list_input_file", name="get_input_file")
     */
    public function getListInputFileNames()
    {
        return $this->jsonResponse->success($this->fileReaderService->getAllInputFilesNames());
    }

    /**
     * @Route("/get_output_file")
     *
     * @return BinaryFileResponse|Response
     */
    public function getOutputFile(Request $request)
    {
        try {
            $generatedFile = $this->fileWriterService->generateOutPutFile(json_decode($request->getContent()));

            return $generatedFile;
        } catch (\Exception $e) {
            return $this->jsonResponse->error($e->getMessage());
        }
    }
}
