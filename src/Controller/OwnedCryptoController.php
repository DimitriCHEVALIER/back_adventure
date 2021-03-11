<?php

namespace App\Controller;

use App\Entity\Plateforme;
use App\Repository\OwnedCryptoRepository;
use App\Utils\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OwnedCryptoController extends AbstractController
{
    private $jsonResponse;
    private $ownedCryptoRepository;

    public function __construct(JsonResponse $jsonResponse, OwnedCryptoRepository $ownedCryptoRepository)
    {
        $this->jsonResponse = $jsonResponse;
        $this->ownedCryptoRepository = $ownedCryptoRepository;
    }

    /**
     * @Route("/get_owned_crypto_by_platform/{code}", name="get_owned_crypto_by_platform")
     *
     * @param $code
     *
     * @return Response
     */
    public function getOwnedCryptoByPlateforme($code)
    {
        if (Plateforme::ALL_PLATEFORMES_CODE === $code) {
            return $this->jsonResponse->success($this->ownedCryptoRepository->findAll(), ['get_owned_cryptos']);
        }

        return $this->jsonResponse->success($this->ownedCryptoRepository->findOneByPlateforme($code), 'get_owned_cryptos');
    }
}
