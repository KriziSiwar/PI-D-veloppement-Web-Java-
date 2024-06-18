<?php

namespace App\Controller;
/////////////////t
use DateTime;
use App\Entity\Freelancer;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
   /* #[Route('/stats', name: 'reclamation_stats')]
    public function stats(EntityManagerInterface $entityManager): Response
    {
        $reclamationRepository = $entityManager->getRepository(Reclamation::class);
        $stats = $reclamationRepository->countReclamationsByFreelancer(); //obtenir des stat de reclamation par freelancer 
    

        $labels = []; 
        $data = []; //nbr reclamtion 
        //parcourir les statistiques 
        foreach ($stats as $stat) {
           
            
            $data[] = $stat['reclamationCount'];
        }

        return $this->render('reclamation/stat.html.twig', [
            'labels' => $labels,
            'data' => $data,
        ]);
    }
   #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(Request $request, ReclamationRepository $reclamationRepository, UserRepository $userrepo): Response
    {
        $user = $userrepo->find(1); //recuperer user 1

        $reclamationsQuery = $reclamationRepository->findBy(['user' => $user]);

        // Pagination des résultats
       
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $pagination,
        ]);
    }*/
    #[Route('/back', name: 'app_reclamation_index1', methods: ['GET'])]
    public function index2(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamationback/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }





    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, UserRepository $userrepo): Response
    {
        $reclamation = new Reclamation();
        $user = $userrepo->find(1);
       // $reclamation->setUser($user); //attribuer l'utulisateur au reclamtion 
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request); //traiter formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setStatut('en cours');
            $reclamation->setDateReclamation(new \DateTime('now'));
           
            $entityManager->persist($reclamation);
            $entityManager->flush();
          
            $email = (new Email())
                ->from('oussama.hamaied@gmail.com')
              
                ->subject('Réclamation')
                ->html('<p>Vous avez reçu une reclamation de la part de roua'  );
            $mailer->send($email);
           
            $entityManager->flush();
            return $this->redirectToRoute('app_reclamation_index1', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index1', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'deleterecl', methods: ['POST'])]
    public function delete(Request $request, $id, EntityManagerInterface $entityManager, ReclamationRepository $rr): Response
    {
        $reclamation = $rr->find($id);
        $entityManager->remove($reclamation);
        $entityManager->flush();

        return $this->redirectToRoute('app_reclamation_index1');
    }
    #[Route('supprimer/{id}', name: 'deleterecl1')]
    public function delete2(Request $request, $id, EntityManagerInterface $entityManager, ReclamationRepository $rr): Response
    {
        $reclamation = $rr->find($id);
        $entityManager->remove($reclamation);
        $entityManager->flush();

        return $this->redirectToRoute('app_reclamation_index1');
    }




   
}
