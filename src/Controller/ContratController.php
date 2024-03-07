<?php

namespace App\Controller;
use App\Entity\ContractModification;
use Doctrine\ORM\EntityManagerInterface;

//use App\Entity\ContractModification;
//use Khill\Lavacharts\Lavacharts;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Workflow\WorkflowInterface;
use App\Entity\Contrat;
//use App\Entity\Contrat;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\Routing\Annotation\Route;
 use App\Form\ContratType;
use App\Repository\ContractModificationRepository;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
 use Symfony\UX\Chartjs\Model\Chart;
 use Illuminate\Support\ServiceProvider;
use DateTime;

use App\Repository\ContratRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\AnnotationChart;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Builder\Interface_;

class ContratController extends AbstractController
{
    

    #[Route('/graph', name: 'app_mon_graphique')]
    public function indexAction():Response
    {
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
             ['Work',     11],
             ['Eat',      2],
             ['Commute',  2],
             ['Watch TV', 2],
             ['Sleep',    7]
            ]
        );
        $pieChart->getOptions()->setTitle('My Daily Activities');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
    
        return $this->render('Contrat/index1.html.twig', array('piechart' => $pieChart));
    }
// ContratController.php
#[Route('/stats', name: 'app_mon_stats')]
public function ContratStats(): Response
{
    // Récupérez les données des Contrats depuis votre base de données
    $Contrats = $this->getDoctrine()->getRepository(Contrat::class)->findAll();

    // Initialisez un tableau pour stocker les statistiques des Contrats
    $stats = [
        'En cours' => 0,
        'Terminé' => 0,
        'Reporté' => 0,
        // Ajoutez d'autres statuts si nécessaire
    ];

    // Calculez les statistiques des Contrats
    foreach ($Contrats as $Contrat) {
        $statut = $Contrat->getStatut();

        // Vérifiez si la clé existe dans le tableau $stats
        if (array_key_exists($statut, $stats)) {
            $stats[$statut]++;
        } else {
            // Si la clé n'existe pas, vous pouvez choisir de l'ignorer ou de la gérer d'une autre manière
            // Ici, nous ajoutons le statut inconnu dans le tableau $stats avec une valeur de 1
            $stats[$statut] = 1;
        }
    }
   

    // Créez le Pie Chart
    $pieChart = new PieChart();
    $pieChart->getData()->setArrayToDataTable([
        ['Statut', 'Nombre de Contrats'],
        ['En cours', $stats['En cours']],
        ['Terminé', $stats['Terminé']],
        ['Reporté', $stats['Reporté']],
        // Ajoutez d'autres statuts si nécessaire
    ]);
    $pieChart->getOptions()->setTitle('Répartition des Contrats par statut');

    // Renvoyez la vue avec le Pie Chart
    return $this->render('Contrat/stats.html.twig', [
        'pieChart' => $pieChart,
        'stats' => $stats,
    ]);
}





#[Route('/year', name: 'app_mon_year')]
public function contractsbyStats(ContratRepository $ContratRepository): Response
{
    // Récupérez les données des Contrats depuis votre base de données
    $Contrats=$ContratRepository->findAll();

    // Initialisez un tableau pour stocker les statistiques des Contrats par année
    $ContratsParAnnee = [];

    // Calculez les statistiques des Contrats par année entre 2017 et 2024
    for ($annee = 2017; $annee <= 2024; $annee++) {
        $ContratsParAnnee[$annee] = 0;
    }

    // Calculez les statistiques des Contrats par année
    foreach ($Contrats as $Contrat) {
        $dateDebut = $Contrat->getDateDebut();
        if ($dateDebut !== null) {
            $annee = $dateDebut->format('Y');

            // Vérifiez si l'année est entre 2017 et 2024
            if ($annee >= 2017 && $annee <= 2024) {
                $ContratsParAnnee[$annee]++;
            }
        }
    }

    // Créez le Pie Chart
    $pieChart = new PieChart();
    $dataArray = [['Année', 'Nombre de Contrats']];
    for ($annee = 2017; $annee <= 2024; $annee++) {
        $dataArray[] = [$annee, $ContratsParAnnee[$annee]];
    }
    $pieChart->getData()->setArrayToDataTable($dataArray);
    $pieChart->getOptions()->setTitle('Répartition des Contrats par année (2017-2024)');

    // Renvoyez la vue avec le Pie Chart
    return $this->render('Contrat/contracts_by_year.html.twig', [
        'pieChart' => $pieChart,
        'stats' => $ContratsParAnnee, // Envoyez les statistiques des Contrats par année à la vue
    ]);
}













