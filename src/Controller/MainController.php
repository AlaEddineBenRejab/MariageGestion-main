<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/welcome", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('base-front.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    /**
     * @Route("/Admin", name="app_home")
     */
    public function admin(): Response
    {

        $this->denyAccessUnlessGranted('Role_Admin');
        return $this->render('base-back.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
