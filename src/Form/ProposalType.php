<?php

namespace App\Form;

use App\Entity\Proposal;
use App\Entity\Freelancer;
use App\Entity\PostedJobs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Count;

class ProposalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a title.']),
                    new Length(['max' => 255, 'maxMessage' => 'Title cannot be longer than 255 characters.']),
                ],
            ])
            ->add('description', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a description.']),
                    new Length(['max' => 255, 'maxMessage' => 'Description cannot be longer than 255 characters.']),
                ],
            ])
            ->add('client', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a client name.']),
                    new Length(['max' => 255, 'maxMessage' => 'Client name cannot be longer than 255 characters.']),
                ],
            ])
            ->add('budget', NumberType::class, [
                'scale' => 2,
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a budget.']),
                    new Range(['min' => 0, 'minMessage' => 'Budget must be at least 1.']),
                ],
            ])
            ->add('delai', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a deadline.']),
                    new Length(['max' => 255, 'maxMessage' => 'Deadline cannot be longer than 255 characters.']),
                ],
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Disponible' => 'disponible',
                    'Non Disponible' => 'non disponible',
                ],
                'label' => 'Statut',
                'constraints' => [
                    new NotBlank(['message' => 'Please select a status.']),
                ],
            ])
            ->add('date_soummission', null, [
                'constraints' => [
                    new NotNull(['message' => 'Please enter a submission date.']),
                ],
            ])
            ->add('date_debut', null, [
                'constraints' => [
                    new NotNull(['message' => 'Please enter a start date.']),
                ],
            ])
            ->add('date_fin', null, [
                'constraints' => [
                    new NotNull(['message' => 'Please enter an end date.']),
                ],
            ])
            ->add('freelancer', EntityType::class, [
                'class' => Freelancer::class,
                'multiple' => true,
                'expanded' => false,
                'choice_label' => 'name',
                'label' => 'Freelancer',
                'constraints' => [
                    new NotBlank(['message' => 'Please select at least one freelancer.']),
                    new Count(['min' => 1, 'minMessage' => 'Please select at least one freelancer.']),
                ],
            ])
            ->add('postedJobs', EntityType::class, [
                'class' => PostedJobs::class,
                'multiple' => true,
                'expanded' => false,
                'choice_label' => 'title',
                'label' => 'Posted Jobs',
                'constraints' => [
                    new NotBlank(['message' => 'Please select at least one posted job.']),
                    new Count(['min' => 1, 'minMessage' => 'Please select at least one posted job.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Proposal::class,
            'html5' => true,
            'attr' => ['novalidate' => 'novalidate'],
        ]);
    }
}
