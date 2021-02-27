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

    public function success($content, $groups = null)
    {
        $parameters = [
            'Content-Type' => 'application/json',
        ];
        if (null !== $groups) {
            $parameters['groups'] = $groups;
        }

        return new Response($this->serializer->serialize($content, 'json'), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    public function error($error)
    {
        return new Response($error, Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'application/json']);
    }
}
