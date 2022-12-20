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

class CentreDeMariageControllerFront extends AbstractController
{
    /**
     * @Route("/centre/de/mariage", name="app_centre_de_mariage", methods={"GET"})
     */
    public function index(CentresMariagesRepository $centresMariagesRepository): Response
    {
        return $this->render('centres_mariages/FrontEndShow.html.twig', [
            'centres' => $centresMariagesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/centre_de_mariage/new", name="app_centres_mariages_new_front", methods={"GET", "POST"})
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

            return $this->redirectToRoute('app_centre_de_mariage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centres_mariages/newCentreFront.html.twig', [
            'centres_mariage' => $centresMariage,
            'form' => $form,
        ]);
    }
}