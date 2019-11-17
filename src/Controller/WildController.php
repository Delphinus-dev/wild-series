<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class WildController extends AbstractController
{
    public function index() :Response
    {
        /**
         * @Route("/wild", name="wild_index")
         */
            return $this->render('wild/index.html.twig', ['website' => 'Wild Séries']);
    }
}
