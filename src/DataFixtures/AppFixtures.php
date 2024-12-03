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
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Création de 5 catégories
        for ($i = 0; $i < 5; $i++) {
            $categorie = new Categories();
            $categorie->setName($faker->word);

            $manager->persist($categorie);

            // Création de 3 produits pour chaque catégorie
            for ($j = 0; $j < 3; $j++) {
                $produit = new Produits();
                $produit->setName($faker->word)
                        ->setDescription($faker->sentence)
                        ->setPrix($faker->randomFloat(2, 5, 100))
                        ->setCategorie($categorie);  // Associer le produit à la catégorie

                $manager->persist($produit);
            }
        }

        $manager->flush();
    }
        

      
    
}
