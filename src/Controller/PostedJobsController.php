<?php

namespace App\Controller;

use App\Entity\PostedJobs;
use App\Form\PostedJobsType;
use App\Repository\PostedJobsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/posted')]
class PostedJobsController extends AbstractController
{
    #[Route('/', name: 'app_posted_jobs_front', methods: ['GET'])]
    public function index(PostedJobsRepository $postedJobsRepository): Response
    {
        $posted_jobs=$postedJobsRepository->findAll();
        return $this->render('posted_jobs/index.html.twig', [
            'posted_jobs' => $posted_jobs,
        ]);
    }
   

   


    #[Route('/back', name: 'app_posted_jobs_back', methods: ['GET'])]
    public function indexBack(PostedJobsRepository $postedJobsRepository): Response
    {
        $posted_jobs=$postedJobsRepository->findAll();
        return $this->render('posted_jobs/indexBack.html.twig', [
            'posted_jobs' => $posted_jobs,
        ]);
    }

   /* #[Route('/backFav', name: 'app_posted_jobs_fav', methods: ['GET'])]
    public function indexFavorite(): Response
    {
        $user=$this->getUser();
        
        return $this->render('posted_jobs/favoriteBack.html.twig', [
            'posted_jobs' => $myJobs,
        ]);
    }*/

    #[Route('/new', name: 'app_posted_jobs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $postedJob = new PostedJobs();
        $form = $this->createForm(PostedJobsType::class, $postedJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $entityManager->persist($postedJob);
            $entityManager->flush();

            return $this->redirectToRoute('app_posted_jobs_front', [], Response::HTTP_SEE_OTHER);
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

   /* #[Route('/show/{id}', name: 'posted_show')]
    public function show1(): Response
    {
               $postedJob= $this->getDoctrine()->getManager()->getRepository(PostedJobs::class)->findAll();
    return $this->render('posted_jobs/index.html.twig', [
        'posted_job'=>$postedJob,
    ]);}
*/


    #[Route('/{id}/edit', name: 'app_posted_jobs_edit', methods: ['GET', 'POST'])]
    public function edit(NotifierInterface $notifier, Request $request, PostedJobs $postedJob, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostedJobsType::class, $postedJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $notification = (new Notification('Update', ['email']))
                ->content($postedJob->getTitle().' has been changed');

           

            return $this->redirectToRoute('app_posted_jobs_front', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('posted_jobs/edit.html.twig', [
            'posted_job' => $postedJob,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/fav', name: 'app_posted_jobs_favorite', methods: ['GET', 'POST'])]
    public function addFavorite(Request $request, PostedJobs $postedJob, EntityManagerInterface $entityManager): Response
    {
        $user=$this->getUser();
        
        return $this->redirectToRoute('app_posted_jobs_front', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_posted_jobs_delete', methods: ['POST'])]
    public function delete(Request $request, PostedJobs $postedJob, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postedJob->getId(), $request->request->get('_token'))) {
            $entityManager->remove($postedJob);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_posted_jobs_front', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/search', name: 'app_posted_jobs_search', methods: ['POST'])]
    public function search(Request $request,PostedJobsRepository $postedJobsRepository)
    {
        $query = $request->request->get('query');
        $matchJobs = $postedJobsRepository->searchJobs($query);
        $jsonData = [];
        foreach ($matchJobs as $job) {
            $jsonData[] = [
                'id' => $job->getId(),
                //'imageName' => $job->getImageName(),
                'title' => $job->getTitle(),
                'description' => $job->getDescription(),
                'requiredSkills' => $job->getRequiredSkills(),
                'budgetEstimate' => $job->getBudgetEstimate(),
                'startDate' => $job->getStartDate()->format('Y-m-d'),
                'endDate' => $job->getEndDate()->format('Y-m-d'),
                // Add more fields if needed
            ];
        }
        // Render the assigned jobs as JSON
        return new JsonResponse($jsonData);
    }
}
