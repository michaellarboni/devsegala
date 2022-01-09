<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ContactType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(ProjectRepository $projectRepository, Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            
            $message = (new Email())
                ->from($contactFormData['email'])
                //->to('lateamtonapero@gmail.com')
                ->to('webmaster@dandev.ovh')
                //->to('contact@webdevsegala.fr')
                ->subject('Contact webdevsegala')
                ->text('Sender : '.$contactFormData['email'].\PHP_EOL.
                    $contactFormData['message'],
                    'text/plain');
            $mailer->send($message);

            $this->addFlash('success', 'Votre message a été envoyé');

            return $this->redirectToRoute('home');
        }


        return $this->render('home/index.html.twig', [
            'projects' => $projectRepository->findAll(),
            'form'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/home/{id}", name="project_show")
     */
    public function show(Project $project): Response
    {
        return $this->json($project);
    }

    /**
     * @Route("/home/{id}", name="project_show")
     */
   // public function show(Project $project): Response
   // {
    //    return $this->render('home/show.html.twig', [
    //        'project' => $project,
    //    ]);
   // }
    

    /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu(): Response
    {
        return $this->render('home/cgu.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
