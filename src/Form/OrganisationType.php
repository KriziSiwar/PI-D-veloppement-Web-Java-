<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Organisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class OrganisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('telephone')
            ->add('email')
            ->add('contact')
            ->add('domaine_activite', ChoiceType::class, [
                'choices' => [
                    'Développement Web et Mobile' => 'Développement Web et Mobile',
                    'Design et Créativité' => 'Design et Créativité',
                    'Rédaction et Traduction' => 'Rédaction et Traduction',
                    'Marketing et Ventes' => 'Marketing et Ventes',
                    'Support Administratif' => 'Support Administratif',
                    'Consulting et Business' => 'Consulting et Business',
                    'Technologie et Sciences' => 'Technologie et Sciences',
                    'Vidéo et Animation' => 'Vidéo et Animation',
                ]])
            ->add('ajouter', SubmitType::class)



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organisation::class,
        ]);
    }
}
