<?php

namespace App\Controller;
use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Repository\ActualiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;
#[Route('/actualite')]
class ActualiteController extends AbstractController
{
    #[Route('/listactualite', name: 'app_actualite_index', methods: ['GET'])]
    public function index(ActualiteRepository $actualiteRepository): Response
    {
        return $this->render('actualite/index.html.twig', [
            'actualites' => $actualiteRepository->findAll(),
        ]);
    }
    #[Route('/front', name: 'app_actualite_index2', methods: ['GET'])]
    public function index2(ActualiteRepository $actualiteRepository): Response
    {
        return $this->render('actualite/indexfront.html.twig', [
            'actualites' => $actualiteRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_actualite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $actualite = new Actualite();
        $actualite->setDatePublication(new \DateTime('now'));
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $file = $form['image']->getData();
            if ($file) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('images_directory'), $fileName);
                $actualite->setImage($fileName);
           
            $entityManager->persist($actualite);
            $entityManager->flush();

            return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
        }    }
        return $this->renderForm('actualite/new.html.twig', [
            'form' => $form,
        ]);    }
        
    #[Route('/{id}', name: 'app_actualite_show', methods: ['GET'])]
    public function show(Actualite $actualite): Response
    {
        return $this->render('actualite/show.html.twig', [
            'actualite' => $actualite,
        ]);    }
    #[Route('/pdf/{id}', name: 'pdf_generate')]
    public function generatePDF(ActualiteRepository $repository,$id): Response
   {
       $actualite=$repository->find($id) ;
           $pdfContent = $this->renderView('actualite/pdf.html.twig', [
           'actualite' => $actualite,
       ]);
       $options = new Options();
       $options->set('isHtml5ParserEnabled', true);
       $options->set('isRemoteEnabled', true);
       $dompdf = new Dompdf($options);
       $dompdf->loadHtml($pdfContent);
       $dompdf->render();
       return new Response($dompdf->output(), 200, [
           'Content-Type' => 'application/pdf',
           'Content-Disposition' => 'attachment; filename="Actualite.pdf"',
       ]);   }
    #[Route('/{id}/edit', name: 'app_actualite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actualite $actualite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);        }
        return $this->renderForm('actualite/edit.html.twig', [
            'actualite' => $actualite,
            'form' => $form,        ]);    }
    #[Route('/{id}', name: 'app_actualite_delete', methods: ['POST'])]
    public function delete(Request $request, Actualite $actualite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $actualite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actualite);
            $entityManager->flush();
        }
                return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);    }
}