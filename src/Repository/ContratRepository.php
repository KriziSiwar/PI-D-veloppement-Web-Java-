<?php

namespace App\Repository;

use App\Entity\Contrat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contrat>
 *
 * @method Contrat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contrat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contrat[]    findAll()
 * @method Contrat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contrat::class);
    }

//    /**
//     * @return Contrat[] Returns an array of Contrat objects
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

//    public function findOneBySomeField($value): ?Contrat
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function countByStatut()
{
    return $this->createQueryBuilder('c')
        ->select('c.statut, COUNT(c.id) as total')
        ->groupBy('c.statut')
        ->getQuery()
        ->getResult();
}
public function sumMontantByProjet()
{
    return $this->createQueryBuilder('c')
        ->select('c.projet, SUM(c.montant) as totalMontant')
        ->groupBy('c.projet')
        ->getQuery()
        ->getResult();
}

/*public function findContractsByYear()
    {

        $contracts = $this->createQueryBuilder('c')
        ->select('c.date_debut as date_debut') // Sélectionnez la date directement
        ->addSelect('COUNT(c.id) as nombreContrats')
        ->groupBy('date_debut')
        ->getQuery()
        ->getResult();

    $result = [];
    foreach ($contracts as $contract) {
        $year = $contract['date_debut']->format('Y'); // Extraire l'année de la date
        if (!isset($result[$year])) {
            $result[$year] = 0;
        }
        $result[$year] += $contract['nombreContrats'];
    }

    return $result;
    }*/
    public function findContractsByYear($startDate, $endDate)
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.date_debut BETWEEN :startDate AND :endDate')
        ->setParameter('startDate', $startDate)
        ->setParameter('endDate', $endDate)
        ->getQuery()
        ->getResult();
}

public function findContractsByDateRange($startDate, $endDate)
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.date_debut BETWEEN :startDate AND :endDate')
        ->setParameter('startDate', $startDate)
        ->setParameter('endDate', $endDate)
        ->getQuery()
        ->getResult();
}

public function searchContrats(string $criteria, string $searchTerm): array
    {
        $queryBuilder = $this->createQueryBuilder('c');

        // Construisez la requête en fonction des critères de recherche
        switch ($criteria) {
            case 'date_debut':
                $queryBuilder->andWhere('c.dateDebut LIKE :searchTerm')
                             ->setParameter('searchTerm', '%' . $searchTerm . '%');
                break;
            case 'date_fin':
                $queryBuilder->andWhere('c.dateFin LIKE :searchTerm')
                             ->setParameter('searchTerm', '%' . $searchTerm . '%');
                break;
            case 'montant':
                $queryBuilder->andWhere('c.montant LIKE :searchTerm')
                             ->setParameter('searchTerm', '%' . $searchTerm . '%');
                break;
            case 'statut':
                $queryBuilder->andWhere('c.statut LIKE :searchTerm')
                             ->setParameter('searchTerm', '%' . $searchTerm . '%');
                break;
            case 'projet':
                $queryBuilder->andWhere('c.projet LIKE :searchTerm')
                             ->setParameter('searchTerm', '%' . $searchTerm . '%');
                break;
            // Ajoutez plus de cas pour d'autres critères si nécessaire
        }

        // Exécutez la requête et retournez les résultats
        return $queryBuilder->getQuery()->getResult();
    }



    }

