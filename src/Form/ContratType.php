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

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_debut')
            ->add('date_fin')
            ->add('montant')
            ->add('statut')
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
            ->add('date_creation')
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
