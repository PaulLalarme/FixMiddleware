<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Modifier le pseudo',
                // 'constraints' => [
                // new Assert\NotBlank(),
                // ]
            ])
            ->add('email', EmailType::class, [
                'label' => "Modifier l'adresse e-mail",
                'constraints' => [
                    // new Assert\NotBlank(),
                    new Assert\Email()
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => 'N° de rue et adresse',
                // 'constraints' => [
                // new Assert\NotBlank(),
                // ]
            ])
            ->add('codepostal', TextType::class, [
                'label' => 'Code postal',
                // 'constraints' => [
                // new Assert\NotBlank(),
                // ]
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text', // pour un champ HTML5 avec un datepicker
        'required' => false,
                // 'constraints' => [
                // new Assert\NotBlank(),
                // ]
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                // 'constraints' => [
                // new Assert\NotBlank(),
                // ]
            ])

            ->add('plainPassword', PasswordType::class, [
                'label' => 'Nouveau mot de passe',
                'required' => false,
                'mapped' => false, // ne pas lier directement à l'entité
                'constraints' => [
                    new Assert\Length(['min' => 6]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
