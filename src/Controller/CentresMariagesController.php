<?php

namespace App\Controller;

use App\Entity\CentresMariages;
use App\Form\CentresMariagesType;
use App\Repository\CentresMariagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/centres_mariages")
 */
class CentresMariagesController extends AbstractController
{
    /**
     * @Route("/", name="app_centres_mariages_index", methods={"GET"})
     */
    public function index(CentresMariagesRepository $centresMariagesRepository): Response
    {
        return $this->render('centres_mariages/index.html.twig', [
            'centres_mariages' => $centresMariagesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_centres_mariages_new", methods={"GET", "POST"})
     */
    public function new (Request $request, CentresMariagesRepository $centresMariagesRepository): Response
    {
        $centresMariage = new CentresMariages();
        $form = $this->createForm(CentresMariagesType::class, $centresMariage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();
            $upload_directory = $this->getParameter('upload_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            try {
                $file->move(
                    $upload_directory,
                    $filename
                );
            } catch (FileException $e) {

            }
            $centresMariage->setPhoto($filename);
            $centresMariagesRepository->add($centresMariage, true);

            return $this->redirectToRoute('app_centres_mariages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centres_mariages/new.html.twig', [
            'centres_mariage' => $centresMariage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_centres_mariages_show", methods={"GET"})
     */
    public function show(CentresMariages $centresMariage): Response
    {
        return $this->render('centres_mariages/show.html.twig', [
            'centres_mariage' => $centresMariage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_centres_mariages_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CentresMariages $centresMariage, CentresMariagesRepository $centresMariagesRepository): Response
    {
        $form = $this->createForm(CentresMariagesType::class, $centresMariage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();
            $upload_directory = $this->getParameter('upload_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            try {
                $file->move(
                    $upload_directory,
                    $filename
                );
            } catch (FileException $e) {

            }
            $centresMariage->setPhoto($filename);
            $centresMariagesRepository->add($centresMariage, true);

            return $this->redirectToRoute('app_centres_mariages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centres_mariages/edit.html.twig', [
            'centres_mariage' => $centresMariage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_centres_mariages_delete", methods={"POST"})
     */
    public function delete(Request $request, CentresMariages $centresMariage, CentresMariagesRepository $centresMariagesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $centresMariage->getId(), $request->request->get('_token'))) {
            $centresMariagesRepository->remove($centresMariage, true);
        }

        return $this->redirectToRoute('app_centres_mariages_index', [], Response::HTTP_SEE_OTHER);
    }
}