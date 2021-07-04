<?php

namespace App\Repository;

use App\Entity\ImgToProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImgToProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImgToProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImgToProduct[]    findAll()
 * @method ImgToProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImgToProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImgToProduct::class);
    }

    // /**
    //  * @return ImgToProduct[] Returns an array of ImgToProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImgToProduct
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
