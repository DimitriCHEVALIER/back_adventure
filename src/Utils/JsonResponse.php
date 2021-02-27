<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class JsonResponse
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function success($content, $groups = null)
    {
        $parameters['groups'] = $groups;

        return new Response($this->serializer->serialize($content, 'json', $parameters),
            Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    public function error($error)
    {
        return new Response($error, Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'application/json']);
    }
}
