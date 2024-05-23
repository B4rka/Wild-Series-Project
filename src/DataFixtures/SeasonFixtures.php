<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $ref = 0;
        $faker = Factory::create();
        for($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 5; $j++) {
                $season = new Season();
                $season->setNumber($j);
                $season->setYear(2024);
                $season->setDescription($faker->sentence(7, true));
                $season->setProgram($this->getReference('program_' . $i));

                $manager->persist($season);
                $this->addReference('season_' . $ref, $season);
                $ref++;
            }
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [ProgramFixtures::class,
        ];
    }
}
