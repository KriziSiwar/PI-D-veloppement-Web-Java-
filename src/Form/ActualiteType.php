<?php

namespace App\Form;

use App\Entity\Actualite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ActualiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Title cannot be blank.']),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'Title cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('date_publication', DateType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Publication date cannot be blank.']),
                ],
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Description cannot be blank.']),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'Description cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('categorie', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Category cannot be blank.']),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'Category cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('image', FileType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Image path cannot be blank.']),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'Image path cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actualite::class,
        ]);
    }
}
