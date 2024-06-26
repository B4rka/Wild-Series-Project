<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS =[
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Humour'
        ],
        [
            'title' => 'Un titre',
            'synopsis' => 'Une description',
            'category' => 'category_Humour'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Humour'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Humour'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Humour'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Horreur'
        ],
        [
            'title' => 'Un titre',
            'synopsis' => 'Une description',
            'category' => 'category_Horreur'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Horreur'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Horreur'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Horreur'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Action'
        ],
        [
            'title' => 'Un titre',
            'synopsis' => 'Une description',
            'category' => 'category_Action'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Action'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Action'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Action'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Aventure'
        ],
        [
            'title' => 'Un titre',
            'synopsis' => 'Une description',
            'category' => 'category_Aventure'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Aventure'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Aventure'
        ],
        [
            'title' => 'La cité de la peur',
            'synopsis' => 'un film qu\'il est rigolo',
            'category' => 'category_Aventure'
        ],
    ];

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($i = 1; $i <= 10; $i++) {
            $program = new Program();
            $program->setTitle($faker->words(3, true));
            $program->setSynopsis($faker->paragraphs(2, true));
            $program->setCategory($this->getReference('category_' . $faker->numberBetween(1, 5)));
            $program->setOwner($this->getReference('contributor_contributor@monsite.com'));
            $slug = $this->slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $manager->persist($program);
            $this->addReference('program_' . $i, $program);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class,
            ];
    }
}
