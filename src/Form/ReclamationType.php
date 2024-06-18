<?php

namespace App\Form;

use App\Entity\Freelancer;
use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;

use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use App\Repository\FreelancerRepository;  // Correct the namespace here

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
                    new Length(['max' => 255, 'maxMessage' => 'Title cannot be longer than 255 characters.']),
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
            ->add('date_reclamation', DateType::class, [
                'widget' => 'single_text',
                'required' => false, // Allow null values
    
    
                'constraints' => [
                    new NotBlank(),
                ],
    
            ])


            
            
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
           
        ]);
    }
}
