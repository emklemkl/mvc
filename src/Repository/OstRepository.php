<?php

namespace App\Repository;

use App\Entity\Ost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ost>
 *
 * @method Ost|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ost|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ost[]    findAll()
 * @method Ost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OstRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ost::class);
    }

    /**
     * Find all ost having a value above the specified one.
     * 
     * @return Ost[] Returns an array of ost objects
     */
    public function findByMinimumValue($value): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.value >= :value')
            ->setParameter('value', $value)
            ->orderBy('p.value', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Find all producs having a value above the specified one with SQL.
     * 
     * @return [][] Returns an array of arrays (i.e. a raw data set)
     */
    public function findByMinimumValue2($value): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM ost AS o
        WHERE o.value >= :value
        ORDER BY o.value ASC
    ';

        $resultSet = $conn->executeQuery($sql, ['value' => $value]);

        return $resultSet->fetchAllAssociative();
    }
//    /**
//     * @return Ost[] Returns an array of Ost objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ost
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
