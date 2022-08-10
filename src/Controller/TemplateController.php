<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
{
    #[Route('/global-dashboard', name: 'global_dashboard')]
    public function index(): Response
    {
        return $this->render('template/blog/layout.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    #[Route('/add-ticket', name: 'add_ticket')]
    public function addTicket(): Response
    {
        return $this->render('template/add ticket/addticket.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    #[Route('/authen', name: 'app_authen')]
    public function auth(): Response
    {
        return $this->render('authen/authen.html.twig', [
        'controller_name' => 'AuthenController',
    ]);
    }
}

