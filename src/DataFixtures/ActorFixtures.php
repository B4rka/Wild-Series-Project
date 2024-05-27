<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ActorFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 1; $i <= 10; $i++) {
            $actor = new Actor();

            $actor->setName($faker->firstName(). ' '. $faker->lastName());
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween(1, 7)));
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween(1, 7)));
            $actor->addProgram($this->getReference('program_' . $faker->numberBetween(1, 7)));

            $manager->persist($actor);

            $this->addReference('actor_' . $i, $actor);
        }

        $manager->flush();
    }

    public static function getGroups(): array
     {
         return ['group1', 'group2'];
     }

    public function getDependencies(): array
    {
        return [ProgramFixtures::class,
        ];
    }
}
