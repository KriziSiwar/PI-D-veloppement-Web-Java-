<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Organisation;
use App\Form\OrganisationType;
use App\Repository\OrganisationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
#[Route('/organisation')]
class OrganisationController extends AbstractController
{
    #[Route('/', name: 'app_organisation_index', methods: ['GET'])]
    public function index(OrganisationRepository $organisationRepository): Response
    {
        return $this->render('organisation/show.html.twig', [
            'organisation' => $organisationRepository->findAll(),
        ]);
    }

    #[Route('/add/organisation', name: 'app_organisation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $organisation = new Organisation();
        $form = $this->createForm(OrganisationType::class, $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($organisation);
            $entityManager->flush();

            return $this->redirectToRoute('app_organisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('organisation/new.html.twig', [
            'organisation' => $organisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_organisation_show', methods: ['GET'])]
    public function show(Organisation $organisation): Response
    {
        return $this->render('organisation/show.html.twig', [
            'organisation' => $organisation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_organisation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Organisation $organisation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrganisationType::class, $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_organisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('organisation/edit.html.twig', [
            'organisation' => $organisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_organisation_delete', methods: ['POST'])]
    public function delete(Request $request, Organisation $organisation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$organisation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($organisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_organisation_index', [], Response::HTTP_SEE_OTHER);
    }


    /*#[Route('/{id}', name: 'app_organisation_delete', methods: ['POST'])]
    public function delete($id, ManagerRegistry $manager, OrganisationRepository$oRepo): Response
      {
      $entityManager = $manager->getManager();
       $organisation = $oRepo->find($id);
         if ($organisation) {
        $entityManager->remove($organisation);
          $entityManager->flush();
             } else
    
          {return new Response("L'entité avec l'ID $id n'a pas été trouvée.", Response::HTTP_NOT_FOUND);}
              return $this->redirectToRoute('app_organisation_index');
               }*/



              


    #[Route('/', name: 'app_organisation_back_index', methods: ['GET'])]
    public function index_back(OrganisationRepository $organisationRepository): Response
    {
        return $this->render('organisation_back/show.html.twig', [
            'organisation' => $organisationRepository->findAll(),
        ]);
    }

    #[Route('/add/organisation_back', name: 'app_organisation_back_new', methods: ['GET', 'POST'])]
    public function new_back(Request $request, EntityManagerInterface $entityManager): Response
    {
        $organisation = new Organisation();
        $form = $this->createForm(OrganisationType::class, $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($organisation);
            $entityManager->flush();

            return $this->redirectToRoute('app_organisation_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('organisation_back/new.html.twig', [
            'organisation' => $organisation,
            'form' => $form,
        ]);
    }

  /*  #[Route('/{id}', name: 'app_organisation_back_show', methods: ['GET'])]
    public function show_back(Organisation $organisation): Response
    {
        return $this->render('organisation_back/show.html.twig', [
            'organisation' => $organisation,
        ]);
    }*/


   /* #[Route('/organisation_back/show', name: 'organisation_back/show')]
    public function show_back(OrganisationRepository $organisationRepository): Response
    {
        $organisations = $organisationRepository->findAll();
        return $this->render('organisation_back/show.html.twig', [
            'organisations' => $organisations
        ]);
    }
   */
    #[Route('/{id}', name: 'app_organisation_back_show', methods: ['GET'])]
 public function show_back(Organisation $organisation): Response
 {
     return $this->render('organisation_back/show.html.twig', [
         'organisation' => $organisation,
     ]);
   
   
   
    }

    #[Route('/{id}/edit', name: 'app_organisation_back_edit', methods: ['GET', 'POST'])]
    public function edit_back(Request $request, Organisation $organisation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrganisationType::class, $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_organisation_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('organisation_back/edit.html.twig', [
            'organisation' => $organisation,
            'form' => $form,
        ]);
    }

   /* #[Route('/{id}', name: 'app_organisation_back_delete', methods: ['POST'])]
    public function delete_back(Request $request, Organisation $organisation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$organisation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($organisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_organisation_back_index', [], Response::HTTP_SEE_OTHER);
    }
*/

    #[Route('/{id}', name: 'app_organisation_delete', methods: ['POST'])]
    public function delete_back($id, ManagerRegistry $manager, OrganisationRepository$oRepo): Response
      {
      $entityManager = $manager->getManager();
       $organisation = $oRepo->find($id);
         if ($organisation) {
        $entityManager->remove($organisation);
          $entityManager->flush();
             } else
    
          {return new Response("L'entité avec l'ID $id n'a pas été trouvée.", Response::HTTP_NOT_FOUND);}
              return $this->redirectToRoute('app_organisation_index');
               }
            }

