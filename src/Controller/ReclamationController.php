<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReclamationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/index1', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }





    /**
     * @Route("/rec/new", name="contract_new")
     */


    #[Route('/new', name: 'app_reclamation_new')]
    public function new(Request $request): Response
    {

        $reclamation = new Reclamation();


        $form = $this->createForm(ReclamationType::class, $reclamation);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();


            return $this->redirectToRoute('reclamation/ok');
        }


        return $this->render('reclamation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/reclamation/show', name: 'reclamation/show')]
    public function show(): Response
    {
        $reclamations = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamations,
        ]);
    }




    #[Route('/reclamation/ok', name: 'reclamation/ok')]
    public function ok(): Response
    {
        $reclamations = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        return $this->render('reclamation/ok.html.twig', [
            'reclamation' => $reclamations,
        ]);
    }




    #[Route('/reclamation/edit/{id}', name: 'reclamation/edit')]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $contrat = $entityManager->getRepository(Reclamation::class)->find($id);


        if (!$contrat) {
            throw $this->createNotFoundException('Contrat non trouvé pour l\'identifiant ' . $id);
        }


        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('reclamation/show', ['id' => $reclamation->getId()]);
        }


        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }



    #[Route('/delete/{id}', name: 'reclamation/delete')]
    public function deleteContrat($id, ManagerRegistry $manager, ReclamationRepository $cRepo): Response
    {
        $entityManager = $manager->getManager();


        $reclamation = $cRepo->find($id);


        if ($reclamation) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        } else {
            return new Response("L'entité avec l'ID $id n'a pas été trouvée.", Response::HTTP_NOT_FOUND);
        }



        return $this->redirectToRoute('reclamation/show');
    }
}
