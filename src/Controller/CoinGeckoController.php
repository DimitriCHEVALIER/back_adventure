<?php

namespace App\Controller;

use App\Service\CoinGeckoService;
use App\Utils\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoinGeckoController extends AbstractController
{
    private $jsonResponse;
    private $coinGeckoService;

    public function __construct(JsonResponse $jsonResponse, CoinGeckoService $coinGeckoService)
    {
        $this->jsonResponse = $jsonResponse;
        $this->coinGeckoService = $coinGeckoService;
    }

    /**
     * @Route("/get_coins_value", name="get_coins_value")
     *
     * @return Response
     */
    public function getCoinsValue()
    {
        return $this->jsonResponse->success($this->coinGeckoService->getListIdCoins(), ['coins_values']);
    }
}
