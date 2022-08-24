<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserChatController extends AbstractController
{
    #[Route('/user/chat', name: 'app_user_chat')]
    public function index(): Response
    {
        return $this->render('user_chat/index.html.twig', [
            'controller_name' => 'UserChatController',
        ]);
    }
}
