<?php
namespace App\Security;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    const EDIT = 'USER_EDIT';
    protected function supports (string $attribute, $subject):bool
    {
        return $attribute === self::EDIT && $subject instanceof User;
    }
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $connectedUser = $token->getUser();
        if (!$connectedUser instanceof User) {
            return false;
        }
        /** @var User $userToEdit */
        $userToEdit = $subject;
         // Autoriser uniquement si l'utilisateur essaie de modifier ses propres données
        return $connectedUser === $userToEdit;
    }
}