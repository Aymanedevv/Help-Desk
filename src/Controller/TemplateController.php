<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\Type\TicketType;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use MongoDB\Driver\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TemplateController extends AbstractController
{
    #[Route('/global-dashboard', name: 'global_dashboard')]
    public function index(EntityManagerInterface $manager): Response
    {
        $tickets=$manager->getRepository(Ticket::class)->findAll();
        return $this->render('template/blog/layout.html.twig', [
            'controller_name' => 'TemplateController',
            'tickets'=>$tickets
        ]);
    }

    #[Route('/add-ticket', name: 'add_ticket')]
    public function addTicket(Request $request,SluggerInterface $slugger, EntityManagerInterface $manager, MailerService $mailerService): Response
    {

        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            // $task = $form->getData();
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('ticket_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $ticket->setImage($newFilename);
            }

            // ... persist the $product variable or any other work


            $manager->persist($ticket);
            $manager->flush();
            $mailerService->sendEmail();
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('global_dashboard');
        }

        return $this->render('template/add ticket/addticket.html.twig', [
            'form'=> $form->createView()

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

