<?php

namespace App\DataFixtures;

use App\Entity\Produits;
use App\Entity\Categories;
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

                $produits = new Produits();
                $produits->setName($this->faker->word());    
                $produits->setPrix(mt_rand(0, 100));  
                $produits->setDescription($this->faker->word(15));  
                $produits->setCategorie($this->faker->word(15));  
                
                
             

                $categories = new Categories();
                $categories->setName($this->faker->word());


                $manager->persist($produits);
                $manager->persist($categories);
        }

        

        $manager->flush();
    }
}
