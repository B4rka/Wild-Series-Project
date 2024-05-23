<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    const CATEGORIES =['Action','Aventure','Animation','Fantastique','Horreur', 'Humour'];
    public function load(ObjectManager $manager): void
    {
        //foreach (self::CATEGORIES as $key => $categoryName) {
            //$category = new Category();
            //$category->setName($categoryName);
            //$manager->persist($category);
            //$this->addReference('category_'.$categoryName, $category);
        //}

        $faker = Factory::create();

        for($i = 1; $i <= 5; $i++) {
            $category = new Category();

            $category->setName($faker->word());

            $manager->persist($category);

            $this->addReference('category_' . $i, $category);
        }

        $manager->flush();
    }
}
