<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/email', name: 'mailbox')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('aymane@sqli.com')
            ->to('email@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('New ticket arrived !!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);


            return $this->render('mailer/index.html.twig', [
                'controller_name' => 'MailerController',
            ]);



    }
}












