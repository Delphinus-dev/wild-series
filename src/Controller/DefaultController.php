<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index() :Response
    {
        /**
         * @Route("/app", name="app_index")
         */
        return $this->render('home.html.twig', ['site' => 'Wild Séries']);
    }
}
