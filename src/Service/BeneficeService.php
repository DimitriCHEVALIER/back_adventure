<?php

namespace App\Service;

use App\Entity\BeneficeByOwnedCrypto;
use Doctrine\ORM\EntityManagerInterface;

class BeneficeService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handleCreateBenefice(BeneficeByOwnedCrypto $beneficeByOwnedCrypto)
    {
        $ownedCryptoToModify = $beneficeByOwnedCrypto->getOwnedCrypto();
        $ownedCryptoToModify->setAverageEuroEq(
            $ownedCryptoToModify->getAverageEuroEq() *
            $beneficeByOwnedCrypto->getAmountSold() / $ownedCryptoToModify->getAmount());
        $ownedCryptoToModify->setAmount($ownedCryptoToModify->getAmount() - $beneficeByOwnedCrypto->getAmountSold());
        $this->entityManager->persist($beneficeByOwnedCrypto);
        $this->entityManager->flush();

        return $beneficeByOwnedCrypto;
    }
}
