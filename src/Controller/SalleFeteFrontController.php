<?php

namespace App\Controller;

use App\Entity\SallesDesFetes;
use App\Form\SallesDesFetesType;
use App\Repository\SallesDesFetesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleFeteFrontController extends AbstractController
{
    /**
     * @Route("/salle/fete/front", name="app_salle_fete_front", methods={"GET"})
     */
    public function index(SallesDesFetesRepository $sallesDesFetesRepository): Response
    {
        return $this->render('salles_des_fetes/SallesFetesFrontShow.html.twig', [
            'salles' => $sallesDesFetesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newSalle", name="app_salles_des_fetes_new_front", methods={"GET", "POST"})
     */
    public function new (Request $request, SallesDesFetesRepository $sallesDesFetesRepository): Response
    {
        $sallesDesFete = new SallesDesFetes();
        $form = $this->createForm(SallesDesFetesType::class, $sallesDesFete);
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
            $sallesDesFete->setPhoto($filename);
            $sallesDesFetesRepository->add($sallesDesFete, true);

            return $this->redirectToRoute('app_salle_fete_front', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('salles_des_fetes/newSalleFront.html.twig', [
            'salles_des_fete' => $sallesDesFete,
            'form' => $form,
        ]);
    }

}