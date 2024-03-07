<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;


class InactiveuserCommand extends Command
{
    private $entityManager;
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:inactiveuser')
            ->setDescription('Send emails to inactive users')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Get the current date and time
        $now = new \DateTime();

        // Get all users
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            // Check if the user's last login was more than a month ago
            $lastLogin = $user->getLastLogin(); // Assuming you have a 'lastLogin' property in your User entity
            $interval = $lastLogin->diff($now);

            if ($interval->m > 1) {
                // User is inactive for more than 1 month
                // Create personalized email
                $output->writeln($user->getUsername());

                $transport = Transport::fromDsn('smtp://omar.laatter@gmail.com:cxyjseanhsbmwpxw@smtp.gmail.com:587');
                $this->mailer = new Mailer($transport);
                $firstName = $user->getFirstName(); // Assuming you have a 'firstName' property
                $lastName = $user->getLastName();   // Assuming you have a 'lastName' property

                $email = (new Email())
                    ->from('omar.laatter@gmail.com')
                    ->to($user->getEmail())
                    ->subject('We miss you at our website!')
                    ->html("<p>Hello $firstName $lastName,</p><p>It's been a while since you visited our website. We'd love to have you back!</p>");

                // Send the email
                $this->mailer->send($email);
            }
        }

        $output->writeln('Emails sent successfully.');

        return Command::SUCCESS;
    }
}
