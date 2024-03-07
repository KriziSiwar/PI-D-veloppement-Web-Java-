<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\ClientType;

use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Form\CompleteRegistrationFormType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Psr\Log\LoggerInterface;

class RegistrationController extends AbstractController
{

        #[Route('/register', name: 'app_register')]
        public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
        {
            $user = new User();
    
            $role = $request->query->get('role');

        if ($role === 'client') {
            $user->setRoles(['ROLE_CLIENT']);
        } elseif ($role === 'freelancer') {
            $user->setRoles(['ROLE_FREELANCER']);
        }
            $form = $this->createForm(RegistrationFormType::class, $user);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
    
                $entityManager->persist($user);
                $entityManager->flush();
    
                // do anything else you need here, like send an email
    
                 $userAuthenticator->authenticateUser(
                    $user,
                    $authenticator,
                    $request
                );
               return  $this->redirectToRoute('app_complete_registration');
            }
    
            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
        }
    
   

    #[Route('/choix', name: 'choix')]
    public function choix(): Response
    {
        return $this->render('registration/choix.html.twig');
    }
    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        return $this->render('registration/ProfileBuild.html.twig');
    }


        #[Route('/complete-registration', name: 'app_complete_registration')]
        public function completeRegistrationClient(Request $request, EntityManagerInterface $entityManager, LoggerInterface $logger): Response
        {
            $user = $this->getUser(); // get the connected user
            $roles = $user->getRoles(); // get the roles of the user
        
            if (in_array('ROLE_FREELANCER', $roles)) {
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
        
                $entityManager->persist($user);
                $entityManager->flush();
        
                $this->addFlash('success', 'Registration completed successfully');
        
                return $this->redirectToRoute('app_visitor');
            }
        
            return $this->render('registration/CompleteRegistration.html.twig', [
                'completeRegistrationForm' => $form->createView(),
                'formType' => $formType,
            ]);
        }
        
    }
