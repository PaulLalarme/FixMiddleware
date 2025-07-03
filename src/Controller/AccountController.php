<?php 
namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


// la classe accountcontroller prends les paramètres d'abstractcontroller
class AccountController extends AbstractController
{
    #[Route('/compte', name: 'compte')]
    public function edit(
        Request $request,              // la request est définie $request
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ) {
        /** @var User $user */
        $user = $this->getUser();    //déclare $user et récupère l'utilisateur
        
        $this->denyAccessUnlessGranted('USER_EDIT', $user);

        $form = $this->createForm(AccountType::class, $user); // créer ce formulaire avec les données user

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { // si le formulaire est soumis et valide
            $plainPassword = $form->get('plainPassword')->getData();  // recupère la data plainpassword du formulaire en tant que $plainpassword

            if (!empty($plainPassword)) { // si le mdp est vide
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword); 
                $user->setPassword($hashedPassword);
            }

            $em->flush(); // l'entitymanager reinitialise la demande de récupération d'objet dans la queue

            $this->addFlash('success', 'Vos informations ont été mises à jour.'); // ajoute un message flash
            return $this->redirectToRoute('compte'); // redirige
        }

        return $this->render('accountpage/accountpage.html.twig', [
            'accountForm' => $form->createView(),
        ]);
    }
}