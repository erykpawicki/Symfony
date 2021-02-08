<?php

namespace App\Repository;

use App\Entity\Rodzaj;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rodzaj|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rodzaj|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rodzaj[]    findAll()
 * @method Rodzaj[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RodzajRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rodzaj::class);
    }

    // /**
    //  * @return Rodzaj[] Returns an array of Rodzaj objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rodzaj
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
