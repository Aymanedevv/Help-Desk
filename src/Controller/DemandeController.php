<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\Type\DemandeTestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeController extends AbstractController
{
    #[Route('/demande', name: 'app_demande')]
    public function index(Request $request): Response
    {
        $demande = new Demande();
        $form = $this->createForm(DemandeTestType::class, $demande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            // $task = $form->getData();
        dd($demande);
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('task_success');
        }

        return $this->render('demande/add-demande.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
