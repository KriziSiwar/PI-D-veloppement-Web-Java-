<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Intl\Intl; // Add this line


class CompleteRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
$builder



->add('ProfilePicture', FileType::class, [
    'required' => false,
    'data_class' => null, // Add this line

])
    ->add('JobTitle', null, [
        'required' => false,
    ])
    ->add('ProfessionalOverview', TextareaType::class, [
        'required' => false,
        'attr' => ['rows' => '20'], // Set the number of rows
    ])
    ->add('Expertise', ChoiceType::class, [
        'choices'  => [
            'Entry Level' => 'Entry Level ',
            'Intermidiaire' => 'Intermidiaire ',
            'Expert' => 'Expert',

            // Add more options here
        ],
        'required' => false,
    ])
    ->add('Phone', IntegerType::class, [
        'required' => false,
        'constraints' => [
            new Regex([
                'pattern' => '/^\d{8}$/',
                'message' => 'Please enter a valid phone number.',
            ]),
        ],
    ])
   
    ->add('language', ChoiceType::class, [
        'choices'  => [
            'English' => 'English',
            'Spanish' => 'Spanish',
            'French' => 'French',
            'Standard Arabic' => 'Standard Arabic',
            'Bengali' => 'Bengali',
            'Russian' => 'Russian',
            'Portuguese' => 'Portuguese',
            'Indonesian' => 'Indonesian',
            'Mandarin Chinese' => 'Mandarin Chinese',
            'Hindi' => 'Hindi',


        ],
        'multiple' => true,
    ]);
    
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
