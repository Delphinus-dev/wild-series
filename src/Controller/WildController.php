<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{
    public function index() :Response
    {
        /**
         * @Route("/", name="index")
         */
            return $this->render('wild/index.html.twig', ['website' => 'Wild Séries']);
    }

    // TODO terminer la fonction suivante :

    // Si aucun slug n'est fourni, il faudra afficher “Aucune série sélectionnée, veuillez choisir une série” dans la balise h1

    /**
     * @Route("/show/{slug}", requirements={"slug"="\b[a-z0-9-]+\b"}, name="show")
     * @param string $slug
     * @return Response
     */
    public function show(string $slug = "noslug"): Response
    {
        $result = str_replace("-", " ", ucwords($slug));
        return $this->render('wild/show.html.twig', ['result' => $result,]);
    }
}
