<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FreelanceController extends AbstractController
{
    #[Route('/freelance', name: 'app_freelance')]
    public function index(): Response
    {
        return $this->render('freelance/index.html.twig', [
            'controller_name' => 'FreelanceController',
        ]);
    }


    #[Route('/indexAdmin', name: 'app_Admin')]
    public function indexAdmin(): Response
    {
        return $this->render('Admin/index.html.twig');
            
    
    }

    

}
