<?php

namespace App\Controller;

use App\Entity\Freelancer;
use App\Form\FreelancerType;
use App\Repository\FreelancerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/freelancer')]
class FreelancerController extends AbstractController
{
    #[Route('/', name: 'app_freelancer_index', methods: ['GET'])]
    public function index(FreelancerRepository $freelancerRepository): Response
    {
        return $this->render('freelancer/index.html.twig', [
            'freelancers' => $freelancerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_freelancer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $freelancer = new Freelancer();
        $form = $this->createForm(FreelancerType::class, $freelancer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($freelancer);
            $entityManager->flush();

            return $this->redirectToRoute('app_freelancer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('freelancer/new.html.twig', [
            'freelancer' => $freelancer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_freelancer_show', methods: ['GET'])]
    public function show(Freelancer $freelancer): Response
    {
        return $this->render('freelancer/show.html.twig', [
            'freelancer' => $freelancer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_freelancer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Freelancer $freelancer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FreelancerType::class, $freelancer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_freelancer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('freelancer/edit.html.twig', [
            'freelancer' => $freelancer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_freelancer_delete', methods: ['POST'])]
    public function delete(Request $request, Freelancer $freelancer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$freelancer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($freelancer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_freelancer_index', [], Response::HTTP_SEE_OTHER);
    }
}
