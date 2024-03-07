<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('FirstName')
            ->add('LastName')
            ->add('ProfilePicture')
            ->add('JobTitle')
            ->add('ProfessionalOverview')
            ->add('Expertise')
            ->add('Phone')
            ->add('rate')
            ->add('language')
            ->add('CompanyName')
            ->add('CompanyDescription')
            ->add('industry')
            ->add('companyWebsite')
            ->add('companyLogo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
