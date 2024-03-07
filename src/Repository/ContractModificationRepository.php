<?php

namespace App\Repository;

use App\Entity\ContractModification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContractModification>
 *
 * @method ContractModification|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractModification|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractModification[]    findAll()
 * @method ContractModification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractModificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractModification::class);
    }

//    /**
//     * @return ContractModification[] Returns an array of ContractModification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ContractModification
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findByContractId($id)
    {
        return $this->createQueryBuilder('cm')
            ->andWhere('cm.contract = :contractId')
            ->setParameter('contractId', $id)
            ->getQuery()
            ->getResult();
    }
}
