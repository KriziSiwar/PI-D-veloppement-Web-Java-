<?php

namespace App\Repository;

use App\Entity\PostedJobs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostedJobs>
 *
 * @method PostedJobs|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostedJobs|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostedJobs[]    findAll()
 * @method PostedJobs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostedJobsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostedJobs::class);
    }

//    /**
//     * @return PostedJobs[] Returns an array of PostedJobs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PostedJobs
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
