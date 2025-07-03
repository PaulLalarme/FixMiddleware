<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Evenements;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // --- Création des catégories ---
        $categories = [];
        $categoryNames = ['Coup de Coeur', 'Musique', 'Jeux vidéos'];

        foreach ($categoryNames as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $categories[] = $category;
        }

        // --- Création des utilisateurs ---
        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setEmail("user$i@example.com");
            $user->setUsername("Utilisateur $i");

            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password123');
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);

            // --- Création d’évènements associés à l'utilisateur et à une catégorie ---
            for ($j = 1; $j <= 2; $j++) {
                $event = new Evenements();
                $event->setName("Événement $j de l'utilisateur $i");
                $event->setDescription("Description de l'événement $j de l'utilisateur $i.");
                $event->setTime(new \DateTime('2025-12-' . str_pad($j, 2, '0', STR_PAD_LEFT)));
                $event->setCategory($categories[array_rand($categories)]);
                $manager->persist($event);
            }
        }

        $manager->flush();
    }
}