#[Route('/statsbyfreelance', name: 'app_stats_by_freelance')]
public function ContratStatsByFreelance(ContratRepository $crepo): Response
{
    // Récupérez les données des Contrats depuis votre base de données
    $Contrats = $crepo->findAll();

    // Initialisez un tableau pour stocker les statistiques des Contrats par freelance
    $stats = [];

    // Calculez les statistiques des Contrats par freelance
    foreach ($Contrats as $Contrat) {
        $freelancer = $Contrat->getFreelancer();
        // Calcul des statistiques...

        // Exemple de calcul : nombre de Contrats par freelance
        if (!isset($stats[$freelancer])) {
            $stats[$freelancer] = 0;
        }
        $stats[$freelancer]++;
    }

    // Renvoyez les données au template Twig pour affichage
    return $this->render('Contrat/stats_by_freelance.html.twig', [
        'stats' => $stats,
    ]);}

    #[Route('/Contrat', name: 'app_Contrat')]
    public function index(): Response
    {
        return $this->render('Contrat/index.html.twig', [
            'controller_name' => 'ContratController',
        ]);
    }


    #[Route('/statsbyorganisation', name: 'app_stats_by_organisation')]
    public function contratStatsByOrganisation(ContratRepository $crepo): Response
    {
        // Récupérer les données des contrats depuis votre base de données
        $contrats = $crepo->findAll();

        // Initialiser un tableau pour stocker les statistiques des contrats par organisation
        $stats = [];

        // Calculez les statistiques des contrats par organisation
        foreach ($contrats as $contrat) {
            $organisation = $contrat->getOrganisation();

            // Vérifiez si l'organisation existe dans le tableau $stats
            if (!isset($stats[$organisation->getNom()])) {
                // Si l'organisation n'existe pas, initialisez-la à 0
                $stats[$organisation->getNom()] = 0;
            }

            // Incrémenter le compteur pour cette organisation
            $stats[$organisation->getNom()]++;
        }

        // Créez le Pie Chart
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable([
            ['Organisation', 'Nombre de contrats'],
            // Convertissez les statistiques en format requis pour le Pie Chart
            ...array_map(fn ($organisation, $nombreContrats) => [$organisation, $nombreContrats], array_keys($stats), array_values($stats))
        ]);
        $pieChart->getOptions()->setTitle('Répartition des contrats par organisation');

        // Renvoyez la vue avec le Pie Chart
        return $this->render('contrat/stats_by_organisation.html.twig', [
            'pieChart' => $pieChart,
            'stats' => $stats,
        ]);
    }




    #[Route('/statsbymontant', name: 'app_stats_by_montant')]
    public function contratStatsByMontant(ContratRepository $crepo): Response
    {
        // Récupérer les données des contrats depuis votre base de données
        $contrats = $crepo->findAll();

        // Initialiser un tableau pour stocker les statistiques des contrats par tranche de montant
        $stats = [
            'Montant entre 20 et 50' => 0,
            'Montant entre 50 et 100' => 0,
            'Montant entre 100 et 150' => 0,
            'Montant supérieur à 150' => 0,
        ];

        // Calculez les statistiques des contrats par tranche de montant
        foreach ($contrats as $contrat) {
            $montant = $contrat->getMontant();

            if ($montant >= 20 && $montant < 50) {
                $stats['Montant entre 20 et 50']++;
            } elseif ($montant >= 50 && $montant < 100) {
                $stats['Montant entre 50 et 100']++;
            } elseif ($montant >= 100 && $montant < 150) {
                $stats['Montant entre 100 et 150']++;
            } elseif ($montant >= 150) {
                $stats['Montant supérieur à 150']++;
            }
        }

        // Créez le Pie Chart
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable([
            ['Tranche de montant', 'Nombre de contrats'],
            // Convertissez les statistiques en format requis pour le Pie Chart
            ['Montant entre 20 et 50', $stats['Montant entre 20 et 50']],
            ['Montant entre 50 et 100', $stats['Montant entre 50 et 100']],
            ['Montant entre 100 et 150', $stats['Montant entre 100 et 150']],
            ['Montant supérieur à 150', $stats['Montant supérieur à 150']],
        ]);
        $pieChart->getOptions()->setTitle('Répartition des contrats par tranche de montant');

        // Renvoyez la vue avec le Pie Chart
        return $this->render('contrat/stats_by_montant.html.twig', [
            'pieChart' => $pieChart,
            'stats' => $stats,
        ]);
    }





    #[Route('/statsorganisation', name: 'app_stats_organisation')]
    public function contratStatsBydomainOrganisation(): Response
    {
        // Récupérer les données des contrats depuis la base de données
        $contrats = $this->getDoctrine()->getRepository(Contrat::class)->findAll();

        // Initialisez un tableau pour stocker les statistiques des contrats par domaine d'activité de l'organisation
        $stats = [
            'Développement Web et Mobile' => 0,
            'Design et Créativité' => 0,
            'Rédaction et Traduction' => 0,
            'Marketing et Ventes' => 0,
            'Support Administratif' => 0,
            'Consulting et Business' => 0,
            'Technologie et Sciences' => 0,
            'Vidéo et Animation' => 0,
        ];

        // Calculez les statistiques des contrats par domaine d'activité de l'organisation
        foreach ($contrats as $contrat) {
            $organisation = $contrat->getOrganisation();
            if ($organisation) {
                $domaineActivite = $organisation->getDomaineActivite();
                if (array_key_exists($domaineActivite, $stats)) {
                    $stats[$domaineActivite]++;
                } else {
                    // Si le domaine d'activité n'existe pas dans le tableau $stats, ignorez-le ou gérez-le d'une autre manière
                }
            }
        }

        // Créez le Pie Chart
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable([
            ['Domaine d\'activité', 'Nombre de contrats'],
            ['Développement Web et Mobile', $stats['Développement Web et Mobile']],
            ['Design et Créativité', $stats['Design et Créativité']],
            ['Rédaction et Traduction', $stats['Rédaction et Traduction']],
            ['Marketing et Ventes', $stats['Marketing et Ventes']],
            ['Support Administratif', $stats['Support Administratif']],
            ['Consulting et Business', $stats['Consulting et Business']],
            ['Technologie et Sciences', $stats['Technologie et Sciences']],
            ['Vidéo et Animation', $stats['Vidéo et Animation']],
        ]);
        $pieChart->getOptions()->setTitle('Répartition des contrats par domaine d\'activité de l\'organisation');

        // Renvoyez la vue avec le Pie Chart
        return $this->render('contrat/statsdomainorganisation.html.twig', [
            'pieChart' => $pieChart,
            'stats' => $stats,
        ]);
    }

    
    #[Route('/explorez_contrats', name: 'acceuil_contrats')]
    public function acceuil(): Response
    {
        return $this->render('contrat/acceuil.html.twig', [
            'controller_name' => 'ContratController',
        ]);
    }
    


        /**
         * @Route("/contract/new", name="contract_new")
         */

         #[Route('/contract/new', name: 'contract/new')]
        public function new(Request $request): Response
        {
            
            $contract = new Contrat();
    
           
            $form = $this->createForm(ContratType::class, $contract);
    
            
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
               
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($contract);
                $entityManager->flush();
    
               
                return $this->redirectToRoute('contract/show');
            }
    
           
            return $this->render('contrat/add.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    


       /* #[Route('/contract/show', name: 'contract/show')]
        public function show(): Response
        {
            $entityManager = $this->getDoctrine()->getManager();
            $contratRepository = $entityManager->getRepository(Contrat::class);
            $contrats = $contratRepository->findAll();
        
            // Vérifier si le bouton "Payer" n'a pas été cliqué pour chaque contrat depuis 3 jours
            $now = new \DateTime();
            $boutonAjouterContratDesactive = false; // Définir la variable par défaut
        
            foreach ($contrats as $contrat) {
                // Si le contrat est éligible au paiement et n'a pas encore été payé
                if ($contrat->date_fin->diff($now)->days >= 3 && !$contrat->isPaye()) {
                    // Désactiver les boutons "Modifier" et "Ajouter"
                    $contrat->setBoutonsDesactives(true);
                    // Mettre à jour la variable boutonAjouterContratDesactive si nécessaire
                    $boutonAjouterContratDesactive = true;
                }
            }
        
            return $this->render('contrat/show.html.twig', [
                'contrats' => $contrats,
                'boutonAjouterContratDesactive' => $boutonAjouterContratDesactive // Passer la variable au modèle Twig
            ]);
    }*/
      
        #[Route('/contract/show', name: 'contract/show')]
        public function show(Request $request): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $contratRepository = $entityManager->getRepository(Contrat::class);
    $contrats = $contratRepository->findAll();

    // Initialiser le compteur de contrats non payés depuis au moins trois jours
    $nonPayesDepuisTroisJours = 0;
   
    foreach ($contrats as $contrat) {
        // Comparer la date de fin avec la date actuelle
        $dateFin = $contrat->date_fin;
        $maintenant = new \DateTime();
        $joursEcoules = $maintenant->diff($dateFin)->days;
        $criteria = $request->request->get('criteria');
        $searchTerm = $request->request->get('search');
        if ($criteria === null) {
            $criteria = ''; // ou tout autre valeur par défaut que vous souhaitez utiliser
        }
        if ($searchTerm === null) {
            $searchTerm = ''; // ou tout autre valeur par défaut que vous souhaitez utiliser
        }
    
        // Effectuer la recherche en fonction des critères et du terme de recherche
       
    
        
        // Vérifier si le contrat est éligible au paiement
        if ($joursEcoules >= 3 && !$contrat->isPaye()) {
            // Activer le bouton "Payer" pour ce contrat
            $contrat->setPaye(true);
            // Incrémenter le compteur des contrats non payés depuis au moins trois jours
            $nonPayesDepuisTroisJours++;
        } else {
            $contrat->setPaye(false);
        }
    }
    $contrats = $contratRepository->searchContrats($criteria, $searchTerm);
    // Vérifier si le bouton "Ajouter contrat" doit être désactivé
    if ($nonPayesDepuisTroisJours >= 3) {
        $boutonAjouterContratDesactive = true;
    } else {
        $boutonAjouterContratDesactive = false;
    }
  
    return $this->render('contrat/show.html.twig', [
        'contrats' => $contrats,
        'boutonAjouterContratDesactive' => $boutonAjouterContratDesactive
    ]);
        }


        #[Route('/search-contrats', name: 'app_search_contrats', methods: ['POST'])]
        public function searchContrats(Request $request, ContratRepository $contratRepository): JsonResponse
        {
            $criteria = $request->request->get('criteria');
            $searchTerm = $request->request->get('search');
        
            // Utilisez $criteria et $searchTerm pour interroger votre base de données et récupérer les résultats
            $contrats = $contratRepository->searchContrats($criteria, $searchTerm);
        
            $jsonData = [];
            foreach ($contrats as $contrat) {
                $jsonData[] = [
                    'id' => $contrat->getId(),
                    'date_debut' => $contrat->getDateDebut()->format('Y-m-d'),
                    'date_fin' => $contrat->getDateFin()->format('Y-m-d'),
                    'montant' => $contrat->getMontant(),
                    'statut' => $contrat->getStatut(),
                    'projet' => $contrat->getProjet(),
                    'freelancer' => $contrat->getFreelancer(),
                    'organisation' => $contrat->getOrganisation(),
                    'user' => $contrat->getUser()->getFirstName(), // Assurez-vous que cette relation est correctement définie dans votre entité Contrat
                    'date_creation' => $contrat->getDateCreation()->format('Y-m-d'),
                    'description' => $contrat->getDescription(),
                    'paye' => $contrat->isPaye(),
                    // Ajoutez plus de champs si nécessaire
                ];
            }
        
            // Renvoie les résultats de la recherche sous forme de réponse JSON
            return new JsonResponse($jsonData);
        }
        








        

       
        #[Route('/contract/stats', name: 'contract_stats')]
        public function showStats(ContratRepository $contratRepository): Response
        {



            
            // Récupérer les données nécessaires depuis le repository
            $contratsParStatut = $contratRepository->countByStatut();
            $montantTotalParProjet = $contratRepository->sumMontantByProjet();
    
            // Créer le graphique de répartition des contrats par statut
            $pieChart = new PieChart();
            $pieChart->getData()->setArrayToDataTable([
                ['Statut', 'Nombre de Contrats'],
                ['En cours', $contratsParStatut['En cours'] ?? 0],
                ['Terminé', $contratsParStatut['Terminé'] ?? 0],
            ]);
            $pieChart->getOptions()->setTitle('Répartition des Contrats par Statut');
    
            // Passer les données à la vue Twig
            return $this->render('contrat/stats.html.twig', [
                'google_charts' => $pieChart,
                'montantTotalParProjet' => $montantTotalParProjet,
            ]);
        }
