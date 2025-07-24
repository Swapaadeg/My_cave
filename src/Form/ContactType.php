<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Votre pseudo',
                'attr' => ['class' => 'form-input'],
                'row_attr' => ['class' => 'form-group']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => ['class' => 'form-input'],
                'row_attr' => ['class' => 'form-group']
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'attr' => ['class' => 'form-input', 'rows' => 6],
                'row_attr' => ['class' => 'form-group full-width']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn'],
                'row_attr' => ['class' => 'form-actions full-width']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
