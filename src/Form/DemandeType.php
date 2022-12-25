<?php

namespace App\Form;

use App\Entity\Tickets;
use App\Entity\Themes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',ChoiceType::class,[
                'choices' => [
                    'Conception de site internet' => 'Conception de site internet',
                    'Modification site existant' => 'Modification site existant',
                    'Evoluer un site' => 'Evoluer un site',
                    'Améliorer ma visibilité sur le web' => 'Améliorer ma visibilité sur le web',
                    'Demande spécifiques' => 'Demande spécifiques'
                ]
            ])
            ->add('contenu')
            ->add('image')
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('adresse')
            ->add('telephone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tickets::class,
        ]);
    }
}
