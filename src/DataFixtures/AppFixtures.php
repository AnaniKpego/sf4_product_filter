<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

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

        for ($u = 0; $u < 10; $u++){

            $users = new User();
            $hashPassword = $this->encoder->encodePassword($users, "Password");
            $users->setEmail($faker->email)
                ->setCountry($faker->country)
                ->setCity($faker->city)
                ->setAdress($faker->address)
                ->setLastName($faker->name)
                ->setPostalCode($faker->postcode)
                ->setFirstName($faker->name)
                ->setPassword($hashPassword);

            $manager->persist($users);

        }

        // $manager->persist($product);

        $manager->flush();
    }
}
