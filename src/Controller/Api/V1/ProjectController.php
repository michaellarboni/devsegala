<?php

namespace App\Controller\Api\V1;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/api/v1/projects", name="api_v1_project")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/V1/ProjectController.php',
        ]);
    }

    /**
     * @Route("/api/v1/projects", name="api_v1_project", methods={"GET"})
     */
    public function projects(ProjectRepository $projectRepository): Response
    {
       $projects = $projectRepository->findAll();

       //$projectsJson = [];
       //foreach ($projects as project)

        return $this->json($projects);
    }
}
