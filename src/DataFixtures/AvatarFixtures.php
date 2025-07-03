<?php
// src/DataFixtures/AvatarFixtures.php

namespace App\DataFixtures;

use App\Entity\Avatar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AvatarFixtures extends Fixture
{
    public const AVATAR_REFERENCE = 'avatar_';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 10; $i++) {
            $avatar = new Avatar();
            $avatar->setImage($faker->imageUrl(200, 200, 'people'));

            $manager->persist($avatar);
            $this->addReference(self::AVATAR_REFERENCE . $i, $avatar);
        }

        $manager->flush();
    }
}