/*#[Route('/contract/stats', name: 'contract_stats')]
public function showStats(ContratRepository $contratRepository): Response
{
    
    $contratsParStatut = $contratRepository->countByStatut();

// Vérifier si les clés 'En cours' et 'Terminé' existent dans $contratsParStatut
$enCours = isset($contratsParStatut['En cours']) ? $contratsParStatut['En cours'] : 0;
$termine = isset($contratsParStatut['Terminé']) ? $contratsParStatut['Terminé'] : 0;

$montantTotalParProjet = $contratRepository->sumMontantByProjet();


$pieChart = $lava->DataTable();
$pieChart->addStringColumn('Statut')
    ->addNumberColumn('Nombre de Contrats')
    ->addRow(['En cours', $enCours])
    ->addRow(['Terminé', $termine]);

$lava->PieChart('google_charts')
    ->setOptions([
        'title' => 'Répartition des Contrats par Statut',
    ]);
// Passer les données à la vue Twig
return $this->render('contrat/stats.html.twig', [
    'google_charts' => $lava->render('PieChart', 'google_charts'),
    'montantTotalParProjet' => $montantTotalParProjet,
]);

}

*/

        
        #[Route('/contract/edit/{id}', name: 'contract/edit')]
        public function edit(Request $request, int $id): Response
        {
            
            $entityManager = $this->getDoctrine()->getManager();
            $contrat = $entityManager->getRepository(Contrat::class)->find($id);
        
           
            if (!$contrat) {
                throw $this->createNotFoundException('Contrat non trouvé pour l\'identifiant '.$id);
            }
        
            
            $form = $this->createForm(ContratType::class, $contrat);
            $form->handleRequest($request);
        
            
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();
                return $this->redirectToRoute('contract/show', ['id' => $contrat->getId()]);
            }
        
            
            return $this->render('contrat/edit.html.twig', [
                'contract' => $contrat,
                'form' => $form->createView(),
            ]);
        }
        
        
    
       
       

    
        
        #[Route('/delete/{id}', name: 'contract/delete')]
        public function deleteContrat($id, ManagerRegistry $manager, ContratRepository $cRepo): Response
          {
          $entityManager = $manager->getManager();
    

           $contrat = $cRepo->find($id);
    
   
             if ($contrat) {
            $entityManager->remove($contrat);
              $entityManager->flush();
                 } else
        
              {return new Response("L'entité avec l'ID $id n'a pas été trouvée.", Response::HTTP_NOT_FOUND);}
    

    
                  return $this->redirectToRoute('contract/show');
                   }

                  

                  
                  
                  
                  
                  
                  
                  
                  
    
                       #[Route('/contrat_back', name: 'app_contrat_back')]
                       public function index_back(): Response
                       {
                           return $this->render('contrat_back/index.html.twig', [
                               'controller_name' => 'ContratController',
                           ]);
                       }
                       
                     
                     
                     
                     
                     
                     
                       
                       
                   
                           
                            
                   
                            #[Route('/contract_back/new', name: 'contract_back/new')]
                           public function new_back(Request $request): Response
                           {
                               
                               $contract = new Contrat();
                       
                              
                               $form = $this->createForm(ContratType::class, $contract);
                       
                               
                               $form->handleRequest($request);
                               if ($form->isSubmitted() && $form->isValid()) {
                                  
                                   $entityManager = $this->getDoctrine()->getManager();
                                   $entityManager->persist($contract);
                                   $entityManager->flush();
                       
                                  
                                   return $this->redirectToRoute('contract_back/show');
                               }
                       
                              
                               return $this->render('contrat_back/add.html.twig', [
                                   'form' => $form->createView(),
                               ]);
                           }
                       
                         
                         
                           #[Route('/contract_back/show', name: 'contract_back/show')]
                           public function show_back(): Response
                           {
                                      $contrats= $this->getDoctrine()->getManager()->getRepository(Contrat::class)->findAll();
                           return $this->render('contrat_back/show.html.twig', [
                               'contrats'=>$contrats
                           ]);}
                           
                           
                   
                           
                           #[Route('/contract_back/edit/{id}', name: 'contract_back/edit')]
                           public function edit_back(Request $request, int $id): Response
                           {
                               
                               $entityManager = $this->getDoctrine()->getManager();
                               $contrat = $entityManager->getRepository(Contrat::class)->find($id);
                           
                              
                               if (!$contrat) {
                                   throw $this->createNotFoundException('Contrat non trouvé pour l\'identifiant '.$id);
                               }
                           
                               
                               $form = $this->createForm(ContratType::class, $contrat);
                               $form->handleRequest($request);
                           
                               
                               if ($form->isSubmitted() && $form->isValid()) {
                                   $entityManager->flush();
                                   return $this->redirectToRoute('contract_back/show', ['id' => $contrat->getId()]);
                               }
                           
                               
                               return $this->render('contrat_back/edit.html.twig', [
                                   'contract' => $contrat,
                                   'form' => $form->createView(),
                               ]);
                           }
                           
                           
                       
                          
                          
                   
                       
                           
                           #[Route('/contrat_back/delete/{id}', name: 'contract_back/delete')]
                           public function deleteContrat_back($id, ManagerRegistry $manager, ContratRepository $cRepo): Response
                             {
                             $entityManager = $manager->getManager();
                       
                   
                              $contrat = $cRepo->find($id);
                       
                      
                                if ($contrat) {
                               $entityManager->remove($contrat);
                                 $entityManager->flush();
                                    } else
                           
                                 {return new Response("L'entité avec l'ID $id n'a pas été trouvée.", Response::HTTP_NOT_FOUND);}
                       
                   
                       
                                     return $this->redirectToRoute('contract_back/show');
                   }


                   #[Route('/year_back', name: 'app_mon_year_back')]
