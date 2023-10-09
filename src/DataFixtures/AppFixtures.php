<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Recette;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;
    public function __construct () {
        $this->faker = Factory::create('fe_FR');

    }

    public function load(ObjectManager $manager): void
    {
        $ingredients = [];
         for ($i = 0; $i < 50 ; $i ++)
         {
             $ingredient = new Ingredient();
             $ingredient->setName($this->faker->word())
                 ->setPrice(mt_rand(0, 100));
             $manager->persist($ingredient);
             $ingredients[] = $ingredient;
         }

        for ($i = 0; $i < 20 ; $i++){
            $recette = new Recette();
            $recette ->setDescription($this -> faker -> text())
                -> setName($this -> faker ->word())
                -> setIsFavorite((bool) mt_rand(0,1))
                -> setPrice(mt_rand(0,50))
                -> setTime(mt_rand(0,60))
                -> setNumberOfPerson(4)
                -> setLvlDifficult(mt_rand(1,3));
            $ingredientCount = (mt_rand(3,6));
            for ($y = 0; $y < $ingredientCount; $y++){
                $recette -> addIngredient($ingredients[mt_rand(0,count($ingredients)-1)]);
            }

            $manager -> persist($recette);
        }

        $manager ->flush();





    }

}
