<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


///
use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

use Swift_Message;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\Transports;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;




class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    /////////////////////////////////////////////////////


    #[Route(path: '/forgot', name: 'forgot_name')]


    public function forgotPassword(Request $request, UserRepository $userRepository, MailerInterface $mailer, TokenGeneratorInterface  $tokenGenerator)
    {


        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $donnees = $form->getData(); //


            $user = $userRepository->findOneBy(['email' => $donnees]);
            if (!$user) {
                $this->addFlash('danger', 'cette adresse n\'existe pas');
                return $this->redirectToRoute("forgot_name");
            }
            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $entityManger = $this->getDoctrine()->getManager();
                $entityManger->persist($user);
                $entityManger->flush();
            } catch (\Exception $exception) {
                $this->addFlash('warning', 'une erreur est survenue :' . $exception->getMessage());
                return $this->redirectToRoute("app_login");
            }

            $url = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);


            //BUNDLE MAILER
                $transport = Transport::fromDsn('smtp://omar.laatter@gmail.com:fsoo%20mcks%20myyb%20uayl@smtp.gmail.com:587');
                $mailer = new Mailer($transport);

            $message = (new Email())
                ->from('omar.laatter@gmail.com')
                ->to($user->getEmail())
                ->subject('Mot de passe oublié')
                ->html("<p>Bonjour,</p>Une demande de réinitialisation de mot de passe a été effectuée. Veuillez cliquer sur le lien suivant : <a href='{$url}'>{$url}</a>");

            //send mail
            $mailer->send($message);
            $this->addFlash('message', 'E-mail  de réinitialisation du mp envoyé :');
            //    return $this->redirectToRoute("app_login");



        }

        return $this->render("security/forgotPassword.html.twig", ['form' => $form->createView()]);
    }


    /////////////////////////////////////////////



    #[Route(path: '/resetpassword/{token}', name: 'app_reset_password')]
    public function resetpassword(Request $request, UserPasswordEncoderInterface  $passwordEncoder)
    {
        $token = $request->attributes->get('token'); // Use 'attributes' instead of 'query'

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);


        if ($user == null) {

            $this->addFlash('danger', $token);
            return $this->redirectToRoute("app_login");
        }
        
        if($request->isMethod('POST')) {
            $user->setResetToken(null);

            $user->setPassword($passwordEncoder->encodePassword($user,$request->request->get('password')));
            $entityManger = $this->getDoctrine()->getManager();
            $entityManger->persist($user);
            $entityManger->flush();

            $this->addFlash('message','Mot de passe mis à jour :');
            return $this->redirectToRoute("app_login");

        }
        else {
            return $this->render("security/resetPassword.html.twig",['token'=>$token]);

        }
    }
}
