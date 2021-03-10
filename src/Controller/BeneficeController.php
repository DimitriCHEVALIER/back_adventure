<?php

namespace App\Controller;

use App\Mappers\BenefitsMapper;
use App\Repository\BeneficeByOwnedCryptoRepository;
use App\Service\BeneficeService;
use App\Utils\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeneficeController
{
    private $jsonResponse;
    private $beneficeByOwnedCryptoRepository;
    private $beneficeService;
    private $beneficeMapper;

    public function __construct(JsonResponse $jsonResponse, BeneficeByOwnedCryptoRepository $beneficeByOwnedCryptoRepository,
                                BeneficeService $beneficeService, BenefitsMapper $beneficeMapper)
    {
        $this->jsonResponse = $jsonResponse;
        $this->beneficeByOwnedCryptoRepository = $beneficeByOwnedCryptoRepository;
        $this->beneficeService = $beneficeService;
        $this->beneficeMapper = $beneficeMapper;
    }

    /**
     * @Route("/create-benefice")
     */
    public function createBenefice(Request $request)
    {
        $content = json_decode($request->getContent());

        return $this->jsonResponse->success($this->beneficeService->handleCreateBenefice(
            $this->beneficeMapper->contentToBenefit($content)), 'create_benefit');
    }

    /**
     * @Route("/get-benefice_by_plateforme/{code}", name="get_benefice_by_plateforme")
     *
     * @param $code
     * @return Response
     */
    public function getBeneficeByPlateforme($code)
    {
        return $this->jsonResponse->success($this->beneficeByOwnedCryptoRepository
            ->findByPlateforme($code), 'get_benefits');
    }
}
