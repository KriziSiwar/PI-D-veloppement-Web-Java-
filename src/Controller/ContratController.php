<?php

namespace App\Controller;
use App\Entity\Contrat;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\Routing\Annotation\Route;
 use App\Form\ContratType;

use App\Repository\ContratRepository;
use Doctrine\Persistence\ManagerRegistry;
class ContratController extends AbstractController
{
    #[Route('/contrat', name: 'app_contrat')]
    public function index(): Response
    {
        return $this->render('contrat/index.html.twig', [
            'controller_name' => 'ContratController',
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
            $contract->setDateDebut(new \DateTime());
            $contract->setDateFin(new \DateTime());
            $contract->setDateCreation(new \DateTime());
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
    
      
      
        #[Route('/contract/show', name: 'contract/show')]
        public function show(): Response
        {
                   $contrats= $this->getDoctrine()->getManager()->getRepository(Contrat::class)->findAll();
        return $this->render('contrat/show.html.twig', [
            'contrats'=>$contrats
        ]);}
        
        

        
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
                       
                     
                     
                     
                     
                     
                     
                       
                       
                   
                           /**
                            * @Route("/contract/new", name="contract_new")
                            */
                   
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
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                       
                   
                   
                   }
                   
    
























































































































    



