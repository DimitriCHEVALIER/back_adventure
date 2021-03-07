<?php

namespace App\Service;

use App\Entity\Cryptocurrency;
use App\Entity\Order;
use App\Entity\OwnedCrypto;
use App\Repository\OwnedCryptoRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    const ADD_AMOUNT = 1;
    const WITHDRAW_AMOUNT = -1;
    private $entityManager;
    private $euroEqToTransfer = 0;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createOrder(Order $order)
    {
        $this->entityManager->persist($order);
        /** @var OwnedCryptoRepository $ownedCryptoRepo */
        $ownedCryptoRepo = $this->entityManager->getRepository(OwnedCrypto::class);
        $ownedCryptoFrom = $ownedCryptoRepo->findOneByPlateformeAndCryptoCurrency($order->getPlateforme()->getCode(), $order->getOriginalCurrency()->getCode());
        $ownedCryptoTo = $ownedCryptoRepo->findOneByPlateformeAndCryptoCurrency($order->getPlateforme()->getCode(), $order->getNewCurrency()->getCode());

        $this->euroEqToTransfer = $this->getEuroInserted($order);
        $this->updateOwnedCryptoCurrency($ownedCryptoFrom, $order, self::WITHDRAW_AMOUNT);

        if (null === $ownedCryptoTo) {
            $this->createOwnedCryptoCurrency($order);
        } elseif (null !== $ownedCryptoTo) {
            $this->updateOwnedCryptoCurrency($ownedCryptoTo, $order, self::ADD_AMOUNT);
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
        $ownedCryptoCurrency->setEuroAmountOrigin($this->euroEqToTransfer);
        $this->entityManager->persist($ownedCryptoCurrency);
    }

    private function updateOwnedCryptoCurrency(OwnedCrypto $ownedCrypto, Order $order, $action)
    {
        $ownedCrypto->setAmount($ownedCrypto->getAmount() + $action * $this->getAmountToUpdate($order, $action));
        $ownedCrypto->setEuroAmountOrigin($ownedCrypto->getEuroAmountOrigin() + $action * $this->euroEqToTransfer);
    }

    private function getAmountToUpdate(Order $order, $action)
    {
        if (self::WITHDRAW_AMOUNT === $action) {
            return $order->getAmountOldCurrency();
        }


        return $order->getAmountNewCurrency();
    }

    private function getEuroInserted(Order $order)
    {
        if ($order->getOriginalCurrency() && Cryptocurrency::EURO_CODE === $order->getOriginalCurrency()->getCode()) {
            return $order->getAmountOldCurrency();
        } elseif ($order->getOriginalCurrency() && Cryptocurrency::EURO_CODE !== $order->getOriginalCurrency()->getCode()) {
            /** @var OwnedCryptoRepository $ownedCryptoRepo */
            $ownedCryptoRepo = $this->entityManager->getRepository(OwnedCrypto::class);
            $cryptoBought = $ownedCryptoRepo->findOneByPlateformeAndCryptoCurrency($order->getPlateforme()->getCode(), $order->getOriginalCurrency()->getCode());

            return ($order->getAmountOldCurrency() / $cryptoBought->getAmount()) * $cryptoBought->getEuroAmountOrigin();
        }

        return 0;
    }
}
