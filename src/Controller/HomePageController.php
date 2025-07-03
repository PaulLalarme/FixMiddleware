<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;
use App\Repository\DepartementsRepository;


final class HomePageController extends AbstractController
{

        #[Route('/', name: 'app_home_page', methods: ['GET'])]
    public function index(
        Request $request,
        DepartementsRepository $repoDepartement,
        CategoryRepository   $repoCategory
        // , PeriodRepository   $repoPeriod  // optionnel
    ): Response {
        $departements = $repoDepartement->findAll(); // déclare $departements qui contient la classe DepartementsRepository et qui trouve tout ce qu'elle contient 
        $categorys    = $repoCategory->findAll();
        $periodes     = [
            ['id'=>1,'nom'=>'Cette semaine'], // déclare période en tant que tableau
            ['id'=>2,'nom'=>'Ce weekend'],
            ['id'=>3,'nom'=>'Ce mois ci'],
            ['id'=>3,'nom'=>'À venir'],
        ];

        // Génère un array filters (vide ou avec valeurs GET)
        $filters = [
            'departement' => $request->query->get('departement', null),
            'category'    => $request->query->get('category',    null),
            'date'        => $request->query->get('date',        null),
        ];

        return $this->render('home_page/index.html.twig', // retourne cette vue avec les paramètres ci dessous
        [
             'departements' => $departements,
            'categorys'    => $categorys,
            'periods'      => $periodes,
            'filters'      => $filters,   // ← on rajoute ici
        ]
             );
    }

}
