<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Rouge' => 'rouge',
                    'Blanc' => 'blanc',
                    'Rosé'  => 'rosé',
                ],
                'multiple' => true,      // Pour permettre plusieurs choix
                'expanded' => true,      // Pour afficher en cases à cocher (checkbox)
                'label' => 'Type',
            ])
            ->add('pays', TextType::class, [
                'required' => false,
                'label' => 'Pays',
            ])
            ->add('region', TextType::class, [
                'required' => false,
                'label' => 'Région',
            ])
            ->add('cepage', TextType::class, [
                'required' => false,
                'label' => 'Cépage',
            ])
            ->add('millesime', IntegerType::class, [
                'required' => false,
                'label' => 'Millésime',
                'attr' => [
                    'min' => 1900,
                    'max' => (new \DateTime())->format('Y'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET'
        ]);
    }
}
