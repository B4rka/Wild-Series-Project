<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

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
    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $programType){
            $program = new Program();
            $program->setTitle($programType['title']);
            $program->setSynopsis($programType['synopsis']);
            $program->setCategory($this->getReference($programType['category']));
            $manager->persist($program);
        }
        $arcane = new Program();
        $arcane->setTitle('Arcane');
        $arcane->setSynopsis('Une histoire de vengeance et de rédemption');
        $arcane->setCategory($this->getReference('category_Animation'));
        $this->addReference('program_Arcane', $arcane);
        $manager->persist($arcane);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class,
            ];
    }
}
