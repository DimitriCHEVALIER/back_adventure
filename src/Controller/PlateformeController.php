<?php

namespace App\Controller;

use App\Repository\PlateformeRepository;
use App\Utils\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlateformeController extends AbstractController
{
    private $jsonResponse;
    private $plateformeRepository;

    public function __construct(JsonResponse $jsonResponse, PlateformeRepository $plateformeRepository)
    {
        $this->jsonResponse = $jsonResponse;
        $this->plateformeRepository = $plateformeRepository;
    }

    /**
     * @Route("/get_plateformes", name="get_plateformes")
     *
     *
     * @return Response
     */
    public function getPlateformes()
    {
        return $this->jsonResponse->success($this->plateformeRepository->findAll(), ['single-plateforme']);
    }

    /**
     * @Route("/get_plateformes_referentiels", name="get_plateformes_referentiels")
     *
     *
     * @return Response
     */
    public function getPlateformeReferentiel()
    {
        return $this->jsonResponse->success($this->plateformeRepository->findAll(), ['liste_plateformes']);
    }

    /**
     * @Route("/get_plateforme/{code}", name="get_plateforme")
     *
     * @param $code
     *
     * @return Response
     */
    public function getPlateforme($code)
    {
        return $this->jsonResponse->success($this->plateformeRepository->findOneByCode($code), ['single-plateforme']);
    }
}
