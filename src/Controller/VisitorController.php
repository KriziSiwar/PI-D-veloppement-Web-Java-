<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\EventRepository;

class VisitorController extends AbstractController
{
    /*
    #[Route('/visitor', name: 'app_visitor')]
    public function index(): Response
    {
        return $this->render('visitor/index.html.twig', [
            'controller_name' => 'VisitorController',
        ]);
    }
*/


    #[Route('/visitor', name: 'app_visitor')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll(); // Suppose que vous avez une méthode findAll() dans votre EventRepository

        return $this->render('visitor/index.html.twig', [
            'events' => $events,
        ]);
    }


    #[Route('/visitor/newEvent', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        } 

        return $this->renderForm('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }






}
