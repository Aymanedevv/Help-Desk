<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\Type\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{

    #[Route('/new', name: 'app_ticket')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            // $task = $form->getData();
        $manager->persist($ticket);
        $manager->flush();
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('global_dashboard');
        }

        return $this->render('ticket/add-ticket.html.twig', [
            'form'=> $form->createView()

        ]);
    }
}
