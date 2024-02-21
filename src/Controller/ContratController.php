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

























































































































    


}
