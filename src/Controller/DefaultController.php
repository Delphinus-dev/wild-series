<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ProgramRepository $programRepository
     * @return Response
     */
    public function index(ProgramRepository $programRepository, SeasonRepository $seasonRepository) :Response
    {
        $programs = $programRepository->findAll();
        $seasons = $seasonRepository->findAll();

        if (!$programs) {
            throw $this-> createNotFoundException(
                'No program found'
            );
        }
        return $this->render('home.html.twig',
            [
                'programs' => $programs,
                'seasons' => $seasons,
                'site' => 'Wild Séries'
            ]
        );
    }
}
