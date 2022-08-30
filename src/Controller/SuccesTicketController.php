<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuccesTicketController extends AbstractController
{
    #[Route('/succes/ticket', name: 'app_succes_ticket')]
    public function index(): Response
    {
        return $this->render('succes_ticket/index.html.twig', [
            'controller_name' => 'SuccesTicketController',
        ]);
    }
}