public function contractsbyStats_back(ContratRepository $contratRepository): Response
{
    // Récupérez les données des contrats depuis votre base de données
    $contrats=$contratRepository->findAll();

    // Initialisez un tableau pour stocker les statistiques des contrats par année
    $contratsParAnnee = [];

    // Calculez les statistiques des contrats par année entre 2017 et 2024
    for ($annee = 2017; $annee <= 2024; $annee++) {
        $contratsParAnnee[$annee] = 0;
    }

    // Calculez les statistiques des contrats par année
    foreach ($contrats as $contrat) {
        $dateDebut = $contrat->getDateDebut();
        if ($dateDebut !== null) {
            $annee = $dateDebut->format('Y');

            // Vérifiez si l'année est entre 2017 et 2024
            if ($annee >= 2017 && $annee <= 2024) {
                $contratsParAnnee[$annee]++;
            }
        }
    }

    // Créez le Pie Chart
    $pieChart = new PieChart();
    $dataArray = [['Année', 'Nombre de contrats']];
    for ($annee = 2017; $annee <= 2024; $annee++) {
        $dataArray[] = [$annee, $contratsParAnnee[$annee]];
    }
    $pieChart->getData()->setArrayToDataTable($dataArray);
    $pieChart->getOptions()->setTitle('Répartition des contrats par année (2017-2024)');

    // Renvoyez la vue avec le Pie Chart
    return $this->render('contrat/contracts_by_year_back.html.twig', [
        'pieChart' => $pieChart,
        'stats' => $contratsParAnnee, // Envoyez les statistiques des contrats par année à la vue
    ]);
}













