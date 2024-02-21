<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Date;
use App\Entity\PostedJobs;

class PostedJobsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Title cannot be blank.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Title cannot be longer than 255 characters.',
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Description cannot be blank.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Description cannot be longer than 255 characters.',
                    ]),
                ],
            ])
            ->add('required_skills', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Required skills cannot be blank.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Required skills cannot be longer than 255 characters.',
                    ]),
                ],
            ])
            ->add('budget_estimate', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Budget estimate cannot be blank.']),
                    new GreaterThan(['value' => 0, 'message' => 'Budget estimate must be greater than 0.']),
                ],
            ])
            ->add('start_date', DateType::class,)
            ->add('end_date', DateType::class, )
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Job Open' => 'job open',
                    'Job Closed' => 'job closed',
                ],
                'label' => 'Status',
                'constraints' => [
                    new NotBlank(['message' => 'Status cannot be blank.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostedJobs::class,
        ]);
    }
}
