<?php

namespace App\Controller;

use App\Repository\CarteInvitationRepository;
use App\Repository\CentresMariagesRepository;
use App\Repository\SallesDesFetesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/home/page", name="home", methods={"GET"})
     */
    public function index(CarteInvitationRepository $carteInvitationRepository, CentresMariagesRepository $centresMariagesRepository, SallesDesFetesRepository $sallesDesFetesRepository): Response
    {
        return $this->render('home_page/index.html.twig', [
            'cartes' => $carteInvitationRepository->findAll(),
            'centres' => $centresMariagesRepository->findAll(),
            'salles' => $sallesDesFetesRepository->findAll(),


        ]);
    }
}