#[Route('/statsbyfreelance_back', name: 'app_stats_by_freelance_back')]
public function contratStatsByFreelance_back(ContratRepository $crepo): Response
{
    // Récupérez les données des contrats depuis votre base de données
    $contrats = $crepo->findAll();

    // Initialisez un tableau pour stocker les statistiques des contrats par freelance
    $stats = [];

    // Calculez les statistiques des contrats par freelance
    foreach ($contrats as $contrat) {
        $freelancer = $contrat->getFreelancer();
        // Calcul des statistiques...

        // Exemple de calcul : nombre de contrats par freelance
        if (!isset($stats[$freelancer])) {
            $stats[$freelancer] = 0;
        }
        $stats[$freelancer]++;
    }

    // Renvoyez les données au template Twig pour affichage
    return $this->render('contrat/stats_by_freelance_back.html.twig', [
        'stats' => $stats,
    ]);}

   


    #[Route('/statsbyorganisation_back', name: 'app_stats_by_organisation_back')]
    public function contratStatsByOrganisation_back(ContratRepository $crepo): Response
    {
        // Récupérer les données des contrats depuis votre base de données
        $contrats = $crepo->findAll();

        // Initialiser un tableau pour stocker les statistiques des contrats par organisation
        $stats = [];

        // Calculez les statistiques des contrats par organisation
        foreach ($contrats as $contrat) {
            $organisation = $contrat->getOrganisation();

            // Vérifiez si l'organisation existe dans le tableau $stats
            if (!isset($stats[$organisation->getNom()])) {
                // Si l'organisation n'existe pas, initialisez-la à 0
                $stats[$organisation->getNom()] = 0;
            }

            // Incrémenter le compteur pour cette organisation
            $stats[$organisation->getNom()]++;
        }

        // Créez le Pie Chart
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable([
            ['Organisation', 'Nombre de contrats'],
            // Convertissez les statistiques en format requis pour le Pie Chart
            ...array_map(fn ($organisation, $nombreContrats) => [$organisation, $nombreContrats], array_keys($stats), array_values($stats))
        ]);
        $pieChart->getOptions()->setTitle('Répartition des contrats par organisation');

        // Renvoyez la vue avec le Pie Chart
        return $this->render('contrat/stats_by_organisation_back.html.twig', [
            'pieChart' => $pieChart,
            'stats' => $stats,
        ]);
    }




    #[Route('/statsbymontant_back', name: 'app_stats_by_montant_back')]
    public function contratStatsByMontant_back(ContratRepository $crepo): Response
    {
        // Récupérer les données des contrats depuis votre base de données
        $contrats = $crepo->findAll();

        // Initialiser un tableau pour stocker les statistiques des contrats par tranche de montant
        $stats = [
            'Montant entre 20 et 50' => 0,
            'Montant entre 50 et 100' => 0,
            'Montant entre 100 et 150' => 0,
            'Montant supérieur à 150' => 0,
        ];

        // Calculez les statistiques des contrats par tranche de montant
        foreach ($contrats as $contrat) {
            $montant = $contrat->getMontant();

            if ($montant >= 20 && $montant < 50) {
                $stats['Montant entre 20 et 50']++;
            } elseif ($montant >= 50 && $montant < 100) {
                $stats['Montant entre 50 et 100']++;
            } elseif ($montant >= 100 && $montant < 150) {
                $stats['Montant entre 100 et 150']++;
            } elseif ($montant >= 150) {
                $stats['Montant supérieur à 150']++;
            }
        }

        // Créez le Pie Chart
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable([
            ['Tranche de montant', 'Nombre de contrats'],
            // Convertissez les statistiques en format requis pour le Pie Chart
            ['Montant entre 20 et 50', $stats['Montant entre 20 et 50']],
            ['Montant entre 50 et 100', $stats['Montant entre 50 et 100']],
            ['Montant entre 100 et 150', $stats['Montant entre 100 et 150']],
            ['Montant supérieur à 150', $stats['Montant supérieur à 150']],
        ]);
        $pieChart->getOptions()->setTitle('Répartition des contrats par tranche de montant');

        // Renvoyez la vue avec le Pie Chart
        return $this->render('contrat/stats_by_montant_back.html.twig', [
            'pieChart' => $pieChart,
            'stats' => $stats,
        ]);
    }





    #[Route('/statsorganisation_back', name: 'app_stats_organisation_back')]
    public function contratStatsBydomainOrganisation_back(): Response
    {
        // Récupérer les données des contrats depuis la base de données
        $contrats = $this->getDoctrine()->getRepository(Contrat::class)->findAll();

        // Initialisez un tableau pour stocker les statistiques des contrats par domaine d'activité de l'organisation
        $stats = [
            'Développement Web et Mobile' => 0,
            'Design et Créativité' => 0,
            'Rédaction et Traduction' => 0,
            'Marketing et Ventes' => 0,
            'Support Administratif' => 0,
            'Consulting et Business' => 0,
            'Technologie et Sciences' => 0,
            'Vidéo et Animation' => 0,
        ];

        // Calculez les statistiques des contrats par domaine d'activité de l'organisation
        foreach ($contrats as $contrat) {
            $organisation = $contrat->getOrganisation();
            if ($organisation) {
                $domaineActivite = $organisation->getDomaineActivite();
                if (array_key_exists($domaineActivite, $stats)) {
                    $stats[$domaineActivite]++;
                } else {
                    // Si le domaine d'activité n'existe pas dans le tableau $stats, ignorez-le ou gérez-le d'une autre manière
                }
            }
        }


        
        // Créez le Pie Chart
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable([
            ['Domaine d\'activité', 'Nombre de contrats'],
            ['Développement Web et Mobile', $stats['Développement Web et Mobile']],
            ['Design et Créativité', $stats['Design et Créativité']],
            ['Rédaction et Traduction', $stats['Rédaction et Traduction']],
            ['Marketing et Ventes', $stats['Marketing et Ventes']],
            ['Support Administratif', $stats['Support Administratif']],
            ['Consulting et Business', $stats['Consulting et Business']],
            ['Technologie et Sciences', $stats['Technologie et Sciences']],
            ['Vidéo et Animation', $stats['Vidéo et Animation']],
        ]);
        $pieChart->getOptions()->setTitle('Répartition des contrats par domaine d\'activité de l\'organisation');

        // Renvoyez la vue avec le Pie Chart
        return $this->render('contrat/statsdomainorganisation_back.html.twig', [
            'pieChart' => $pieChart,
            'stats' => $stats,
        ]);
    }

    #[Route('/transition/{id}', name: 'app_transition')]      
    public function transition(Contrat $contrat, WorkflowInterface $workflow): Response
    {
        // Vérifiez si la transition est autorisée
        if ($workflow->can($contrat, 'transition_name')) {
            // Appliquez la transition
            $workflow->apply($contrat, 'transition_name');

            // Persistez les changements dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            // Ajoutez un message de succès
            $this->addFlash('success', 'La transition a été appliquée avec succès.');
        } else {
            // Ajoutez un message d'erreur
            $this->addFlash('error', 'Impossible d\'appliquer la transition.');
        }

        // Rendez le template Twig et passez des données si nécessaire
        return $this->render('contrat/transition.html.twig', [
            'contrat' => $contrat,
        ]);
    }

   /* #[Route('/historique_modif/{id}', name: 'app_historique_modif__id')]
    public function editContrat($id, Request $request, EntityManagerInterface $entityManager, ContratRepository $cr, ContractModificationRepository $cm): Response
    {
        // Récupérer le contrat à éditer depuis le repository Contrat
        $contract = $cr->find($id);
    
        // Vérifier si le contrat existe
        if (!$contract) {
            throw $this->createNotFoundException('Le contrat avec l\'ID ' . $id . ' n\'existe pas.');
        }
       
        // Récupérer les valeurs modifiées du contrat
        $oldValues = [];
        $newValues = [];
    
        // Modifier les attributs du contrat ici...
        // Par exemple :
        $oldValues['date_debut'] = $contract->getDateDebut()->format('Y-m-d'); // Formatage de la date en chaîne de caractères
        $newValues['date_debut'] = $request->request->get('date_debut'); // Nouvelle valeur récupérée du formulaire
    
        // Enregistrer les modifications dans la table ContractModification
        foreach ($oldValues as $fieldName => $oldValue) {
            $modification = new ContractModification();
            $modification->setContrat($contract); // Définir la référence au contrat
            $modification->setFieldName($fieldName);
            
            // Vérifier si la nouvelle valeur est nulle et la remplacer par une chaîne vide si nécessaire
            $newValue = $newValues[$fieldName] ?? ''; // Si $newValues[$fieldName] est null, utilise une chaîne vide à la place
            
            if ($oldValue instanceof \DateTimeInterface) {
                $formattedOldValue = $oldValue->format('Y-m-d');
            } else {
                // Handle the case where $oldValue is not a DateTime object
                $formattedOldValue = $oldValue; // Or any appropriate default value
            }
            
            $modification->setOldValue($formattedOldValue);
            $modification->setNewValue($newValue);
            $modification->setTimestamp(new \DateTime());
    
            $entityManager->persist($modification);
        }
        
        // Enregistrer les changements du contrat
        $entityManager->flush();
    
        // Récupérer l'historique des modifications du contrat depuis le repository ContractModification
        $historiqueModifications = $cm->findBy(['contrat' => $contract]);
    
        // Afficher une réponse avec l'historique des modifications
        return $this->render('contrat/modification.html.twig', [
            'historiqueModifications' => $historiqueModifications,
        ]);
    }
   
    */


    #[Route('/historique_modif/{id}', name: 'app_historique_modif__id')]
