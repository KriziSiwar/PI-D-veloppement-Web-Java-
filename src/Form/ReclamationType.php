<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;

use App\Entity\Freelancer;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('objet', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter an object.']),
                ],
            ])
            ->add('contenu', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter the content.']),
                ],
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Not Yet Accepted' => 'not yet accepted',
                    'Accepted' => 'accepted',
                ],
                'placeholder' => 'Choose an option',
                'constraints' => [
                    new NotBlank(['message' => 'Please select a status.']),
                ],
            ])
            ->add('date_reclamation', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a reclamation date.']),
                ],
            ])
            ->add('freelancer', EntityType::class, [
                'class' => Freelancer::class,
                'multiple' => true,
                'expanded' => false,
                'choice_label' => 'name',
                'label' => 'Freelancer',
                'constraints' => [
                    new NotBlank(['message' => 'Please select a freelancer.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
