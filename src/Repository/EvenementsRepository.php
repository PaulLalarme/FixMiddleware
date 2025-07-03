<?php

namespace App\Repository;

use App\Entity\Evenements;
use App\Entity\Departements;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class EvenementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenements::class);
    }
/**
     * @param Departements|null $departement
     * @param Category|null     $category
     * @param string|null       $dateRange    one of: 'this_week', 'weekend', 'this_month', 'upcoming'
     *
     * @return Evenements[]
     */
    public function findByFilters(
        ?Departements $departement,
        ?Category    $category,
        ?string      $dateRange
    ): array {
        $qb = $this->createQueryBuilder('e')
            ->innerJoin('e.category', 'c')
            ->addSelect('c');

        // Filtrer sur l'association location (qui est un Departements)
        if ($departement) {
            $qb->andWhere('e.location = :loc')
               ->setParameter('loc', $departement);
        }

        // Filtrer sur l'association category
        if ($category) {
            // Note : on pourrait aussi faire ->andWhere('c = :cat')
            $qb->andWhere('e.category = :cat')
               ->setParameter('cat', $category);
        }

        // Filtre par date (comme avant)…
        if ($dateRange) {
            $now = new \DateTimeImmutable();
            switch ($dateRange) {
                case 'Cette semaine':
                    $start = $now->modify('monday this week')->setTime(0, 0);
                    $end   = $now->modify('sunday this week')->setTime(23, 59, 59);
                    break;
                case 'Ce weekend':
                    $start = $now->modify('saturday this week')->setTime(0, 0);
                    $end   = $now->modify('sunday this week')->setTime(23, 59, 59);
                    break;
                case 'Ce mois-ci':
                    $start = $now->modify('first day of this month')->setTime(0, 0);
                    $end   = $now->modify('last day of this month')->setTime(23, 59, 59);
                    break;
                case 'À venir':
                    $qb->andWhere('e.time > :now')
                       ->setParameter('now', $now);
                    $start = $end = null;
                    break;
                default:
                    $start = $end = null;
            }

            if (isset($start, $end) && $start && $end) { // si $start et $end sont paramétrés
                $qb->andWhere('e.time BETWEEN :start AND :end') // et où le paramètre est compris entre start et end 
                   ->setParameter('start', $start)
                   ->setParameter('end',   $end);
            }
        }

        return $qb
            ->orderBy('e.time','ASC')
            ->getQuery()
            ->getResult();
    }
}
