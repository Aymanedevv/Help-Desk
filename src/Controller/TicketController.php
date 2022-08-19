<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\Type\TicketType;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TicketController extends AbstractController
{

    #[Route('/new', name: 'app_ticket')]
    public function index(Request $request, EntityManagerInterface $manager, MailerService $mailerService, SluggerInterface $slugger): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$type = $form->get('type')->getData();
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
}
