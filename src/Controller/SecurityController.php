<?php

namespace App\Controller;

// use App\Entity\User;
// use App\Form\AccountType;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    //     #[Route('/moncompte', name: 'account_page')]
    // public function moncompte(): Response
    // {
    //     return $this->render('accountpage/accountpage.html.twig', [
    //         'controller_name' => 'HomePageController',
    //     ]);
    // }
}

// class AccountController extends AbstractController
// {
//     #[Route('/compte', name: 'compte')]
//     public function edit(
//         Request $request,
//         EntityManagerInterface $em,
//         UserPasswordHasherInterface $passwordHasher
//     ) {
//         /** @var User $user */
//         $user = $this->getUser();

//         $form = $this->createForm(AccountType::class, $user);

//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             $plainPassword = $form->get('plainPassword')->getData();

//             if (!empty($plainPassword)) {
//                 $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
//                 $user->setPassword($hashedPassword);
//             }

//             $em->flush();

//             $this->addFlash('success', 'Vos informations ont été mises à jour.');
//             return $this->redirectToRoute('compte');
//         }

//         return $this->render('accountpage/accountpage.html.twig', [
//             'accountForm' => $form->createView(),
//         ]);
//     }
// }

