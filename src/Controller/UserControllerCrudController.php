<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CompleteRegistrationFormType;
use App\Form\ClientType;

use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/controller/crud')]
class UserControllerCrudController extends AbstractController
{
    #[Route('/', name: 'app_user_controller_crud_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user_controller_crud/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }














    #[Route('/{id}/edit', name: 'app_user_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if (in_array('ROLE_FREELANCER', $user->getRoles())) {
            $form = $this->createForm(CompleteRegistrationFormType::class, $user);
            $fileField = 'ProfilePicture';
            $formType = 'freelance';
        } else {
            $form = $this->createForm(ClientType::class, $user);
            $fileField = 'companyLogo';
            $formType = 'client';
        }
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get($fileField)->getData();
    
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$file->guessExtension();
    
                try {
                    $file->move(
                        $this->getParameter('uploaded_files_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
    
                // Build the file path
                $filePath = 'uploads/'.$newFilename;
    
                // Update the 'ProfilePicture' or 'companyLogo' property to store the file path
                if ($fileField === 'ProfilePicture') {
                    $user->setProfilePicture($filePath);
                } else {
                    $user->setCompanyLogo($filePath);
                }
            }
    
            $entityManager->flush();
    
            return $this->redirectToRoute('app_user_controller_crud_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('user_controller_crud/edit.html.twig', [
            'user' => $user,
            'completeRegistrationForm'=>$form,
            'ClientType'=>$form,
            'form' => $form,
            'formType' => $formType,
        ]);
    }
    


 


    #[Route('/{id}', name: 'app_user_controller_crud_show', methods: ['GET'])]
    public function show(User $user, UserRepository $userRepository): Response
    {
        // Assuming friendsList contains IDs of users
        $friendsListIds = $user->getFriendsList();
    
        // Fetch the User entities corresponding to the IDs
        $friendsList = $userRepository->findBy(['id' => $friendsListIds]);
    
        return $this->render('user_controller_crud/show.html.twig', [
            'user' => $user,
            'friendsList' => $friendsList,
        ]);
    }
    




    /*
    #[Route('/{id}/edit', name: 'app_user_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if (in_array('ROLE_FREELANCER', $user->getRoles())) {
            $form = $this->createForm(CompleteRegistrationFormType::class, $user);
            $fileField = 'ProfilePicture';
            $formType = 'freelance';
        } else {
            $form = $this->createForm(ClientType::class, $user);
            $fileField = 'companyLogo';
            $formType = 'client';
        }
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_user_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('user_controller_crud/edit.html.twig', [
            'user' => $user,
            'completeRegistrationForm'=>$form,
            'ClientType'=>$form,
            'form' => $form,
            'formType' => $formType,
        ]);
    }
    */
    #[Route('/{id}', name: 'app_user_controller_crud_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();


            
            $this->get('security.token_storage')->setToken(null);

            // Invalidate the session
            $session = $request->getSession();
            $session->invalidate();
        }
    
        return $this->redirectToRoute('app_visitor');
    }
    
}
