<?php

namespace App\Repository;

use App\Entity\Guideline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Guideline|null find($id, $lockMode = null, $lockVersion = null)
 * @method Guideline|null findOneBy(array $criteria, array $orderBy = null)
 * @method Guideline[]    findAll()
 * @method Guideline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuidelineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Guideline::class);
    }

    public function findAllWithGuidelineNavigations() {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT g, gn
            FROM App\Entity\Guideline g
            LEFT JOIN g.guidelineNavigations gn
            ORDER BY g.title'
        );

        return $query->getResult();
    }

    // /**
    //  * @return Guideline[] Returns an array of Guideline objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Guideline
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
