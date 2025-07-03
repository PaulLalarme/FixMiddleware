<?php
// src/DataFixtures/CategoryFixtures.php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_REFERENCE = 'category_';

    public function load(ObjectManager $manager): void
    {
        $categories = [
            ['name' => 'Concert',    'color' => 'red'],
            ['name' => 'Meetup',     'color' => 'green'],
            ['name' => 'Workshop',   'color' => 'blue'],
            ['name' => 'Conference', 'color' => 'orange'],
            ['name' => 'Webinar',    'color' => 'purple'],
        ];

        foreach ($categories as $i => $data) {
            $cat = new Category();
            $cat->setName($data['name'])
                ->setColor($data['color']);

            $manager->persist($cat);
            $this->addReference(self::CATEGORY_REFERENCE . ($i + 1), $cat);
        }

        $manager->flush();
    }
}
