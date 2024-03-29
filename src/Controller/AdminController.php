<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;

use App\Repository\UserRepository;
use App\Repository\ContratRepository;
use App\Repository\PostedJobsRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;













#[Route('/Admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_index', methods: ['GET'])]
    public function index(UserRepository $userRepository,ContratRepository $contratRepository  ,PostedJobsRepository $postedJobRepository ): Response
    {
        // Get the currently logged in user
        $user = $this->getUser();
        $contrats = $contratRepository->findAll();
        $postedJobs = $postedJobRepository->findAll();

        return $this->render('Admin/index.html.twig', [
            'users' => $userRepository->findAll(),
            'user' => $user,
            'contrats' => $contrats,
            'postedJobs' => $postedJobs,

 
        ]);
    }

    #[Route('/new', name: 'app_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_ADMIN']);
    
            // Encode the password
            $plainPassword = $form->get('plainPassword')->getData();
            $encodedPassword = $passwordEncoder->encodePassword($user, $plainPassword);
    
            // Set the encoded password onto the User entity
            $user->setPassword($encodedPassword);
    
            $entityManager->persist($user);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('Admin/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_admin_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('Admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
/*
    #[Route('/{id}', name: 'app_admin_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }
*/


}
