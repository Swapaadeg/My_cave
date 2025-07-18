<?php

namespace App\Form;

use App\Entity\Caves;
use App\Entity\Bouteilles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddBouteillesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('region')
            ->add('pays')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Rouge' => 'rouge',
                    'Blanc' => 'blanc',
                    'Rosé' => 'rosé',
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('millesime')
            ->add('cepage')
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
