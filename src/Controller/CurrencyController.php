<?php

namespace App\Controller;

use App\Repository\CryptocurrencyRepository;
use App\Service\CryptoCurrencyService;
use App\Utils\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends AbstractController
{
    private $jsonResponse;
    private $cryptocurrencyRepository;
    private $cryptocurrencyService;

    public function __construct(JsonResponse $jsonResponse, CryptocurrencyRepository $cryptocurrencyRepository,
                                CryptoCurrencyService $cryptocurrencyService)
    {
        $this->jsonResponse = $jsonResponse;
        $this->cryptocurrencyRepository = $cryptocurrencyRepository;
        $this->cryptocurrencyService = $cryptocurrencyService;
    }

    /**
     * @Route("/get_currencies_ref", name="get_currencies_ref")
     *
     * @return Response
     */
    public function getCurrenciesReferentiel()
    {
        return $this->jsonResponse->success($this->cryptocurrencyRepository->findAll(), 'currencies-referentiel');
    }

    /**
     * @Route("/create-currency")
     */
    public function insertOrder(Request $request)
    {
        $content = json_decode($request->getContent());

        $code = property_exists($content, 'code') ? $content->code : null;
        $name = property_exists($content, 'name') ? $content->name : null;
        if ($name && $code) {
            return $this->jsonResponse->success($this->cryptocurrencyService->createCrypto($code, $name));
        }
    }
}
