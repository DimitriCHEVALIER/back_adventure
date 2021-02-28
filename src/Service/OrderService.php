<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OwnedCrypto;
use App\Repository\OwnedCryptoRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    const ADD_AMOUNT = 1;
    const WITHDRAW_AMOUNT = -1;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createOrder(Order $order)
    {
        $this->entityManager->persist($order);
        /** @var OwnedCryptoRepository $ownedCryptoRepo */
        $ownedCryptoRepo = $this->entityManager->getRepository(OwnedCrypto::class);
        $ownedCryptoFrom = $ownedCryptoRepo->findOneByPlateformeAndCryptoCurrency($order->getPlateforme(), $order->getOriginalCurrency());
        $ownedCryptoTo = $ownedCryptoRepo->findOneByPlateformeAndCryptoCurrency($order->getPlateforme(), $order->getNewCurrency());
        $this->updateOwnedCryptoCurrency($ownedCryptoFrom, $order->getAmountOldCurrency(), self::WITHDRAW_AMOUNT);
        dump($ownedCryptoFrom);

        if (null === $ownedCryptoTo) {
            $this->createOwnedCryptoCurrency($order);
        } elseif (null !== $ownedCryptoTo) {
            $this->updateOwnedCryptoCurrency($ownedCryptoTo, $order->getAmountNewCurrency(), self::ADD_AMOUNT);
        }

        $this->entityManager->flush();

        return $order;
    }

    private function createOwnedCryptoCurrency(Order $order)
    {
        $ownedCryptoCurrency = new OwnedCrypto();
        $ownedCryptoCurrency->setPlateforme($order->getPlateforme());
        $ownedCryptoCurrency->setAmount($order->getAmountNewCurrency());
        $ownedCryptoCurrency->setCrytocurrency($order->getNewCurrency());
        //todo calculer le amount origin
        $ownedCryptoCurrency->setEuroAmountOrigin(0);
        $this->entityManager->persist($ownedCryptoCurrency);
    }

    private function updateOwnedCryptoCurrency(OwnedCrypto $ownedCrypto, $amount, $action)
    {
        $ownedCrypto->setAmount($ownedCrypto->getAmount() + $action * $amount);
        //todo calculer le amount origin
    }
}
