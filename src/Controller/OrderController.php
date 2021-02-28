<?php

namespace App\Controller;

use App\Mappers\OrderMapper;
use App\Service\OrderService;
use App\Utils\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $jsonResponse;
    private $orderMapper;
    private $orderService;

    public function __construct(JsonResponse $jsonResponse, OrderService $orderService, OrderMapper $orderMapper)
    {
        $this->jsonResponse = $jsonResponse;
        $this->orderService = $orderService;
        $this->orderMapper = $orderMapper;
    }

    /**
     * @Route("/create-order")
     */
    public function insertOrder(Request $request)
    {
        $order = $this->orderMapper->contentToOrder(json_decode($request->getContent()));
        if ($order) {
            $this->orderService->createOrder($order);
            return $this->jsonResponse->success($order, 'return-order');
        }
        return $this->jsonResponse->error('error');
    }
}
