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

class CarteInvitationFrontController extends AbstractController
{
    /**
     * @Route("/carte/invitation/front", name="app_carte_invitation_front", methods={"GET"})
     */
    public function index(CarteInvitationRepository $carteInvitationRepository): Response
    {
        return $this->render('carte_invitation/CarteFront.html.twig', [
            'cartes' => $carteInvitationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/carte_invitation_front/new", name="app_carte_invitation_front_new", methods={"GET", "POST"})
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

        return $this->renderForm('carte_invitation/frontCarteNew.html.twig', [
            'carte_invitation' => $carteInvitation,
            'form' => $form,
        ]);
    }

}