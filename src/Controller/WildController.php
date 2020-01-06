<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/wild", name="wild_")
 * @return Response A response instance
 */
class WildController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index() :Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this-> createNotFoundException(
                'No program found in program\'s table'
            );
        }
            return $this->render('wild/index.html.twig', ['programs' => $programs]);
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-zA-Z0-9\-\s]+$>?}", name="show")
     * @return Response
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }

        $slug = preg_replace('/-/', ' ', ucwords(trim(strip_tags($slug)), "-"));

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]); // OU : findOneByTitle(mb_strtolower($slug)
        $seasons = $program->getSeasons();

        if (!$program) {
            throw $this->createNotFoundException('No program with '.$slug.' title found in program\'s table.');
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug' => $slug,
            'seasons' => $seasons,
        ]
        );
    }

    /**
     * @Route("/category", name="add_category")
     * @param Request $request
     * @return Response
     */
    public function addCategory(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $category =  new Category();
        $form = $this->createForm(CategoryType::class,$category,['method' => Request::METHOD_POST]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
        }
        return $this->render('wild/add_category.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Getting programs in a category
     *
     * @param string $categoryName
     * @Route("/category/{categoryName<^[a-z0-9-]+$>?}", name="show_category")
     * @return Response
     */
    public function showByCategory(string $categoryName) : Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $category->getId()], ['id' => 'DESC'], 3);
        return $this->render('wild/category.html.twig', [
                'category' => $categoryName,
                'programs' => $program,
            ]
        );
    }

    /**
     * @Route("/episode/{id}", name="show_episode")
     */
    public function showEpisode(Episode $episode) : Response
    {
        $season = $episode->getSeasonId();
        $program = $season->getProgramId();

        return $this->render('wild/episode.html.twig', [
            'episode' => $episode,
            'season' => $season,
            'program' => $program,
            ]
        );
    }

    /**
     * Getting episodes in a season
     *
     * @param integer $id
     * @Route("/season/{id<^[0-9-]+$>?}", name="show_season")
     * @return Response
     */
    public function showBySeason(int $id) : Response
    {
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $id]);
        $episodes = $season->getEpisodes();
        $program = $season->getProgramId()->getTitle();
        return $this->render('wild/season.html.twig',
            [
                'season' => $season,
                'episodes' => $episodes,
                'program' => $program,
            ]
        );
    }

    /**
     * @Route("/actor/{id}", name="actor_show", methods={"GET"})
     * @param Actor $actor
     * @return Response
     */
    public function showActor(Actor $actor): Response
    {
        $programs = $actor->getPrograms();

        return $this->render('wild/actor.html.twig', [
            'actor' => $actor,
            'programs' => $programs,
            ]
        );
    }
}
