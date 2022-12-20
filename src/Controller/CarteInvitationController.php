<?php

namespace App\Controller;

use App\Entity\CarteInvitation;
use App\Form\CarteInvitationType;
use App\Repository\CarteInvitationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/carteinvitation")
 */
class CarteInvitationController extends AbstractController
{
    /**
     * @Route("/", name="app_carte_invitation_index", methods={"GET"})
     */
    public function index(CarteInvitationRepository $carteInvitationRepository): Response
    {
        return $this->render('carte_invitation/index.html.twig', [
            'carte_invitations' => $carteInvitationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_carte_invitation_new", methods={"GET", "POST"})
     */
    public function new (Request $request, CarteInvitationRepository $carteInvitationRepository): Response
    {
        $carteInvitation = new CarteInvitation();
        $form = $this->createForm(CarteInvitationType::class, $carteInvitation);
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
            $carteInvitation->setPhoto($filename);
            $carteInvitationRepository->add($carteInvitation, true);

            return $this->redirectToRoute('app_carte_invitation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carte_invitation/new.html.twig', [
            'carte_invitation' => $carteInvitation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_carte_invitation_show", methods={"GET"})
     */
    public function show(CarteInvitation $carteInvitation): Response
    {
        return $this->render('carte_invitation/show.html.twig', [
            'carte_invitation' => $carteInvitation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_carte_invitation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CarteInvitation $carteInvitation, CarteInvitationRepository $carteInvitationRepository): Response
    {
        $form = $this->createForm(CarteInvitationType::class, $carteInvitation);
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
            $carteInvitation->setPhoto($filename);
            $carteInvitationRepository->add($carteInvitation, true);

            return $this->redirectToRoute('app_carte_invitation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carte_invitation/edit.html.twig', [
            'carte_invitation' => $carteInvitation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_carte_invitation_delete", methods={"POST"})
     */
    public function delete(Request $request, CarteInvitation $carteInvitation, CarteInvitationRepository $carteInvitationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $carteInvitation->getId(), $request->request->get('_token'))) {
            $carteInvitationRepository->remove($carteInvitation, true);
        }

        return $this->redirectToRoute('app_carte_invitation_index', [], Response::HTTP_SEE_OTHER);
    }
}