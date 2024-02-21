<?php

namespace App\Controller;

use App\Entity\PostedJobs;
use App\Form\PostedJobsType;
use App\Repository\PostedJobsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/posted/jobs')]
class PostedJobsController extends AbstractController
{
    #[Route('/', name: 'app_posted_jobs_index', methods: ['GET'])]
    public function index(PostedJobsRepository $postedJobsRepository): Response
    {
        return $this->render('posted_jobs/index.html.twig', [
            'posted_jobs' => $postedJobsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_posted_jobs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $postedJob = new PostedJobs();
        $form = $this->createForm(PostedJobsType::class, $postedJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($postedJob);
            $entityManager->flush();

            return $this->redirectToRoute('app_posted_jobs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('posted_jobs/new.html.twig', [
            'posted_job' => $postedJob,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_posted_jobs_show', methods: ['GET'])]
    public function show(PostedJobs $postedJob): Response
    {
        return $this->render('posted_jobs/show.html.twig', [
            'posted_job' => $postedJob,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_posted_jobs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PostedJobs $postedJob, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostedJobsType::class, $postedJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_posted_jobs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('posted_jobs/edit.html.twig', [
            'posted_job' => $postedJob,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_posted_jobs_delete', methods: ['POST'])]
    public function delete(Request $request, PostedJobs $postedJob, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postedJob->getId(), $request->request->get('_token'))) {
            $entityManager->remove($postedJob);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_posted_jobs_index', [], Response::HTTP_SEE_OTHER);
    }
}
