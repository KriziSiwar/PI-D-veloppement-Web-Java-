<?php

namespace App\Repository;

use App\Entity\AssignedJobs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssignedJobs>
 *
 * @method AssignedJobs|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssignedJobs|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssignedJobs[]    findAll()
 * @method AssignedJobs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssignedJobsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssignedJobs::class);
    }

//    /**
//     * @return AssignedJobs[] Returns an array of AssignedJobs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AssignedJobs
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
