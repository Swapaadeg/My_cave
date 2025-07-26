<?php

namespace App\Form;

use App\Entity\Bouteilles;
use App\Entity\Type;
use App\Entity\Pays;
use App\Entity\Region;
use App\Entity\Cepage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AddBouteillesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionner un type',
                'required' => true,
            ])
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionner un pays',
                'required' => true,
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionner une région',
                'required' => true,
            ])
            ->add('cepage', EntityType::class, [
                'class' => Cepage::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionner un cépage',
                'required' => true,
            ])
            ->add('millesime')
            ->add('description')
            ->add('imageFile', FileType::class, [
                'required' => false,
                'mapped' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPEG, PNG, GIF)',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bouteilles::class,
        ]);
    }
}
