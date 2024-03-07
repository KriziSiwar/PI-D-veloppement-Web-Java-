<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;


    class SocialnetworkController extends AbstractController
    {


        private $entityManager;
        private $userRepository;

        public function __construct(UserRepository $userRepository,EntityManagerInterface $entityManager)
        {
            $this->userRepository = $userRepository;
            $this->entityManager = $entityManager;

        }
    

        #[Route('/socialnetwork', name: 'app_socialnetwork')]
        public function index(): Response
        {
            return $this->render('socialnetwork/index.html.twig', [
                'controller_name' => 'SocialnetworkController',
            ]);
        }
        #[Route('/search', name: 'app_search')]
        public function search(Request $request): Response
        {
            // Get the search term from the request
            $term = $request->query->get('term');
    
            // Get the entity manager
            $em = $this->getDoctrine()->getManager();
    
            // Create a query to search for users
            $query = $em->createQuery(
                'SELECT u
                FROM App\Entity\User u
                WHERE u.FirstName LIKE :term
                OR u.LastName LIKE :term
                OR u.email LIKE :term'
            )->setParameter('term', '%' . $term . '%');
    
            // Execute the query and get the results
            $users = $query->getResult();
    
            // Format the results into an array of user details
            $results = array_map(function(User $user) {
                return [
                    'id' => $user->getId(),
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName(),
                    'email' => $user->getEmail(),
                    'ProfilePicture' => $user->getProfilePicture(), // Add this line

                    // Add any other user details you want to include in the search results
                ];
            }, $users);
    
            // Return the results as a JSON response
            return new Response(json_encode($results));
        }
 


        #[Route('/socialnetwork/{id}', name: 'socialnetwork_profile')]
        public function socialnetworkProfile($id): Response
        {
            // Fetch user data from the database based on the provided ID
            $user = $this->getDoctrine()->getRepository(User::class)->find($id);
    
            if (!$user) {   
                throw $this->createNotFoundException('User not found');
            }
    
            // Render the profile page template with the fetched user data
            return $this->render('socialnetwork/profile.html.twig', [
                'user' => $user,
            ]);
        }
    


        #[Route('/socialnetwork/addfriend/{id}', name: 'add_friend')]


        public function addFriendAction($id): Response
        {
            // Get the current user (you'll need to implement this logic)
            $user = $this->getUser();
        $friendId=$id;
            // Get the friend to be added
            $friend = $this->userRepository->find($friendId);
            echo "<script>console.log(" . json_encode( $friendId) . ");</script>";

            if (!$friend) {
                throw $this->createNotFoundException('Friend not found');
            }
        
            // Add the friend to the current user's friend list
            $user->addFriendToList($friend);
        
            // Persist the changes to the database
            $this->entityManager->flush();
        
            // Redirect the user to the previous page or a specific route
            return $this->redirectToRoute('socialnetwork_profile', ['id' => $id]);
        }



        #[Route('/socialnetwork/removefriend/{id}', name: 'remove_friend')]
public function removeFriendAction($id): Response
{
    // Get the current user
    $user = $this->getUser();

    // Get the friend to be removed
    $friend = $this->userRepository->find($id);

    if (!$friend) {
        throw $this->createNotFoundException('Friend not found');
    }

    // Remove the friend from the current user's friend list
    $user->removeFriendFromList($friend);

    // Persist the changes to the database
    $this->entityManager->flush();

    // Redirect the user to the previous page or a specific route
    return $this->redirectToRoute('socialnetwork_profile', ['id' => $id]);
}

    }
