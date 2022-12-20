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

/**
 * @Route("/sallesdesfetes")
 */
class SallesDesFetesController extends AbstractController
{
    /**
     * @Route("/", name="app_salles_des_fetes_index", methods={"GET"})
     */
    public function index(SallesDesFetesRepository $sallesDesFetesRepository): Response
    {
        return $this->render('salles_des_fetes/index.html.twig', [
            'salles_des_fetes' => $sallesDesFetesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_salles_des_fetes_new", methods={"GET", "POST"})
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

            return $this->redirectToRoute('app_salles_des_fetes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('salles_des_fetes/new.html.twig', [
            'salles_des_fete' => $sallesDesFete,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_salles_des_fetes_show", methods={"GET"})
     */
    public function show(SallesDesFetes $sallesDesFete): Response
    {
        return $this->render('salles_des_fetes/show.html.twig', [
            'salles_des_fete' => $sallesDesFete,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_salles_des_fetes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SallesDesFetes $sallesDesFete, SallesDesFetesRepository $sallesDesFetesRepository): Response
    {
        $form = $this->createForm(SallesDesFetesType::class, $sallesDesFete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
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

            return $this->redirectToRoute('app_salles_des_fetes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('salles_des_fetes/edit.html.twig', [
            'salles_des_fete' => $sallesDesFete,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_salles_des_fetes_delete", methods={"POST"})
     */
    public function delete(Request $request, SallesDesFetes $sallesDesFete, SallesDesFetesRepository $sallesDesFetesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sallesDesFete->getId(), $request->request->get('_token'))) {
            $sallesDesFetesRepository->remove($sallesDesFete, true);
        }

        return $this->redirectToRoute('app_salles_des_fetes_index', [], Response::HTTP_SEE_OTHER);
    }
}