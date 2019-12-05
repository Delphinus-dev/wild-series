<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/show/{slug<^[a-z0-9-]+$>?}", name="show")
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

        if (!$program) {
            throw $this->createNotFoundException('No program with '.$slug.' title found in program\'s table.');
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug' => $slug,
        ]);
    }

    /*
     // Getting a program with a formatted slug for title

     // @param string $slug The slugger
     // @Route("/show/{slug<^[a-z0-9-]+$>?}", name="show")
     // @return Response

    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }

        $slug = preg_replace('/-/', ' ', ucwords(trim(strip_tags($slug)), "-"));

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]); // OU : findOneByTitle(mb_strtolower($slug)

        if (!$program) {
            throw $this->createNotFoundException('No program with '.$slug.' title found in program\'s table.');
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug' => $slug,
        ]);
    }
    */

    /**
     * Getting programs in a category
     *
     * @param string $categoryName
     * @Route("/category/{categoryName<^[a-z0-9-]+$>?}", name="show_category")
     * @return Response
     */
        public function showByCategory(string $categoryName) : Response
        {
        $category = $this ->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name'=>$categoryName]);
        $program =  $this ->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category'=>$category->getId()], ['id'=>'DESC'], 3);
        return $this->render('wild/category.html.twig',
            ['category' => $categoryName,
                'programs' => $program,
            ]);

        /* mon ancien code, pour mémoire :

        // si slug catégorie vide :
        if (!$categoryName) {
            throw $this->createNotFoundException('No category has been chosen to find programs in program\'s table.');
        }
        // si slug catégorie présent, transformer en string avec espaces et majuscule au début :
        $categoryName = preg_replace('/-/', ' ', ucwords(trim(strip_tags($categoryName)), "-"));

        $category = $this ->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name'=>$categoryName]);
        // si la catégorie n'existe pas :
        if (!$categoryName) {
            throw $this->createNotFoundException('No existing category is called '.$category.'.');
        }
        // TODO corriger la suite
        // renvoyer un TABLEAU des 3 id derniers id de séries par ordre descendant :
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category_id' => $categoryName], ['id' => 'DESC'], 3, 1);

        return $this->render('wild/category.html.twig', [
            'program' => $program,
            'category' => $categoryName,
        ]);
        */
    }
}
