<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('username')
            ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les mots de passe ne correspondent pas.',
                    'required' => true,
                    'first_options'  => [
                        'label' => 'Mot de passe',
                        'constraints' => [
                            new NotBlank(['message' => 'Le mot de passe est obligatoire']),
                            new Length([
                                'min' => 6,
                                'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                                    ])
                                ],
                            ],
                            'second_options' => ['label' => 'Confirmation du mot de passe'],
                    ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
