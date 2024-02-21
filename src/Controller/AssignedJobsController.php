<?php

namespace App\Controller;

use App\Entity\AssignedJobs;
use App\Form\AssignedJobsType;
use App\Repository\AssignedJobsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/assigned/jobs')]
class AssignedJobsController extends AbstractController
{
    #[Route('/', name: 'app_assigned_jobs_index', methods: ['GET'])]
    public function index(AssignedJobsRepository $assignedJobsRepository): Response
    {
        return $this->render('assigned_jobs/index.html.twig', [
            'assigned_jobs' => $assignedJobsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_assigned_jobs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assignedJob = new AssignedJobs();
        $form = $this->createForm(AssignedJobsType::class, $assignedJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($assignedJob);
            $entityManager->flush();

            return $this->redirectToRoute('app_assigned_jobs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('assigned_jobs/new.html.twig', [
            'assigned_job' => $assignedJob,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assigned_jobs_show', methods: ['GET'])]
    public function show(AssignedJobs $assignedJob): Response
    {
        return $this->render('assigned_jobs/show.html.twig', [
            'assigned_job' => $assignedJob,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assigned_jobs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AssignedJobs $assignedJob, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssignedJobsType::class, $assignedJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assigned_jobs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('assigned_jobs/edit.html.twig', [
            'assigned_job' => $assignedJob,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assigned_jobs_delete', methods: ['POST'])]
    public function delete(Request $request, AssignedJobs $assignedJob, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assignedJob->getId(), $request->request->get('_token'))) {
            $entityManager->remove($assignedJob);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assigned_jobs_index', [], Response::HTTP_SEE_OTHER);
    }
}
