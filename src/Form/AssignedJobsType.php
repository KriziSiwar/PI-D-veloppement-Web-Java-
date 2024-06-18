<?php

namespace App\Form;
use App\Entity\Contrat;
use App\Entity\AssignedJobs;
use App\Entity\PostedJobs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssignedJobsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('end_date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('status', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
          
            ->add('no', EntityType::class, [
                'class' => Contrat::class,
                'choice_label' => 'id', 
            ])
           

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AssignedJobs::class,
            'jobs' => [],
        ]);
    }
}
