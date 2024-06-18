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
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


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
            ->add('client')
            ->add('freelancer')
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
            ->add('statut')
            ->add('date_soummission', null, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('date_debut', null, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('date_fin', null, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(),
                    new Callback([$this, 'validateDates']),
                ],
            ])
            ->add('fichiers') ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Proposal::class,
            'html5' => true,
            'attr' => ['novalidate' => 'novalidate'],
        ]);
    }

    public function validateDates($data, ExecutionContextInterface $context)
    {
        // Get the start date from the form data
        $startDate = $context->getRoot()->get('date_debut')->getData();

        if ($startDate > $data) {
            $context->buildViolation('End date must be after start date.')
                ->atPath('date_fin')
                ->addViolation();
        }
    }
}
