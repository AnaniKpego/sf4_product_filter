<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($cat = 0; $cat < 10; $cat++ ){

            $categorie = new Category();
            $categorie->setName( $faker->domainName)
                ->setCreatedAt($faker->dateTimeBetween('-5 days', 'now'))
            ;
            $manager->persist($categorie);

            for ( $i= 0; $i < 50; $i++){
                $product = new Product();
                $product->setName($faker->lastName)
                    ->setImage($faker->imageUrl(200, 150))
                    ->setPrice($faker->numberBetween(1500,25000))
                    ->setDescription($faker->text(200))
                    ->setContent($faker->text)
                    ->setCategories($categorie)
                    ->setPromo($faker->boolean)
                ;
                $manager->persist($product);

            }
        }




        // $manager->persist($product);

        $manager->flush();
    }
}
