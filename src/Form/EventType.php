<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
        ->add('title', TextType::class)
            ->add('description', TextType::class)

            ->add('start_date', DateType::class, [
                'widget' => 'single_text',
                'required' => false, // Allow null values


                'constraints' => [
                    new NotBlank(),
                ],

            ])
            ->add('end_date', DateType::class, [
                'widget' => 'single_text',
                'required' => false, // Allow null values

                'constraints' => [
                    new NotBlank(),
                ],

            ])
            ->add('location', TextType::class)
            
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Actif' => 'actif',
                    'Annulé' => 'annulé',
                    'Reporté' => 'reporté',
                ],
                'attr' => ['class' => 'form-control'],
            ])






            ->add('nb_participant', IntegerType::class)
            ->add('image', FileType::class, [
                'label' => 'Image (JPG, PNG or GIF file)',
                'constraints' => [
                    new NotBlank(['message' => 'Please upload an image']),
                ],
            ])
                
            ->add('save', SubmitType::class); 

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
