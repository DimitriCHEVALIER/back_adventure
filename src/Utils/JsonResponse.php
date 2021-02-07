<?php

namespace App\Utils;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class JsonResponse
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function success($content)
    {
        return new Response($this->serializer->serialize($content, 'json'), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
