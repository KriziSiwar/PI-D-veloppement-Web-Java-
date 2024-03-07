<?php

namespace App\Form;

use App\Entity\Organisation;
use App\Entity\User;
use App\Entity\Contrat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;
class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('date_debut', DateType::class, [
            'widget' => 'single_text',
            'required' => false, // Allow null values


            'constraints' => [
                new NotBlank(),
            ],

        ])
        ->add('date_fin', DateType::class, [
            'widget' => 'single_text',
            'required' => false, // Allow null values


            'constraints' => [
                new NotBlank(),
            ],

        ])
            ->add('montant')
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'en cours' => 'en cours',
                    'terminé' => 'terminé',
                    'Reporté' => 'reporté',
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('projet')
            ->add('freelancer')
            ->add('organisation', EntityType::class, [
                'class' => Organisation::class,
                'choice_label' => 'id', 
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id', 
            ])
            ->add('date_creation', DateType::class, [
                'widget' => 'single_text',
                'required' => false, // Allow null values
    
    
                'constraints' => [
                    new NotBlank(),
                ],
    
            ])
            ->add('description')
            ->add('ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
