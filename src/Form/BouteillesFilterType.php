<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\Pays;
use App\Entity\Region;
use App\Entity\Cepage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BouteillesFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false,
                'label' => 'Nom',
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'label' => 'Type',
            ])
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'nom',
                'required' => false,
                'placeholder' => 'Tous les pays',
                'label' => 'Pays',
                'attr' => [
                    'class' => 'filter-pays',
                    'data-target' => 'filter-region'
                ]
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'nom',
                'required' => false,
                'placeholder' => 'Toutes les régions',
                'label' => 'Région',
                'attr' => [
                    'class' => 'filter-region'
                ]
            ])
            ->add('cepage', EntityType::class, [
                'class' => Cepage::class,
                'choice_label' => 'nom',
                'required' => false,
                'placeholder' => 'Tous les cépages',
                'label' => 'Cépage',
            ])
            ->add('millesime', IntegerType::class, [
                'required' => false,
                'label' => 'Millésime',
                'attr' => [
                    'min' => 1900,
                    'max' => (int) (new \DateTime())->format('Y'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