public function editContrat($id, Request $request, EntityManagerInterface $entityManager, ContratRepository $cr, ContractModificationRepository $cm): Response
{
    // Récupérer le contrat à éditer depuis le repository Contrat
    $contract = $cr->find($id);

    // Vérifier si le contrat existe
    if (!$contract) {
        throw $this->createNotFoundException('Le contrat avec l\'ID ' . $id . ' n\'existe pas.');
    }
   
    // Récupérer les valeurs modifiées du contrat
    $oldValues = [];
    $newValues = [];

    // Parcourir tous les champs de l'entité contrat
    $fields = ['DateDebut', 'DateFin', 'montant','statut','projet','freelancer','organisation','userId','DateCreation','description']; // Ajoutez tous les champs que vous voulez suivre
    foreach ($fields as $fieldName) {
        // Récupérer l'ancienne valeur du champ
        $oldValue = $contract->{'get' . ucfirst($fieldName)}();
        $oldValues[$fieldName] = $oldValue instanceof \DateTimeInterface ? $oldValue->format('Y-m-d') : $oldValue;

        // Récupérer la nouvelle valeur du champ depuis le formulaire
        $newValues[$fieldName] = $request->request->get($fieldName);
    }

    // Enregistrer les modifications dans la table ContractModification
    foreach ($oldValues as $fieldName => $oldValue) {
        $newValue = $newValues[$fieldName] ?? '';
    
        // Si la valeur a changé
        if ($oldValue != $newValue) {
            $modification = new ContractModification();
            $modification->setContrat($contract);
            $modification->setFieldName($fieldName);
            $modification->setOldValue(json_encode($oldValue)); // Convertir l'objet en JSON
            $modification->setNewValue($newValue);
            $modification->setTimestamp(new \DateTime());
    
            $entityManager->persist($modification);
        } }
    // Enregistrer les changements du contrat
    $entityManager->flush();

    // Récupérer l'historique des modifications du contrat depuis le repository ContractModification
    $historiqueModifications = $cm->findBy(['contrat' => $contract]);

    // Afficher une réponse avec l'historique des modifications
    return $this->render('contrat/modification.html.twig', [
        'historiqueModifications' => $historiqueModifications,
    ]);
}

    
    
    




}

























    



