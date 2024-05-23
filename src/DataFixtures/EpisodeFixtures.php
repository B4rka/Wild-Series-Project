<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

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
    public function load(ObjectManager $manager): void
    {
        foreach (self::EPISODES as $episodeData) {
            $episode = new Episode();
            $episode->setTitle($episodeData['title']);
            $episode->setNumber($episodeData['number']);
            $episode->setSeason($this->getReference('season1_Arcane'));
            $episode->setSynopsis($episodeData['synopsis']);
            $manager->persist($episode);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SeasonFixtures::class,
        ];
    }
}
