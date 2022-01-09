<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/project")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="admin_project_index", methods={"GET"})
     */
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('admin/project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_project_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupere les images transmises
            $images = $form->get('images')->getData();
            // On boucle sur les images
            foreach($images as $image){
                //On génére un nouveau fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // on stocke l'image dans la  base de donnée (son nom)
                $img = new Images();
                $img->setName($fichier);
                $project->addImage($img);

            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('admin_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/project/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_project_show", methods={"GET"})
     */
    public function show(Project $project): Response
    {
        return $this->render('admin/project/show.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_project_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_project_delete", methods={"POST"})
     */
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_project_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/image/{id}", name="admin_project_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Images $image, Request $request){
        $data = json_decode($request->getContent(), true);
        
        //On verifie si le toek est valide
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            // On récupere le nom de l'image
            $name = $image->getName();
            //On supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$name);
              //On supprime l'entree de la base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
  
            //On repond en Json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalid'], 400);
        }
      }
}
