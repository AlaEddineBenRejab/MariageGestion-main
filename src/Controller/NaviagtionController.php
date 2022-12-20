<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NaviagtionController extends AbstractController
{
    #[Route('/naviagtion', name: 'app_naviagtion')]
    public function index(): Response
    {
        return $this->render('naviagtion/index.html.twig', [
            'controller_name' => 'NaviagtionController',
        ]);
    }
}
