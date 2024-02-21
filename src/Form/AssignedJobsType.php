<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\AssignedJobs;
use App\Entity\Freelancer;
use App\Entity\PostedJobs;
use Symfony\Component\Validator\Constraints\NotBlank;

class AssignedJobsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Add other fields as needed
            ->add('start_date')
            ->add('end_date')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Job Open' => 'job open',
                    'Job Closed' => 'job closed',
                ],
                'label' => 'Status',
                'constraints' => [
                    new NotBlank(['message' => 'Please select a status.']),
                ],
            ])
            // Add the freelancer field
            ->add('freelancerId', EntityType::class, [
                'class' => Freelancer::class,
                'multiple' => true, // Assuming it's a ManyToMany relationship
                'expanded' => false, // Display as checkboxes or a select dropdown
                'choice_label' => 'name', // Change to the appropriate property
                'label' => 'Freelancers',
                'constraints' => [
                    new NotBlank(['message' => 'Please select at least one freelancer.']),
                ],
            ])
            // Add the postedJob field
            ->add('postedJobs', EntityType::class, [
                'class' => PostedJobs::class,
                'choice_label' => 'title',
                'label' => 'Posted Job',
                'multiple' => true, // Assuming it's a ManyToMany relationship
                'expanded' => false, // Adjust as needed
                'constraints' => [
                    new NotBlank(['message' => 'Please select at least one posted job.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => AssignedJobs::class,
        ]);
    }
}
