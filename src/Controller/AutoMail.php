<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;



class AutoMail extends AbstractController
{
    #[Route(path: '/autosend', name: 'autosend')]
    public function sendEmailToInactiveUsers(EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        // Get the current date and time
        $now = new \DateTime();

        // Get all users
        $users = $entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            // Check if the user's last login was more than a month ago
                // Create the $user
                $lastLogin = $user->getLastLogin(); // Assuming you have a 'lastLogin' property in your User entity
                $interval = $lastLogin->diff($now);
    
                if ($interval->m > 1) {

                echo "<script>console.log(" . json_encode($user->getEmail()) . ");</script>";
                $transport = Transport::fromDsn('smtp://omar.laatter@gmail.com:cxyjseanhsbmwpxw@smtp.gmail.com:587');
                $mailer = new Mailer($transport);
                $email = (new Email())
                    ->from('omar.laatter@gmail.com')
                    ->to($user->getEmail())
                    ->subject('We miss you at our website!')
                    ->html("<p>Hello {$user->getUsername()},</p><p>It's been a while since you last logged in. We miss you! Come back and check out what's new.</p>");

                // Send the email
                $mailer->send($email);
            
        }
    }

        // Return an empty response
        return new Response();
    }
}
