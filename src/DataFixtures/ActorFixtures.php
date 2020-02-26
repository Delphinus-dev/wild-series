<?php


namespace App\DataFixtures;
use App\Service\Slugify;
use Faker;
use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
//    CONST ACTORS = [
//        'Andrew Lincoln',
//        'Norman Reedus',
//        'Lauren Cohan',
//        'Danai Gurira',
//        'Test Testera',
//        'Prout Pouet'
//    ];

    protected $faker;

    public function load(ObjectManager $manager)
    {
//        $i = 0;
//        foreach (self::ACTORS as $name => $data) {
//            $actor = new Actor();
//            $actor->setName($name);
//            $actor->addProgram($this->getReference('program_0')); // categorie_0 fait référence à la première catégorie générée.
//            $manager->persist($actor);
//            $this->addReference('actor_' . $i, $actor);
//            $i++;

        $this->faker = Faker\Factory::create('en_US');
        for($i = 0; $i < 50; $i++)
        {
            $actor = new Actor();
            $actor->setName($this->faker->name);
            $actor->addProgram($this->getReference('program_'.$this->faker->numberBetween(0, 5)));
            $actor->setSlug((new Slugify)->generate($actor->getName()));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
