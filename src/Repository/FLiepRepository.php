<?php

namespace App\Repository;

use App\Entity\FLiep;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FLiep>
 *
 * @method FLiep|null find($id, $lockMode = null, $lockVersion = null)
 * @method FLiep|null findOneBy(array $criteria, array $orderBy = null)
 * @method FLiep[]    findAll()
 * @method FLiep[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FLiepRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FLiep::class);
    }

//    /**
//     * @return FLiep[] Returns an array of FLiep objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FLiep
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
