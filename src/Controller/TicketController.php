<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'app_ticket')]
    public function index(): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket );

        return $this->render('ticket/add-ticket.html.twig', [
            'form'=> $form->createView()

        ]);
    }
}
