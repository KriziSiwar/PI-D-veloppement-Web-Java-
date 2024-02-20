<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        // Fetch the User object from the security token
        $user = $this->getUser();

        // Check if the user has the 'ROLE_ADMIN' role
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            // If the user is an admin, render the admin page
            return $this->render('user/admin.html.twig', [
                'controller_name' => 'UserController',
            ]);
        } else {
            // If the user is not an admin, render a different page
            return $this->render('user/index.html.twig', [
                'controller_name' => 'UserController',
            ]);
        }
    }
}
