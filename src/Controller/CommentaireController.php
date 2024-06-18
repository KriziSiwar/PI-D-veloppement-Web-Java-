<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\CommentLike;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use MercurySeries\FlashyBundle\FlashyNotifier as FlashyBundleFlashyNotifier;

#[Route('/commentaire')]
class CommentaireController extends AbstractController
{
    #[Route('/', name: 'app_commentaire_index', methods: ['GET'])]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commentaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();
          
            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaire_show', methods: ['GET'])]
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaire_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commentaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    }
  /*  #[Route('/{id}/like', name: 'app_commentaire_like', methods: ['GET'])]
public function like(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
{
    $user = $this->getUser();

    // Vérifier si l'utilisateur a déjà aimé ce commentaire
   
        $commentLike->setCommentaire($commentaire);
        $commentLike->setUser($user);
        $commentLike->setType('like');
    
        // Ajouter le like à l'entité Commentaire
       
    
        // Persister les changements dans la base de données
        $entityManager->persist($commentLike);
        $entityManager->flush();
    }
    
    return $this->redirectToRoute('app_commentaire_index');
}*/

/*#[Route('/{id}/dislike', name: 'app_commentaire_dislike', methods: ['GET'])]
public function dislike(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
{
    $user = $this->getUser();

    // Vérifier si l'utilisateur a déjà dislike ce commentaire
    $existingDislike = $entityManager->getRepository(CommentLike::class)->findOneBy(['commentaire' => $commentaire, 'user' => $user]);

    if (!$existingDislike) {
        // Créer une nouvelle instance de CommentLike
        $commentLike = new CommentLike();
        $commentLike->setCommentaire($commentaire);
        $commentLike->setUser($user);
        $commentLike->setType('dislike');
    
        // Ajouter le dislike à l'entité Commentaire
        $commentaire->addCommentLike($commentLike);
        $commentaire->setDislikes($commentaire->getDislikes() + 1);
    
        // Persister les changements dans la base de données
        $entityManager->persist($commentLike);
        $entityManager->flush();
    }
    
    return $this->redirectToRoute('app_commentaire_index');
}


*/


    
    }

