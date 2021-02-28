<?php

namespace App\Service;

use App\Entity\Cryptocurrency;
use Doctrine\ORM\EntityManagerInterface;

class CryptoCurrencyService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createCrypto($code, $name)
    {
        $newCrypto = new Cryptocurrency();
        $newCrypto->setCode($code);
        $newCrypto->setName($name);
        $this->entityManager->persist($newCrypto);
        $this->entityManager->flush();
        return $newCrypto;
    }
}
