<?php

namespace App\Repository;

use App\Entity\Cryptocurrency;
use App\Entity\OwnedCrypto;
use App\Entity\Plateforme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OwnedCrypto|null find($id, $lockMode = null, $lockVersion = null)
 * @method OwnedCrypto|null findOneBy(array $criteria, array $orderBy = null)
 * @method OwnedCrypto[]    findAll()
 * @method OwnedCrypto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnedCryptoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OwnedCrypto::class);
    }

    public function findOneByPlateforme(string $plateformeCode): array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.plateforme', 'pf')
            ->leftJoin('o.crytocurrency', 'crypto')
            ->andWhere('pf.code = :plateforme')
            ->setParameter('plateforme', $plateformeCode)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findOneByPlateformeAndCryptoCurrency(string $plateformeCode, string $cryptoCurrencyCode): ?OwnedCrypto
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.plateforme', 'pf')
            ->leftJoin('o.crytocurrency', 'crypto')
            ->andWhere('pf.code = :plateforme')
            ->andWhere('crypto.code = :cryptoCurrency')
            ->setParameter('plateforme', $plateformeCode)
            ->setParameter('cryptoCurrency', $cryptoCurrencyCode)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
