<?php
// src/DataFixtures/UserFixtures.php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Avatar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // même cast qu’avant pour avoir le repo
        if (! $manager instanceof EntityManagerInterface) {
            throw new \LogicException('Expected EntityManagerInterface');
        }
        $em = $manager;

        // tous les avatars générés par AvatarFixtures
        $avatars = $em->getRepository(Avatar::class)->findAll();
        if (0 === \count($avatars)) {
            throw new \LogicException('Aucun avatar trouvé – avez-vous bien lancé AvatarFixtures ?');
        }

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $u = new User();
            $u->setEmail($faker->unique()->email)
              ->setUsername($faker->userName)
              ->setRoles($i === 0 ? ['ROLE_ADMIN'] : ['ROLE_USER'])
              ->setIsVerified($faker->boolean(80))
              ->setAvatar($avatars[array_rand($avatars)])
              ->setAdresse($faker->streetAddress)
              ->setVille($faker->city)
              ->setCodepostal((int) $faker->postcode)
              ->setBirthdate($faker->dateTimeBetween('-70 years', '-18 years'))
              ->setPassword(
                  $this->passwordHasher->hashPassword($u, 'password')
              );

            $em->persist($u);
        }

        $em->flush();
    }

    public function getDependencies(): array
    {
        return [
            AvatarFixtures::class,
        ];
    }
}
