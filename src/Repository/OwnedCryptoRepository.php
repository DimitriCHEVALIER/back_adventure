<?php

namespace App\Repository;

use App\Entity\OwnedCrypto;
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

    // /**
    //  * @return OwnedCrypto[] Returns an array of OwnedCrypto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OwnedCrypto
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}