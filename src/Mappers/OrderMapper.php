<?php

namespace App\Mappers;

use App\Entity\Cryptocurrency;
use App\Entity\Order;
use App\Entity\Plateforme;
use Doctrine\ORM\EntityManagerInterface;

class OrderMapper
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function contentToOrder($content): ?Order
    {
        $order = new Order();
        if (property_exists($content, 'amountFistCurrency') && property_exists($content, 'amountFinalCurrency') &&
            property_exists($content, 'selectedTo') && property_exists($content, 'selectedFrom') &&
            property_exists($content, 'selectedPlateforme')) {
            $order->setAmountNewCurrency($content->amountFinalCurrency);
            $order->setAmountOldCurrency($content->amountFistCurrency);
            $originalCurrency = $this->entityManager->getRepository(Cryptocurrency::class)->findOneByCode($content->selectedFrom);
            $newCurrency = $this->entityManager->getRepository(Cryptocurrency::class)->findOneByCode($content->selectedTo);
            $codePlateforme = $content->selectedPlateforme;
            if (property_exists($codePlateforme, 'code')) {
                $codePlateforme = $codePlateforme->code;
            }
            $plateforme = $this->entityManager->getRepository(Plateforme::class)->findOneByCode($codePlateforme);
            $order->setOriginalCurrency($originalCurrency);
            $order->setNewCurrency($newCurrency);
            $order->setPlateforme($plateforme);

            return $order;
        }

        return null;
    }
}
