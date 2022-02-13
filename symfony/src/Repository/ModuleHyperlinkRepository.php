<?php

namespace App\Repository;

use App\Entity\ModuleHyperlink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ModuleHyperlink|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleHyperlink|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleHyperlink[]    findAll()
 * @method ModuleHyperlink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleHyperlinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModuleHyperlink::class);
    }

    // /**
    //  * @return ModuleHyperlink[] Returns an array of ModuleHyperlink objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModuleHyperlink
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
