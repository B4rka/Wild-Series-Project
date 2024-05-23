<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $season = new Season();
        $season->setNumber(1);
        $season->setYear(2021);
        $season->setDescription('Championnes de leurs villes jumelles et rivales, deux sœurs se battent dans une guerre où font rage des technologies magiques et des perspectives diamétralement opposées.');
        $season->setProgram($this->getReference('program_Arcane'));
        $this->addReference('season1_Arcane', $season);
        $manager->persist($season);

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [ProgramFixtures::class,
        ];
    }
}
