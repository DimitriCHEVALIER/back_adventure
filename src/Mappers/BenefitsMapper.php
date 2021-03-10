<?php

namespace App\Mappers;

use App\Entity\BeneficeByOwnedCrypto;
use App\Entity\OwnedCrypto;
use Doctrine\ORM\EntityManagerInterface;

class BenefitsMapper
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function contentToBenefit($content): ?BeneficeByOwnedCrypto
    {
        $benefit = new BeneficeByOwnedCrypto();
        if (property_exists($content, 'ownedCryptoId') && property_exists($content, 'amountSold') &&
            property_exists($content, 'tauxVente') && property_exists($content, 'beneficeNet')) {
            $benefit->setAmountSold($content->amountSold);
            $benefit->setBeneficeNet($content->beneficeNet);
            $benefit->setTauxVente($content->tauxVente);
            if ($content->beneficeNet > 0) {
                $benefit->setImpot($content->beneficeNet * 0.3);
            } else {
                $benefit->setImpot(0);
            }
            /** @var OwnedCrypto $ownedCrypto */
            $ownedCrypto = $this->entityManager->getRepository(OwnedCrypto::class)->find($content->ownedCryptoId);
            $benefit->setOwnedCrypto($ownedCrypto);
            return $benefit;
        }

        return null;
    }
}
