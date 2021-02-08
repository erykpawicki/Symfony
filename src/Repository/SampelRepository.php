<?php

namespace App\Repository;

use App\Entity\Sampel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sampel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sampel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sampel[]    findAll()
 * @method Sampel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SampelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sampel::class);
    }

    // /**
    //  * @return Sampel[] Returns an array of Sampel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sampel
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
