<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Range;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('auteur', null, [
                'constraints' => [
                    new NotBlank(['message' => 'The author cannot be blank.']),
                ],
            ])
            ->add('commentaire', null, [
                'constraints' => [
                    new NotBlank(['message' => 'The comment cannot be blank.']),
                ],
            ])
            ->add('date_publication', null, [
                'constraints' => [
                    new NotNull(['message' => 'The publication date cannot be null.']),
                    new Type([
                        'type' => \DateTimeInterface::class,
                        'message' => 'Invalid date format.',
                    ]),
                ],
            ])
            ->add('note', null, [
                'attr' => [
                    'placeholder' => 'Enter a note (1-5)',
                ],
                'constraints' => [
                    new NotNull(['message' => 'The note cannot be null.']),
                    new Type([
                        'type' => 'integer',
                        'message' => 'The note must be a valid number.',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 5,
                        'minMessage' => 'The note must be at least 1.',
                        'maxMessage' => 'The note cannot be more than 5.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
