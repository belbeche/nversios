<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class, [
                'attr' => [
                    'placeholder' => 'votre email'
                ],
            ])
            ->add('username', TextType::class,[
                'attr' => [
                    'placeholder' => 'identifiant de connexion'
                ],
            ])
            ->add('password', PasswordType::class,[
                'attr' => [
                    'placeholder' => 'Votre mot de passe'
                ],
            ])
            ->add('confirm_password', PasswordType::class,[
                'attr' => [
                    'placeholder' => 'Répetez votre mot de passe'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
