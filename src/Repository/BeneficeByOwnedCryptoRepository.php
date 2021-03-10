<?php

namespace App\Repository;

use App\Entity\BeneficeByOwnedCrypto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BeneficeByOwnedCrypto|null find($id, $lockMode = null, $lockVersion = null)
 * @method BeneficeByOwnedCrypto|null findOneBy(array $criteria, array $orderBy = null)
 * @method BeneficeByOwnedCrypto[]    findAll()
 * @method BeneficeByOwnedCrypto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeneficeByOwnedCryptoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BeneficeByOwnedCrypto::class);
    }


    public function findByPlateforme($plateformeCode)
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.ownedCrypto', 'owc')
            ->leftJoin('owc.plateforme', 'pl')
            ->andWhere('pl.code = :plateforme')
            ->setParameter('plateforme', $plateformeCode)
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?BeneficeByOwnedCrypto
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
