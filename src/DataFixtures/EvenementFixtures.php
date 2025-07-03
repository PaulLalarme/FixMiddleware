<?php
// src/DataFixtures/EvenementFixtures.php
namespace App\DataFixtures;

use App\Entity\Evenements;
use App\Entity\Category;
use App\Entity\Departements;
use App\Repository\CategoryRepository;
use App\Repository\DepartementsRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class EvenementFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private DepartementsRepository $departementsRepo,
        private CategoryRepository     $categoryRepo
    ){}

    public function load(ObjectManager $manager): void
    {
        $faker      = Factory::create('fr_FR');
        $categories = $this->categoryRepo->findAll();
        $departements = $this->departementsRepo->findAll(); // récupère bien les entités !

        if (count($categories) === 0 || count($departements) === 0) {
            throw new \LogicException('Il faut d’abord charger CategoryFixtures et DepartementFixtures');
        }

        for ($i = 0; $i < 20; $i++) {
            $e = new Evenements();

            // 1) category
            $e->setCategory(
                $categories[array_rand($categories)]
            );

            // 2) département : on choisit au hasard une entité Departements
            /** @var Departements $depEntity */
            $depEntity = $departements[array_rand($departements)];
            // ATTENTION : ta méthode s’appelle peut-être setDepartement(), ou setLocation()
            // selon ton mapping. Ici on suppose setDepartement().
            $e->setLocation($depEntity);

            // 3) le reste
            $e->setName($faker->sentence(3))
              ->setDescription($faker->paragraph)
              ->setPrice($faker->randomFloat(2, 10, 200))
              ->setImg($faker->imageUrl(640, 480, 'events', true))
              ->setTime($faker->dateTimeBetween('-1 years', '+1 years'));

            $manager->persist($e);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            DepartementFixtures::class, // il faut aussi une fixture qui crée les Departements
        ];
    }
}