<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker ;

    public function __construct()
    {   
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i <= 20; $i++) { 
            // $cours = new Cours();
            // $cours->setName($this->faker->word());      
            
            // $manager->persist($cours);
        }

        

        $manager->flush();
    }
}
