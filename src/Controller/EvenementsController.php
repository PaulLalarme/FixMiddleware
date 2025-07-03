<?php

namespace App\Controller;

use App\Entity\Evenements;
use App\Form\EvenementsForm;
use App\Repository\CategoryRepository;
use App\Repository\EvenementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\DepartementsRepository;
use Symfony\Component\Routing\Annotation\Route;

final class EvenementsController extends AbstractController
{

    // créer une route nommée app_evenements_new
    #[Route('/new', name: 'app_evenements_new', methods: ['GET', 'POST'])]
    //créer une fonction "new" avec la classe request et l'api qui créer l'instance
    // fonction qui instancie un evenement et si le formulaire est valide alors sauvegarde l'evenement
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    { // instancie un objet de la classe evenement
        $evenement = new Evenements(); // cree la variable $evenement, qui crée une nouvelle classe evenements
        // on déclare un objet qui contient un formulaire fournit avec symfony
        $form = $this->createForm(EvenementsForm::class, $evenement);// crée la variable form qui appelle l'objet présent et créer un formulaire de classe "evenementsform" avec comme donnée $evenement
        $form->handleRequest($request);// permet de gerer la maniere dont est validé le formulaire

        if ($form->isSubmitted() && $form->isValid()) { // si le formulaire est soumis et valide, crée l'objet
            // enregistre en BDD
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenements_index', [], Response::HTTP_SEE_OTHER); // redirige $this sur la route app_evenements_index
        }

        return $this->render('evenements/new.html.twig', [ // une fois le formulaire soumis, retourne ça à la vue avec l'evenement et le formulaire
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_evenements_show', methods: ['GET'])]
    public function show(EvenementsRepository $repoEvenement, int $id): Response
    {
        $evenement = $repoEvenement->find($id); // déclare la classe $evenement en tant que $repoevenement à partir d'une recherche d'$id
        // dd($evenement);
        return $this->render('evenements/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }



#[Route('/evenements', 'app_evenement_filter', methods: ['GET'])]
public function filter(
    Request $request,
    DepartementsRepository $repoDepartement,
    EvenementsRepository $repoEvenement,
    CategoryRepository $repoCategory): Response {

 // 1) Récupérer les codes/id depuis la query string
        $codeDep  = $request->query->get('departement');
        $idCat    = $request->query->get('category');
        $dateSel  = $request->query->get('date');

        // 2) Charger les entités correspondantes (ou null)
        $depEntity = $codeDep
            ? $repoDepartement->findOneBy(['code' => $codeDep])
            : null;

        $catEntity = $idCat
            ? $repoCategory->find((int) $idCat)
            : null;

        // 3) Appeler le finder mis à jour
        $evenements = $repoEvenement->findByFilters(
        $depEntity,    // instance de Departements|null
            $catEntity,    // instance de Category   |null
            $dateSel       // string|null
        );

        // 4) Charger aussi les listes pour la vue (combo-box)
        $departements = $repoDepartement->findAll();
        $categories   = $repoCategory->findAll();
        $periodes     = [
            ['id'=>1,'nom'=>'Cette semaine'],
            ['id'=>2,'nom'=>'Ce weekend'],
            ['id'=>3,'nom'=>'Ce mois-ci'],
            ['id'=>4,'nom'=>'À venir'],
        ];

        // dd($evenements);

        // 5) Renvoyer à Twig
        return $this->render('home_page/index.html.twig', [
            'departements' => $departements,
            'categorys'    => $categories,
            'periods'      => $periodes,
            'filters'      => [
                'departement' => $codeDep,
                'category'    => $idCat,
                'date'        => $dateSel,
            ],
            'evenements'   => $evenements,
       ]);
    }
}