<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    CONST CATEGORIES = [
        'Horreur',
        'Comédie',
        'Action',
        'Aventure',
        'Animation',
        'Jeunesse',
        'Fantastique'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
        }
        $manager->flush();

        /*
        for ($i = 1; $i <= 50; $i++) {
            $category = new Category();
            $category->setName('Pouet ' . $i);
            $manager->persist($category);
        }
        $manager->flush();
        */
    }
}