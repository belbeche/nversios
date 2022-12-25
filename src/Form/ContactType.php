<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'fas fa-user prefix grey-text',
                ],
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'fas fa-envelope prefix grey-text'
                ],
            ])
            ->add('sujet',ChoiceType::class,[
                'choices' => [
                    'Conception de site internet' => 'Conception de site internet',
                    'Modification site existant' => 'Modification site existant',
                    'Evoluer un site' => 'Evoluer un site',
                    'Améliorer ma visibilité sur le web' => 'Améliorer ma visibilité sur le web',
                    'Demande spécifiques' => 'Demande spécifiques'
                ],
                'attr' => [
                    'class' => 'fas fa-tag prefix grey-text'
                ],
            ])
            ->add('contenu', TextareaType::class, [
                'attr' => [
                    'class' => 'fas fa-envelope prefix grey-text'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
