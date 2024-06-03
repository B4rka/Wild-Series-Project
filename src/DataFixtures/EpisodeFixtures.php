<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Season;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODES = [
        [
            'title' => 'Welcome to the Playground',
            'number' => 1,
            'synopsis' => 'Orphaned sisters Vi and Powder bring trouble to Zaun\'s underground streets in the wake of a heist in posh Piltover.'
        ],
        [
            'title' => 'Some Mysteries Are Better Left Unsolved',
            'number' => 2,
            'synopsis' => 'Idealistic inventor Jayce attempts to harness magic through science --- despite his mentor\'s warning. Criminal kingpin Silco tests a powerful substance.'
        ],
        [
            'title' => 'The Base Violence Necessary for Change',
            'number' => 3,
            'synopsis' => 'An epic showdown between old rivals results in a fateful moment for Zaun. Jayce and Viktor risk it all for their research.'
        ],
        ];

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        $ref = 0;
        $faker = Factory::create();
        for($i = 1; $i <= 50; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                $episode = new Episode();
                $episode->setNumber($j);
                $episode->setTitle($faker->words(3, true));
                $episode->setSynopsis($faker->sentence());
                $episode->setDuration($faker->numberBetween(40, 59));
                $slug = $this->slugger->slug($episode->getTitle());
                $episode->setSlug($slug);
                $episode->setSeason($this->getReference('season_' . $ref));
                $manager->persist($episode);

            }
            $ref++;
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SeasonFixtures::class,
        ];
    }
}
