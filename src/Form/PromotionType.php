<?php

namespace App\Form;

use App\Entity\Promotion;
<<<<<<< HEAD
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('QR_code')
            ->add('discount')
            ->add('event', EntityType::class, [
                'class' => 'App\Entity\Event',
                'choice_label' => 'id', // Assuming 'id' is the property of the Event entity you want to display in the dropdown
            ])
            ->add('save', SubmitType::class);
=======
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('QR_code')
            ->add('discount')
            ->add('id_event')
            ->add('event')
        ;
>>>>>>> e7a942a627c11e9012e547f10deb81e0778f5c0c
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
        ]);
    }
}
